package com.eprescribing.prescribe.pharmacy.mapper;

import com.eprescribing.prescribe.pharmacy.data.PharmacyDto;
import com.eprescribing.prescribe.pharmacy.model.Pharmacy;
import org.mapstruct.Mapper;
import org.mapstruct.MappingTarget;
import org.mapstruct.factory.Mappers;

@Mapper
public interface PharmarcyMapper {
    PharmarcyMapper INSTANCE = Mappers.getMapper(PharmarcyMapper.class);
    void updateEntit(PharmacyDto pharmacyDto, @MappingTarget Pharmacy pharmacy);

    PharmacyDto fromEntity(Pharmacy pharmacy);
    Pharmacy toEntity(PharmacyDto pharmacyDto);
}
