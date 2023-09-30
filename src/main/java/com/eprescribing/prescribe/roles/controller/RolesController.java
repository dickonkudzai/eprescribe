package com.eprescribing.prescribe.roles.controller;

import com.eprescribing.prescribe.common.exceptions.ValidationException;
import com.eprescribing.prescribe.common.validation.BaseValidator;
import com.eprescribing.prescribe.roles.dto.RolesDto;
import com.eprescribing.prescribe.roles.model.Role;
import com.eprescribing.prescribe.roles.service.RolesService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.util.List;
@RestController
@RequestMapping(path="/api/roles")
public class RolesController {
    private final RolesService rolesService;

    @Autowired
    public RolesController(RolesService rolesService) {
        this.rolesService = rolesService;
    }

    @GetMapping("/all")
    public List<Role> getAllRoles(){
        return rolesService.allRoles();
    }

    @PostMapping(path = "/save", consumes="application/json")
    public void AddRole(@RequestBody RolesDto rolesDto){
        var isValid = BaseValidator.validateRequest(rolesDto);
        if (isValid.containsKey(false))
            throw new ValidationException("Validation errors occurred", isValid.get(false));
        rolesService.saveRole(rolesDto);
    }
    @DeleteMapping(path = "/delete/{roleId}")
    public void deleteRole(@PathVariable("roleId") Long roleId){
        rolesService.deleteRoleById(roleId);
    }
    @PutMapping(path = "/update/{roleId}")
    public void updateRole(@PathVariable("roleId") Long roleId,
                           @RequestParam(required = false) String name){
        rolesService.updateRole(roleId,name);
    }
}
