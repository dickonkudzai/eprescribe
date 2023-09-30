package com.eprescribing.prescribe.roles.service;

import com.eprescribing.prescribe.roles.dto.RolesDto;
import com.eprescribing.prescribe.roles.model.Role;

import java.util.List;

public interface RolesService {
    void saveRole(RolesDto rolesDto);
    void deleteRoleById(Long id);
    void updateRole(Long id,String roleName);
    public List<Role> allRoles();
}
