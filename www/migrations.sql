CREATE TABLE users (
id SERIAL PRIMARY KEY,
user_name VARCHAR(255) NULL,
email VARCHAR(255) NULL,
phone VARCHAR(255) NULL,
create_date DATETIME NOT NULL
);

CREATE TABLE user_addresses (

 id SERIAL PRIMARY KEY,
 user_id BIGINT UNSIGNED NOT NULL,
 zip VARCHAR (30) NULL,
 country VARCHAR (255) NOT NULL,
 city VARCHAR (255) NOT NULL,
 region  VARCHAR (255) NOT NULL,
 address VARCHAR (255) NOT NULL
 );

 CREATE TABLE user_cc (
 id SERIAL PRIMARY KEY,
 user_id BIGINT UNSIGNED NOT NULL,
 cc_number VARCHAR (255) NULL,
 cc_month VARCHAR (255) NULL,
 cc_year VARCHAR (255) NULL,
 cc_cvv VARCHAR (255) NULL,
 cc_name VARCHAR (255) NULL
 );

 CREATE TABLE orders (
 id SERIAL PRIMARY KEY,
 user_id BIGINT UNSIGNED NOT NULL,
 product_id BIGINT UNSIGNED NOT NULL,
 status_id BIGINT UNSIGNED NOT NULL,
 price DECIMAL(10,2) NOT NULL,
 create_date DATETIME NOT NULL,
 pay_date DATETIME NULL,
 payment_method VARCHAR (255) NOT NULL,
 referer VARCHAR (255) NULL
 );

 CREATE TABLE products (
 id SERIAL PRIMARY KEY,
 product_name VARCHAR (255) NOT NULL,
 product_description TEXT NULL,
 create_date DATETIME NOT NULL
 );


CREATE TABLE order_address_relations (
 id SERIAL PRIMARY KEY,
 order_id BIGINT UNSIGNED NOT NULL,
 address_id BIGINT UNSIGNED NOT NULL
);

ALTER TABLE products ADD price DECIMAL(10,2) NOT NULL AFTER product_name;
ALTER TABLE orders ADD price_usd DECIMAL (10, 2) NULL AFTER price;

ALTER TABLE products ADD checkout_sequence TINYINT NOT NULL DEFAULT 1;
ALTER TABLE orders ADD payment_info VARCHAR (255) NULL AFTER payment_method;

ALTER TABLE user_addresses ADD first_name VARCHAR (255) NULL AFTER user_id;
ALTER TABLE user_addresses ADD last_name VARCHAR (255) NULL AFTER first_name;

ALTER TABLE products ADD product_key VARCHAR (255) NOT NULL AFTER id;
ALTER TABLE products ADD landing_key VARCHAR (255) NOT NULL AFTER product_key;