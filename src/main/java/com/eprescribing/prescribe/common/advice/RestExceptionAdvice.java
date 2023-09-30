package com.eprescribing.prescribe.common.advice;

import com.eprescribing.prescribe.common.ErrorResponse;
import com.eprescribing.prescribe.common.exceptions.DuplicateException;
import com.eprescribing.prescribe.common.exceptions.ValidationException;
import com.eprescribing.prescribe.common.exceptions.NotFoundException;
import com.eprescribing.prescribe.common.responses.ApiResponse;
import com.eprescribing.prescribe.common.responses.Responses;
import lombok.extern.slf4j.Slf4j;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.MethodArgumentNotValidException;
import org.springframework.web.bind.annotation.ExceptionHandler;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.bind.annotation.RestControllerAdvice;

import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.stream.Collectors;

@RestControllerAdvice
@Slf4j
public class RestExceptionAdvice {
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

    @ExceptionHandler(ValidationException.class)
    public ResponseEntity<ErrorResponse> handleValidationException (final ValidationException exception) {
        final List<ErrorResponse.FieldError> fieldErrors = exception.getViolations()
                .stream()
                .map(fieldError -> {
                    ErrorResponse.FieldError fieldsError = new ErrorResponse.FieldError();
                    fieldsError.setField(fieldError.getField());
                    fieldsError.setError(fieldError.getError());
                    return fieldsError;
                }).collect(Collectors.toList());;
        final ErrorResponse errorResponse = new ErrorResponse();
        errorResponse.setStatus(HttpStatus.BAD_REQUEST.value());
        errorResponse.setException(exception.getClass().getSimpleName());
        errorResponse.setErrors(fieldErrors);
        errorResponse.setMessage(exception.getMessage());
        log.error("ValidationException: {}", exception.getMessage());
        return new ResponseEntity<>(errorResponse, HttpStatus.BAD_REQUEST);
    }
    @ExceptionHandler(DuplicateException.class)
    public ResponseEntity<ErrorResponse> handleDuplicateException (final DuplicateException exception) {
        final ErrorResponse errorResponse = new ErrorResponse();
        errorResponse.setStatus(HttpStatus.CONFLICT.value());
        errorResponse.setException(exception.getClass().getSimpleName());
        errorResponse.setMessage(exception.getMessage());
        log.error("DuplicateException: {}", exception.getMessage());
        return new ResponseEntity<>(errorResponse, HttpStatus.CONFLICT);
    }

    @ExceptionHandler(MethodArgumentNotValidException.class)
    public ResponseEntity<ErrorResponse> handleValidationErrors(MethodArgumentNotValidException exception) {
        List<ErrorResponse.FieldError> errors = exception.getBindingResult().getFieldErrors()
                .stream().map(fieldError -> {
                    ErrorResponse.FieldError fieldsError = new ErrorResponse.FieldError();
                    fieldsError.setField(fieldError.getField());
                    fieldsError.setError(fieldError.getDefaultMessage());
                    return fieldsError;
                }).collect(Collectors.toList());
        final ErrorResponse errorResponse = new ErrorResponse();
        errorResponse.setStatus(HttpStatus.BAD_REQUEST.value());
        errorResponse.setException(exception.getClass().getSimpleName());
        errorResponse.setErrors(errors);
        errorResponse.setMessage(exception.getMessage());
        log.error("ValidationErrorException: {}", exception.getMessage());
        return new ResponseEntity<>(errorResponse, HttpStatus.BAD_REQUEST);
    }
}
