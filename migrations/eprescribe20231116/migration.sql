create table drugs
(
    id         int auto_increment
        primary key,
    drug_name  varchar(150) null,
    blocked    int          null,
    controlled int          null,
    status     int          null
);

alter table consultation
    add attended_by int null;

alter table consultation
    modify bp varchar(15) null;

alter table consultation
    modify condition_diagnosis TEXT null;