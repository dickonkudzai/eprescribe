package com.eprescribing.prescribe.pharmacy.data;

import lombok.Builder;
import lombok.Data;

@Data
@Builder
public class PharmacyResponse<T> {
    private int statusCode;
    private String message;
    private T body;
}
