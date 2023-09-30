package com.eprescribing.prescribe.common.validation;

import jakarta.validation.ConstraintValidator;
import jakarta.validation.ConstraintValidatorContext;
import org.springframework.stereotype.Component;

import java.util.Arrays;
import java.util.stream.Collectors;

@Component
public class ValueOfEnumValidator implements ConstraintValidator<ValueOfEnum, CharSequence> {
    private Class<? extends Enum<?>> enumClass;

    @Override
    public void initialize(ValueOfEnum constraintAnnotation) {
        enumClass = constraintAnnotation.enumClass();
    }

    @Override
    public boolean isValid(CharSequence value, ConstraintValidatorContext context) {
        if (value == null || value=="") {
            return true;
        }

        Enum<?>[] enumValues = enumClass.getEnumConstants();
        String enumValuesString = Arrays.stream(enumValues)
                .map(Enum::name)
                .collect(Collectors.joining(", "));

        context.disableDefaultConstraintViolation();
        context.buildConstraintViolationWithTemplate("Must be any of [" + enumValuesString + "]")
                .addConstraintViolation();

        return Arrays.stream(enumValues)
                .anyMatch(enumValue -> enumValue.name().contentEquals(value));
    }

}
