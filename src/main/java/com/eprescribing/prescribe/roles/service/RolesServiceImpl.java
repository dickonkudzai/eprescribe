package com.eprescribing.prescribe.roles.service;


import com.eprescribing.prescribe.common.exceptions.DuplicateException;
import com.eprescribing.prescribe.common.exceptions.NotFoundException;
import com.eprescribing.prescribe.roles.dto.RolesDto;
import com.eprescribing.prescribe.roles.enums.RoleName;
import com.eprescribing.prescribe.roles.model.Role;
import com.eprescribing.prescribe.roles.repository.RolesRepository;
import org.springframework.stereotype.Component;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Objects;
import java.util.Optional;

@Service
@Component
public class RolesServiceImpl implements RolesService {
    private final RolesRepository rolesRepository;

    public RolesServiceImpl(RolesRepository rolesRepository) {
        this.rolesRepository = rolesRepository;
    }
    public List<Role> allRoles(){

        return rolesRepository.findAll();
    }
    @Override
    public void saveRole(RolesDto rolesDto) {
        Optional<Role> roleByName = rolesRepository.findRolesByRoleName(RoleName.valueOf(rolesDto.getRoleName()));
        if(roleByName.isPresent()){
            throw new DuplicateException("The supplied role already exists");
        }
        Role roles1= Role.build(0L, RoleName.valueOf(rolesDto.getRoleName()));
        rolesRepository.save(roles1);

    }

    @Override
    public void deleteRoleById(Long id) {
        boolean exist=rolesRepository.existsById(id);
        if(!exist){
            throw new NotFoundException("The role does not exist");
        }
        rolesRepository.deleteById(id);

    }

    @Override
    public void updateRole(Long id, String roleName) {
        Role roles=rolesRepository.findById(id).orElseThrow(()->new NotFoundException(
                "Role with id "+id+"not found"));

        if(roleName!=null && !roleName.isEmpty() && !Objects.equals(roleName,roles.getRoleName())){
            roles.setRoleName(RoleName.valueOf(roleName));
        }
    }
}
