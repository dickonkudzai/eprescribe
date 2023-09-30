package com.eprescribing.prescribe.common.validation;

import com.eprescribing.prescribe.common.ErrorResponse;

import javax.validation.ConstraintViolation;
import javax.validation.Validation;
import javax.validation.Validator;
import javax.validation.ValidatorFactory;
import java.util.*;
import java.util.stream.Collectors;

public class BaseValidator<T> {
    public static <T> Map<Boolean, Object> validateRequest(T request) {
        // Create ValidatorFactory which returns validator
        ValidatorFactory factory = Validation.buildDefaultValidatorFactory();

        // It validates bean instances
        Validator validator = factory.getValidator();

        Set<ConstraintViolation<T>> constraintViolations = validator.validate(request);

        Map<Boolean, Object> validationResult = new HashMap<>();

        // If there are constraint violations, store the errors in the map under the false key
        if (!constraintViolations.isEmpty()) {
            List<ErrorResponse.FieldError> errors = constraintViolations.stream()
                    .map(fieldErrors -> {
                        ErrorResponse.FieldError fieldError = new ErrorResponse.FieldError();
                        fieldError.setError(fieldErrors.getMessage());
                        fieldError.setField(String.valueOf(fieldErrors.getPropertyPath()));
                        return fieldError;
                    })
                    .collect(Collectors.toList());
            validationResult.put(false, errors);
        } else {
            validationResult.put(true, "");
        }

        return validationResult;
    }
}
