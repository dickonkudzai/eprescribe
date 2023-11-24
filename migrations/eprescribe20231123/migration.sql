create table prescriptions
(
    id                   int default not null auto_increment primary key ,
    date_of_prescription int null,
    drug_id              int null,
    dose                 int null,
    added_by             int null,
    patient_id           int null
);

alter table prescriptions
    add status int null;

create table prescription_lines
(
    id              int auto_increment primary key ,
    drug_id         int         null,
    dose            varchar(10) null,
    collected       int         null,
    prescription_id int         null,
    status          int         null
);

alter table prescriptions
    drop column drug_id;

alter table prescriptions
    drop column dose;

alter table prescriptions
    change collected closed int null;
alter table prescriptions
    modify date_of_prescription date null;

