package com.eprescribing.prescribe.config.security;

import com.eprescribing.prescribe.config.security.requests.LoginRequest;
import com.eprescribing.prescribe.config.security.responses.JwtResponse;
import com.eprescribing.prescribe.config.security.responses.MessageResponse;
import com.eprescribing.prescribe.roles.enums.RoleName;
import com.eprescribing.prescribe.roles.model.Role;
import com.eprescribing.prescribe.roles.repository.RolesRepository;
import com.eprescribing.prescribe.user.data.UserDto;
import com.eprescribing.prescribe.user.mapper.UserMapper;
import com.eprescribing.prescribe.user.model.UserEntity;
import com.eprescribing.prescribe.user.repository.UserRepository;
import com.eprescribing.prescribe.user.service.UserService;
import com.eprescribing.prescribe.utility.Utility;
import net.bytebuddy.utility.RandomString;
import org.springframework.data.repository.query.Param;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;

import javax.mail.MessagingException;
import javax.management.relation.RoleNotFoundException;
import javax.servlet.http.HttpServletRequest;
import java.io.UnsupportedEncodingException;
import java.util.HashSet;
import java.util.Optional;
import java.util.Set;

@CrossOrigin(origins = "*", maxAge = 36000)
@RestController
@RequestMapping("/api/auth")
public class AuthController {


    private final AuthenticationManager authenticationManager;


    private final UserRepository userRepository;


    private final RolesRepository roleRepository;


    private final JwtUtil jwtUtils;


    private final UserService userService;

    private final PasswordEncoder passwordEncoder;

    public AuthController(AuthenticationManager authenticationManager, UserRepository userRepository, RolesRepository roleRepository, JwtUtil jwtUtils, UserService userService, PasswordEncoder passwordEncoder) {
        this.authenticationManager = authenticationManager;
        this.userRepository = userRepository;
        this.roleRepository = roleRepository;
        this.jwtUtils = jwtUtils;
        this.userService = userService;
        this.passwordEncoder = passwordEncoder;
    }


    @PostMapping("/signin")
    public ResponseEntity<?> authenticateUser(@RequestBody LoginRequest loginRequest)  {

        Authentication authentication = authenticationManager.authenticate(new UsernamePasswordAuthenticationToken(loginRequest.getUsername(),loginRequest.getPassword()));

        SecurityContextHolder.getContext().setAuthentication(authentication);

        String jwt = jwtUtils.generateJwtToken(authentication);

        UserEntity userDetails = (UserEntity) authentication.getPrincipal();

        return ResponseEntity
                .ok(new JwtResponse(jwt, userDetails.getId(),
                        userDetails.getUsername(),
                        userDetails.getRoles(),
                        userDetails.getEmail()));
    }

    @PostMapping("/signup")
    public ResponseEntity<?> registerUser(@RequestBody UserEntity user) throws RoleNotFoundException {

        if (Boolean.TRUE.equals(userRepository.existsByUsername(user.getUsername()))) {
            return ResponseEntity.badRequest()
                    .body(new MessageResponse
                            ("Error: Username is already taken!"));
        }

        if (Boolean.TRUE.equals(userRepository.existsByEmail(user.getEmail()))) {
            return ResponseEntity.badRequest()
                    .body(new MessageResponse
                            ("Error: Email is already in use!"));
        }

        UserEntity createdUser = new UserEntity();
        createdUser.setEmail(user.getEmail());
        createdUser.setPassword(passwordEncoder.encode(user.getPassword()));
        createdUser.setUsername(user.getUsername());

        // Dynamically add roles to the user based on the signup request

        Set<Role> roles = new HashSet<>();

        Optional<Role> optionalRole = Optional.empty();

        if((user.getRoles() == null) ){
            optionalRole  = roleRepository.findRolesByRoleName(RoleName.valueOf("ROLE_USER"));
            optionalRole.ifPresent(roles::add);
        }else {
            for (Role roleName : user.getRoles()) {
                optionalRole  = roleRepository.findRolesByRoleName(RoleName.valueOf(String.valueOf(roleName.getRoleName())));
            }
            optionalRole.ifPresent(roles::add);
        }
        createdUser.setRoles(roles);

        return new ResponseEntity<>(userService.save(createdUser), HttpStatus.CREATED);

    }

    @PutMapping("/disable_user")
    public UserDto disableUser(@RequestParam Long  userId, @RequestParam Boolean isDisable){
        var user=userRepository.findById(userId);
        if (user.isPresent()){
            user.get().setEnabled(isDisable);
            var updatedUser=userRepository.save(user.get());
            return UserMapper.INSTANCE.fromEntity(updatedUser);
        }
        else{
            throw  new RuntimeException("No such user found");
        }

    }


    @PostMapping("/forgot_password")
    public String processForgotPassword(HttpServletRequest request, Model model) throws MessagingException, UnsupportedEncodingException {
      String email = request.getParameter("email");
          String token = RandomString.make(30);

        try {
            userService.updateResetPasswordToken(token, email);
            String resetPasswordLink = Utility.getSiteURL(request) + "/reset_password?token=" + token;

            model.addAttribute("message", "We have sent a reset password link to your email. Please check.");

        } catch (UsernameNotFoundException ex) {
            model.addAttribute("error", ex.getMessage());
        }
        return "success";
    }



    @PostMapping("/forgot_password_1")
    public ResponseEntity<String> processForgotPassword(HttpServletRequest request) throws MessagingException, UnsupportedEncodingException {
        String email = request.getParameter("email");
        String token = RandomString.make(30);



        try {
            userService.updateResetPasswordToken(token, email);
            String resetPasswordLink = Utility.getSiteURL(request) + "/reset_password?token=" + token;
          String message = "We have sent a reset password link to your email. Please check.";
            // Create a response with success status and message
            return ResponseEntity.ok()
                    .body(message);
        } catch (UsernameNotFoundException ex) {
            return ResponseEntity.status(HttpStatus.BAD_REQUEST).body(ex.getMessage());
        }
    }


    @GetMapping("/reset_password")
    public String showResetPasswordForm(@Param(value = "token") String token, Model model) {
        UserDto user = userService.getResetPasswordToken(token);
        model.addAttribute("token", token);

        if (user == null) {
            model.addAttribute("message", "Invalid Token");
            return "message";
        }

        return "reset_password_form";
    }

    @PostMapping("/reset_password")
    public String processResetPassword(HttpServletRequest request, Model model) {
        String token = request.getParameter("token");
        String password = request.getParameter("password");


        UserDto user = userService.getResetPasswordToken(token);
        model.addAttribute("title", "Reset your password");

        if (user == null) {
            model.addAttribute("message", "Invalid Token");
            return "message";
        } else {

            userService.updatePassword(user, password);

            model.addAttribute("message", "You have successfully changed your password.");
        }

        return "message";
    }

}
