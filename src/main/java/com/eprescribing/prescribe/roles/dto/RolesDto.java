package com.eprescribing.prescribe.roles.dto;


import com.eprescribing.prescribe.common.validation.ValueOfEnum;
import com.eprescribing.prescribe.roles.enums.RoleName;
import lombok.Data;

import javax.validation.constraints.NotBlank;
import javax.validation.constraints.NotEmpty;
import javax.validation.constraints.NotNull;

@Data
public class RolesDto {
    @NotNull(message = "role name should not be null")
    @NotEmpty(message = "role name should not be empty")
    @NotBlank(message = "role name should not be blank")
    @ValueOfEnum(enumClass = RoleName.class)
    private String roleName;
}
