package com.eprescribing.prescribe.user.service;

import com.eprescribing.prescribe.user.data.UserDto;
import com.eprescribing.prescribe.user.model.UserEntity;

import java.util.List;
import java.util.Optional;

public interface UserService {

    UserDto save(UserEntity user);
    List<UserDto> getAllUsers();

    List<UserDto> getAllUserPagable(Integer pageNo, Integer pageSize, String sortBy);
    Optional<UserDto> getUserById(Long id);

    Optional<UserDto> getUserByUserName(String username);
    UserDto updateUserById(UserEntity user);
    void deleteUser(Long id);

    void updateResetPasswordToken(String token, String email);

    UserDto getResetPasswordToken(String token);

    void updatePassword(UserDto user, String newPassword);
    UserDto assignUserToOrganization(Long userId, Long organizationId);


}
