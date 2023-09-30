package com.eprescribing.prescribe.roles.repository;

import com.eprescribing.prescribe.roles.enums.RoleName;
import com.eprescribing.prescribe.roles.model.Role;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.Optional;

@Repository
public interface RolesRepository extends JpaRepository <Role,Long>{
//    Optional<Roles> findRoleByName(String name);
    Optional<Role> findRolesByRoleName(RoleName roleName);

}
