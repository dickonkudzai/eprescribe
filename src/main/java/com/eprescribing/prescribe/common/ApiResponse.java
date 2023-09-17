package com.eprescribing.prescribe.common;

import lombok.Builder;
import lombok.Data;

@Data
@Builder
public class ApiResponse <T>{
    private int statusCode;
    private int responseCode;
    private String message;
    private T body;
}
