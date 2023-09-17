package com.eprescribing.prescribe.pharmacy.data;

import lombok.Data;

@Data
public class PharmacyDto {
    private Long id;
    private String pharmacyName;
    private String pharmacyAddress;
}
