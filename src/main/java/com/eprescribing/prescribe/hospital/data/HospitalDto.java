package com.eprescribing.prescribe.hospital.data;

import lombok.Data;
import lombok.RequiredArgsConstructor;

@Data
@RequiredArgsConstructor
public class HospitalDto {
    private long id;
    private String hospitalName;
}
