package com.eprescribing.prescribe.user.controller;

import com.eprescribing.prescribe.common.validation.BaseValidator;
import com.eprescribing.prescribe.common.exceptions.ValidationException;
import com.eprescribing.prescribe.user.data.UserDto;
import com.eprescribing.prescribe.user.mapper.UserMapper;
import com.eprescribing.prescribe.user.model.UserEntity;
import com.eprescribing.prescribe.user.service.UserServiceImpl;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.validation.Validator;
import org.springframework.web.bind.annotation.*;

import javax.validation.constraints.NotNull;
import java.util.List;

@RestController
@RequestMapping("/api/users")
public class UserController {
    private final UserServiceImpl userService;

    private JavaMailSender mailSender;

    @Autowired
    private  PasswordEncoder passwordEncoder;

    public UserController(UserServiceImpl userService, Validator validator) {
        this.userService = userService;
    }

    @PostMapping("/save")
    public ResponseEntity<UserEntity> save(@RequestBody UserEntity user) {
        var isValid = BaseValidator.validateRequest(user);
        if (isValid.containsKey(false))
            throw new ValidationException("Validation errors occurred", isValid.get(false));
        user.setPassword(passwordEncoder.encode(user.getPassword()));

        return new ResponseEntity<>(UserMapper.INSTANCE.toEntity(this.userService.save(user)), HttpStatus.CREATED);
    }

    @GetMapping("/find-user-by-id/{id}")
    public ResponseEntity<UserDto> findById(@NotNull @PathVariable Long id) {
        final var user = this.userService.getUserById(id);
        return user.map(value -> new ResponseEntity<>(value, HttpStatus.OK)).orElseGet(() -> new ResponseEntity<>(HttpStatus.NOT_FOUND));
    }

    @GetMapping("/find-user-by-username/{username}")
    public ResponseEntity<UserDto> findByUserName(@NotNull @PathVariable String username) {
        final var user = this.userService.getUserByUserName(username);
        return user.map(value -> new ResponseEntity<>(value, HttpStatus.OK)).orElseGet(() -> new ResponseEntity<>(HttpStatus.NOT_FOUND));
    }

    @GetMapping("/find-all")
    public ResponseEntity<List<UserDto>> findAll(){

        return new ResponseEntity<>(this.userService.getAllUsers(), HttpStatus.OK);
    }




    @GetMapping("/find-all-pagable")
    public List<UserDto> getAllUsersPa(
            @RequestParam(defaultValue = "0") Integer pageNo,
            @RequestParam(defaultValue = "20") Integer pageSize,
            @RequestParam(defaultValue = "id") String sortBy) {
        return userService.getAllUserPagable(pageNo, pageSize, sortBy);
    }

    @PutMapping("/assignUserToOrganization/{userId}/{organizationId}")
    public ResponseEntity<UserDto> assignUserToOrganisation(@NotNull @PathVariable Long userId, @PathVariable Long organizationId) {
        return new ResponseEntity<>(this.userService.assignUserToOrganization( userId, organizationId), HttpStatus.CREATED);
    }

    @PutMapping("/update")
    public ResponseEntity<UserDto> updateUser(@RequestBody UserEntity user){
        var isValid = BaseValidator.validateRequest(user);
        if (isValid.containsKey(false)){
            throw new ValidationException("Validation errors occurred", isValid.get(false));
        }

        return new ResponseEntity<>(this.userService.updateUserById( user), HttpStatus.CREATED);
    }

    @DeleteMapping("/delete-by-id/{id}")
    public void delete(@NotNull @PathVariable Long id){
        this.userService.deleteUser(id);
    }








}