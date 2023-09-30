package com.eprescribing.prescribe.config.security.requests;

import lombok.Data;

@Data
public class SignUpRequest {
    private String username;
    private String email;
    private String password;

}
