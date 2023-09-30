package com.eprescribing.prescribe.config.security.responses;

import com.eprescribing.prescribe.roles.model.Role;
import lombok.Data;

import java.util.Set;

@Data
public class JwtResponse {
    private String token;
    private String type = "Bearer";
    private Long id;
    private String username;
    private String email;
    private Set<Role> roles;


    public JwtResponse(String accessToken, Long id, String username, Set<Role> roles, String email) {

        this.token = accessToken;
        this.id = id;
        this.username = username;
        this.email = email;
        this.roles = roles;

    }


}
