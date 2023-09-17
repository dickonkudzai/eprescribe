package com.eprescribing.prescribe.pharmacy.service;

import com.eprescribing.prescribe.pharmacy.data.PharmacyDto;
import com.eprescribing.prescribe.pharmacy.data.PharmacyResponse;

public interface PharmacyService {
    PharmacyResponse save(PharmacyDto pharmacyDto);
    PharmacyResponse getAll();
    PharmacyResponse findById(Long id);
    PharmacyResponse updatebById(Long id, PharmacyDto pharmacyDto);
    PharmacyResponse deleteById(Long id);
}
