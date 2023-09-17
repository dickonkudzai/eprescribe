package com.eprescribing.prescribe.hospital.repository;

import com.eprescribing.prescribe.hospital.model.Hospital;
import org.springframework.data.jpa.repository.JpaRepository;

public interface HospitalRepository extends JpaRepository<Hospital, Long> {
}
