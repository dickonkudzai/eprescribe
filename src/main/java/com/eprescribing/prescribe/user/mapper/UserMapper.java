package com.eprescribing.prescribe.user.mapper;

import com.eprescribing.prescribe.user.data.UserDto;
import com.eprescribing.prescribe.user.model.UserEntity;
import org.mapstruct.BeanMapping;
import org.mapstruct.Mapper;
import org.mapstruct.MappingTarget;
import org.mapstruct.NullValuePropertyMappingStrategy;
import org.mapstruct.factory.Mappers;
@Mapper
public interface UserMapper {
    UserMapper INSTANCE= Mappers.getMapper(UserMapper.class);
    @BeanMapping(nullValuePropertyMappingStrategy = NullValuePropertyMappingStrategy.IGNORE)

    void updateToEntity(UserDto dto, @MappingTarget UserEntity user);
    UserEntity toEntity(UserDto userDto);
    UserDto fromEntity(UserEntity user);


}
