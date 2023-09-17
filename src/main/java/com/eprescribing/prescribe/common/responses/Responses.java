package com.eprescribing.prescribe.common.responses;

import org.springframework.http.HttpStatus;

public enum Responses {
    SUCCESS("SUCCESS", HttpStatus.OK.value(), "SUCCESS"),
    FAILED("FAILED", HttpStatus.INTERNAL_SERVER_ERROR.value(), "FAILED"),
    NOT_FOUND("NOTFOUND", HttpStatus.NOT_FOUND.value(), "NOT FOUND"),
    PHARMACY_SAVE_SUCCESS("PHARMACY_ADD", HttpStatus.OK.value(), "Successfully Added Pharmacy"),
    PHARMACY_SAVE_FAILED("PHARMACY_ADD", HttpStatus.INTERNAL_SERVER_ERROR.value() , "Failed to save Pharmacy"),
    PHARMACY_LIST_SUCCESS("PHARMACY_LIST_SUCCESS", HttpStatus.OK.value(), "Successfully retrieved pharmacy list"),
    PHARMACY_LIST_SUCCESS_NO_PHARMACY("PHARMACY_LIST_SUCCESS", HttpStatus.OK.value(), "No pharmacies available"),
    PHARMACY_FOUND_SUCCESS("PHARMACY_FOUND_SUCCESS", HttpStatus.OK.value(), "Pharmacy Found"),
    PHARMACY_NOT_FOUND("PHARMACY_NOT_FOUND", HttpStatus.NO_CONTENT.value(), "Pharmacy Found"),
    PHARMACY_SUCCESSFUL_UPDATE("PHARMACY_SUCCESSFUL_UPDATE", HttpStatus.OK.value(), "Pharmacy Updated"),
    PHARMACY_SUCCESSFUL_DELETE("PHARMACY_SUCCESSFUL_DELETE", HttpStatus.OK.value(), "Pharmacy deleted"),
    ;

    final String key;
    final int httpStatus;
    final String message;

    Responses(String key, int httpStatus, String message){
        this.key = key;
        this.httpStatus = httpStatus;
        this.message = message;
    }

    public String getKey(){
        return this.key;
    }
    public int getHttpStatus(){
        return this.httpStatus;
    }
    public String getMessage(){
        return this.message;
    }

}
