package com.eprescribing.prescribe.user.service;

import com.eprescribing.prescribe.common.exceptions.NotFoundException;
import com.eprescribing.prescribe.user.data.UserDto;
import com.eprescribing.prescribe.user.mapper.UserMapper;
import com.eprescribing.prescribe.user.model.UserEntity;
import com.eprescribing.prescribe.user.repository.UserRepository;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Sort;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import java.util.ArrayList;
import java.util.List;
import java.util.Optional;

@Service
public class UserServiceImpl implements UserService{

    private final UserRepository userRepository;


    private final PasswordEncoder passwordEncoder;

    public UserServiceImpl(UserRepository userRepository, PasswordEncoder passwordEncoder) {
        this.userRepository = userRepository;
        this.passwordEncoder = passwordEncoder;
    }

    @Override
    public UserDto save(UserEntity user) {
        var userItem=userRepository.save(user);
        return UserMapper.INSTANCE.fromEntity(userItem);
    }


    @Override
    public List<UserDto> getAllUsers() {
        List<UserEntity> allUsers= userRepository.findAll();

        List<UserDto> users= new ArrayList<>();
        for( UserEntity user:allUsers){
            UserDto convertedUser= UserMapper.INSTANCE.fromEntity(user);
            users.add(convertedUser);
        }
        return users;
    }

    @Override
    public List<UserDto> getAllUserPagable(Integer pageNo, Integer pageSize, String sortBy) {

        Pageable paging  = PageRequest.of(pageNo, pageSize, Sort.by(sortBy));

        Page<UserEntity> pagedUsers =userRepository.findAll(paging);


        List<UserDto> userDtos = new ArrayList<>();
        for (UserEntity user : pagedUsers.getContent()) {
            userDtos.add(UserMapper.INSTANCE.fromEntity(user));
        }

        return userDtos;
    }

    @Override
    public Optional<UserDto> getUserById(Long id) {
        if(userRepository.findById(id).isPresent()) {
            return Optional.ofNullable(UserMapper.INSTANCE.fromEntity(userRepository.findById(id).get()));
        }
        return Optional.empty();
    }

    @Override
    public Optional<UserDto> getUserByUserName(String username)
    {

        var foundUserDetails=userRepository.findByUsername(username);
        return Optional.of(UserMapper.INSTANCE.fromEntity(foundUserDetails.get()));
    }



    @Override
    public UserDto updateUserById( UserEntity user) {
      Optional<UserEntity> userToUpdate= userRepository.findById(user.getId());
      if(userToUpdate.isPresent()){
          userToUpdate.get().setUsername(user.getUsername());
          userToUpdate.get().setEmail(user.getEmail());
          userToUpdate.get().setPassword(passwordEncoder.encode(user.getPassword()));

            return UserMapper.INSTANCE.fromEntity(userRepository.save(userToUpdate.get()));

      }else{
          throw new NotFoundException("User to update not found");
      }
    }

    @Override
    public void deleteUser(Long id) {
        try{
         var userToBeDeactivated=   userRepository.findById(id);
         if(userToBeDeactivated.isPresent()){
             userToBeDeactivated.get().setEnabled(false);
             userRepository.save(userToBeDeactivated.get());
         }
        }catch(NotFoundException e){
            throw new NotFoundException("User to deactivate not found");
        }

    }

    @Override
    public void updateResetPasswordToken(String token, String email) throws NotFoundException {

        UserEntity user =  userRepository.findByEmail(email);

        if (user  != null){
            user.setResetPasswordToken(token);
            userRepository.save(user);
        } else  {
            throw  new NotFoundException("Could not find User with email"  + "  "  + email);
        }

    }

    @Override
    public UserDto getResetPasswordToken(String token) {


        return UserMapper.INSTANCE.fromEntity(userRepository.findByResetPasswordToken(token));
    }

    @Override
    public void updatePassword(UserDto user, String newPassword) {
        BCryptPasswordEncoder passwordEncoder = new BCryptPasswordEncoder();
        UserEntity userEntity = UserMapper.INSTANCE.toEntity(user);
        String encodedPassword = passwordEncoder.encode(newPassword);
        userEntity.setPassword(encodedPassword);

        user.setResetPasswordToken(null);
        userRepository.save(userEntity);
    }

    @Override
    public UserDto assignUserToOrganization(Long userId, Long organizationId)
    {
        var user=userRepository.findById(userId);

        if (user.isPresent()){
            return UserMapper.INSTANCE.fromEntity(userRepository.save(user.get()));
        }else{
          throw  new RuntimeException("user does not exist");
        }
    }
}
