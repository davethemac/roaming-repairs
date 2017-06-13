/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  davethemac
 * Created: 08-Jun-2017
 */

DROP TABLE IF EXISTS rr_user;
CREATE TABLE rr_user(
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE, 
    password VARCHAR(255), 
    roles VARCHAR(255),
    PRIMARY KEY(id)
);


DROP TABLE IF EXISTS rr_customer;
CREATE TABLE rr_customer(
    id INT NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(255), 
    last_name VARCHAR(255), 
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rr_device;
CREATE TABLE rr_device(
    id INT NOT NULL AUTO_INCREMENT,
    device_name VARCHAR(255) UNIQUE, 
    PRIMARY KEY(id)
);

-- DROP TABLE IF EXISTS rr_location;
-- CREATE TABLE rr_location(); -- possibly the same thing as customer, but its a dodgy assumption

DROP TABLE IF EXISTS rr_worker;
CREATE TABLE rr_worker(
    id INT NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(255), 
    last_name VARCHAR(255), 
    PRIMARY KEY(id)
); -- could just be a list of names, def relation to user

DROP TABLE IF EXISTS rr_part;
CREATE TABLE rr_part(
    id INT NOT NULL AUTO_INCREMENT,
    part_number VARCHAR(20), 
    description VARCHAR(255), 
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rr_component;
CREATE TABLE rr_component(
    id INT NOT NULL AUTO_INCREMENT,
    device_id INT NOT NULL, -- FK ref rr_job.id
    part_id INT NOT NULL, -- FK ref rr_part.id
    quantity INT NOT NULL DEFAULT 1,
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rr_job;
CREATE TABLE rr_job(
    id INT NOT NULL AUTO_INCREMENT,
    reference_no INT NOT NULL,
    customer_id INT NOT NULL, -- FK ref rr_customer.id
    device_id INT NOT NULL, -- FK ref rr_device.id
    description TEXT,
    job_date DATE,
    mileage INT,
    start_time TIME,
    end_time TIME,
    is_complete TINYINT NOT NULL DEFAULT 0,
    notes TEXT,
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rr_partused;
CREATE TABLE rr_partused(
    id INT NOT NULL AUTO_INCREMENT,
    job_id INT NOT NULL, -- FK ref rr_job.id
    component_id INT NOT NULL, -- FK ref rr_part.id
    usage_description VARCHAR(255), -- possibly redundant
    quantity INT NOT NULL DEFAULT 1,
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rr_job_worker;
CREATE TABLE rr_job_worker(
    job_id INT NOT NULL, -- FK ref rr_job.id
    worker_id INT NOT NULL, -- FK ref rr_worker.id
    PRIMARY KEY (job_id, worker_id)
);