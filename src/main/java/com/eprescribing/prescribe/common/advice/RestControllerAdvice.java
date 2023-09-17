package com.eprescribing.prescribe.common.advice;

import com.eprescribing.prescribe.common.exceptions.NotFoundException;
import com.eprescribing.prescribe.common.responses.ApiResponse;
import com.eprescribing.prescribe.common.responses.Responses;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.ExceptionHandler;
import org.springframework.web.bind.annotation.ResponseBody;

@org.springframework.web.bind.annotation.RestControllerAdvice
public class RestControllerAdvice {
    @ExceptionHandler(NotFoundException.class)
    @ResponseBody
    public ResponseEntity<ApiResponse> handleException(NotFoundException ex){
        ApiResponse apiResponse = ApiResponse.builder()
                .statusCode(Responses.NOT_FOUND.getHttpStatus())
                .message(ex.getMessage())
                .responseCode(00)
                .build();
        return new ResponseEntity<>(apiResponse, HttpStatus.valueOf(Responses.NOT_FOUND.getHttpStatus()));
    }
}
