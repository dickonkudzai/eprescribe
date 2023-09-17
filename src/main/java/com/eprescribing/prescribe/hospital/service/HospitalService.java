package com.eprescribing.prescribe.hospital.service;

import com.eprescribing.prescribe.hospital.data.HospitalDto;
import com.eprescribing.prescribe.hospital.model.Hospital;

import java.util.List;

public interface HospitalService {
    HospitalDto save(HospitalDto HospitalDto);
    List<HospitalDto> findAll();
    HospitalDto findById(Long id);
    HospitalDto updateHospital(Long id, Hospital hospital);
}
