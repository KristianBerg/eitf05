
set foreign_key_checks = 0;
drop table if exists customers;
drop table if exists orders;
drop table if exists cookies;
drop table if exists recipes;
drop table if exists pallets;
drop table if exists ingredients;
drop table if exists cookieinorders;
drop table if exists deliveredpallets;
set foreign_key_checks = 1;

CREATE TABLE customers (
    customer_name VARCHAR(40),
    address VARCHAR(40),
    PRIMARY KEY (customer_name , address)
);
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT,
    PRIMARY KEY (order_id),
    customer_name VARCHAR(40),
    order_date DATE NOT NULL,
    address VARCHAR(40),
    FOREIGN KEY (customer_name , address)
        REFERENCES customers (customer_name , address),
    deliver_date DATE NOT NULL
);
CREATE TABLE cookies (
    cookie VARCHAR(20),
    PRIMARY KEY (cookie)
);
CREATE TABLE CookieInOrders (
    order_id INT,
    cookie VARCHAR(20),
    FOREIGN KEY (order_id)
        REFERENCES orders (order_id),
    FOREIGN KEY (cookie)
        REFERENCES cookies (cookie),
    PRIMARY KEY (cookie , order_id),
    pallet_amount INT
);

CREATE TABLE pallets (
    pallet_id INT AUTO_INCREMENT,
    PRIMARY KEY (pallet_id),
    cookie VARCHAR(20),
    FOREIGN KEY (cookie)
        REFERENCES cookies (cookie),
    date_produced DATE,
    is_blocked BOOLEAN,
    location varchar(20)
);
CREATE TABLE DeliveredPallets (
    order_id INT,
    pallet_id INT,
    FOREIGN KEY (order_id)
        REFERENCES orders (order_id),
    FOREIGN KEY (pallet_id)
        REFERENCES pallets (pallet_id),
    PRIMARY KEY (pallet_id , order_id)
);

CREATE TABLE ingredients (
    ingredient VARCHAR(30),
    PRIMARY KEY (ingredient),
    amount_in_storage INT,
    last_delivered_date DATE,
    last_delivered_amount INT
);
CREATE TABLE Recipes (
    cookie VARCHAR(20),
    ingredient VARCHAR(30),
    PRIMARY KEY (cookie , ingredient),
    amount VARCHAR(20)
);