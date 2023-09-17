package com.eprescribing.prescribe.pharmacy.service;

import com.eprescribing.prescribe.common.Responses;
import com.eprescribing.prescribe.pharmacy.data.PharmacyDto;
import com.eprescribing.prescribe.pharmacy.data.PharmacyResponse;
import com.eprescribing.prescribe.pharmacy.mapper.PharmarcyMapper;
import com.eprescribing.prescribe.pharmacy.model.Pharmacy;
import com.eprescribing.prescribe.pharmacy.repository.PharmacyRepository;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class PharmacyServiceImpl implements PharmacyService{
    private final PharmacyRepository pharmacyRepository;

    public PharmacyServiceImpl(PharmacyRepository pharmacyRepository) {
        this.pharmacyRepository = pharmacyRepository;
    }

    @Override
    public PharmacyResponse save(PharmacyDto pharmacyDto) {
        Pharmacy entity = PharmarcyMapper.INSTANCE.toEntity(pharmacyDto);
        Pharmacy savedPharmacy = pharmacyRepository.save(entity);
        return Optional.of(savedPharmacy).map(pharmacyResponse-> PharmacyResponse.builder()
                .body(pharmacyResponse)
                .message(Responses.PHARMACY_SAVE_SUCCESS.getMessage())
                .statusCode(Responses.PHARMACY_SAVE_SUCCESS.getHttpStatus())
                .build()).orElseGet(() -> PharmacyResponse.builder()
                .statusCode(Responses.PHARMACY_SAVE_FAILED.getHttpStatus())
                .body(savedPharmacy)
                .message(Responses.PHARMACY_SAVE_FAILED.getMessage())
                .build());

    }

    @Override
    public PharmacyResponse getAll() {
        List<Pharmacy> pharmacyList = this.pharmacyRepository.findAll();
        return Optional.of(pharmacyList).map(pharmacyListResponse->PharmacyResponse.builder()
                .body(pharmacyListResponse)
                .message(Responses.SUCCESS.getMessage())
                .statusCode(HttpStatus.OK.value())
                .build()).orElseGet(()->PharmacyResponse.builder()
                .statusCode(Responses.PHARMACY_LIST_SUCCESS_NO_PHARMACY.getHttpStatus())
                .message(Responses.PHARMACY_LIST_SUCCESS_NO_PHARMACY.getMessage())
                .build());
    }

    @Override
    public PharmacyResponse findById(Long id) {
        Optional <Pharmacy> found = this.pharmacyRepository.findById(id);
        return Optional.of(found).map(foundPharmacy-> PharmacyResponse.builder()
                .body(foundPharmacy)
                .message(Responses.PHARMACY_FOUND_SUCCESS.getMessage())
                .statusCode(Responses.PHARMACY_FOUND_SUCCESS.getHttpStatus())
                .build()).orElseGet(()-> PharmacyResponse.builder()
                    .statusCode(Responses.PHARMACY_NOT_FOUND.getHttpStatus())
                    .message(Responses.PHARMACY_NOT_FOUND.getMessage())
                    .build()
        );
    }

    @Override
    public PharmacyResponse updatebById(Long id, PharmacyDto pharmacyDto) {
        return null;
    }

    @Override
    public PharmacyResponse deleteById(Long id) {

    }
}
