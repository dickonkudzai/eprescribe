package com.eprescribing.prescribe.user.data;

import com.eprescribing.prescribe.roles.model.Role;
import lombok.Data;

import javax.validation.constraints.NotBlank;
import javax.validation.constraints.NotNull;
import java.util.Set;

@Data
public class UserDto {
    private Long id;
    @NotNull(message = "username can not be null")
    @NotBlank(message = "username can not be blank")
    private String username;
    @NotNull(message = "email can not be null")
    @NotBlank(message = "email can not be blank")
    private String email;
    private Boolean enabled;
    private String resetPasswordToken;
    private Set<Role> roles;

}
