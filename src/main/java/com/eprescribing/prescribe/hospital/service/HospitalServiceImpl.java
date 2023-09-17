package com.eprescribing.prescribe.hospital.service;

import com.eprescribing.prescribe.hospital.data.HospitalDto;
import com.eprescribing.prescribe.hospital.model.Hospital;
import com.eprescribing.prescribe.hospital.repository.HospitalRepository;
import org.springframework.stereotype.Service;

import java.util.List;
@Service
public class HospitalServiceImpl implements HospitalService {
    private final HospitalRepository hospitalRepository;

    public HospitalServiceImpl(HospitalRepository hospitalRepository) {
        this.hospitalRepository = hospitalRepository;
    }

    @Override
    public HospitalDto save(HospitalDto HospitalDto) {
        return null;
    }

    @Override
    public List<HospitalDto> findAll() {
        return null;
    }

    @Override
    public HospitalDto findById(Long id) {
        return null;
    }

    @Override
    public HospitalDto updateHospital(Long id, Hospital hospital) {
        return null;
    }
}
