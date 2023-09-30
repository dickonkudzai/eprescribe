package com.eprescribing.prescribe.config.security.requests;

import lombok.Data;

@Data
public class LoginRequest {
    private String username;
    private String password;

}
