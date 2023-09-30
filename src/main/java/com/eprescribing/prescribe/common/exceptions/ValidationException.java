package com.eprescribing.prescribe.common.exceptions;


import com.eprescribing.prescribe.common.ErrorResponse;
import lombok.Data;
import lombok.EqualsAndHashCode;

import java.util.List;

@EqualsAndHashCode(callSuper = true)
@Data
public class ValidationException extends RuntimeException {
    private final List<ErrorResponse.FieldError> violations;
    public ValidationException(String message, Object violations) {
        super(message);
        this.violations = (List<ErrorResponse.FieldError>) violations;
    }
}
