create table pharmacy_stock
(
    id           int auto_increment PRIMARY KEY,
    drug_id      int                                 null,
    expiry_date  date                                null,
    quantity     decimal(10, 2)                      null,
    created_date timestamp default current_timestamp null,
    created_by   int                                 null,
    updated_on   timestamp                           null on update CURRENT_TIMESTAMP,
    updated_by   int                                 null,
    blocked      int       default 0                 null,
    status       int       default 1                 null
);

alter table pharmacy_stock
    add pharmacy_id int null;
