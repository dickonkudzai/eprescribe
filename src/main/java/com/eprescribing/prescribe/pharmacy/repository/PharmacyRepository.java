package com.eprescribing.prescribe.pharmacy.repository;

import com.eprescribing.prescribe.pharmacy.model.Pharmacy;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface PharmacyRepository extends JpaRepository<Pharmacy, Long> {
}