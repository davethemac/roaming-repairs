/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  david.mccart
 * Created: 08-Jun-2016
 */

DROP TABLE IF EXISTS rr_user;
CREATE TABLE rr_user(
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE, 
    password VARCHAR(255), 
    roles VARCHAR(255),
    PRIMARY KEY(id)
); -- maybe standard framework user entity


DROP TABLE IF EXISTS rr_customer;
CREATE TABLE rr_customer(
    id INT NOT NULL AUTO_INCREMENT,
    customer_name VARCHAR(255) UNIQUE, 
    PRIMARY KEY(id)
); -- what detailos do they want?

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

DROP TABLE IF EXISTS rr_job;
CREATE TABLE rr_job(
    id INT NOT NULL AUTO_INCREMENT,
    reference_no INT NOT NULL,
    customer_id INT NOT NULL, -- FK ref rr_customer.id
    description TEXT,
    job_date DATE,
    mileage INT,
    start_time TIME,
    end_time TIME,
    is_complete TINYINT NOT NULL DEFAULT 0,
    parlour_test TINYINT NOT NULL DEFAULT 0,
    notes TEXT,
    PRIMARY KEY(id)
); -- the primary entity recorded by the system

DROP TABLE IF EXISTS rr_partused;
CREATE TABLE rr_partused(
    id INT NOT NULL AUTO_INCREMENT,
    job_id INT NOT NULL, -- FK ref rr_job.id
    part_id INT NOT NULL, -- FK ref rr_part.id
    usage_description VARCHAR(255), -- possibly redundant
    quantity INT NOT NULL DEFAULT 0,
    office_data_a VARCHAR(50),
    office_data_b VARCHAR(50),
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rr_job_worker;
CREATE TABLE rr_job_worker(
    job_id INT NOT NULL, -- FK ref rr_job.id
    worker_id INT NOT NULL, -- FK ref rr_worker.id
    PRIMARY KEY (job_id, worker_id)
);