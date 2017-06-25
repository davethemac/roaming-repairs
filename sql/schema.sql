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
    firstName VARCHAR(255), 
    lastName VARCHAR(255), 
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rr_device;
CREATE TABLE rr_device(
    id INT NOT NULL AUTO_INCREMENT,
    deviceName VARCHAR(255) UNIQUE, 
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rr_customer_device;
CREATE TABLE rr_customer_device(
    id INT NOT NULL AUTO_INCREMENT,
    customerId INT NOT NULL, -- FK ref rr_customer.id
    deviceId INT NOT NULL, -- FK ref rr_device.id
    quantity INT NOT NULL DEFAULT 1,
    PRIMARY KEY(id)
);

-- DROP TABLE IF EXISTS rr_location;
-- CREATE TABLE rr_location(); -- possibly the same thing as customer, but its a dodgy assumption

DROP TABLE IF EXISTS rr_worker;
CREATE TABLE rr_worker(
    id INT NOT NULL AUTO_INCREMENT,
    firstName VARCHAR(255), 
    lastName VARCHAR(255), 
    PRIMARY KEY(id)
); -- could just be a list of names, def relation to user

DROP TABLE IF EXISTS rr_part;
CREATE TABLE rr_part(
    id INT NOT NULL AUTO_INCREMENT,
    partNumber VARCHAR(20), 
    description VARCHAR(255), 
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rr_component;
CREATE TABLE rr_component(
    deviceId INT NOT NULL, -- FK ref rr_job.id
    partId INT NOT NULL, -- FK ref rr_part.id
    quantity INT NOT NULL DEFAULT 1,
    PRIMARY KEY(deviceId, partId)
);

DROP TABLE IF EXISTS rr_job;
CREATE TABLE rr_job(
    id INT NOT NULL AUTO_INCREMENT,
    referenceNo INT NOT NULL,
    customerId INT NOT NULL, -- FK ref rr_customer.id
    deviceId INT NOT NULL, -- FK ref rr_device.id
    description TEXT,
    jobDate DATE,
    mileage INT,
    startTime TIME,
    endTime TIME,
    isComplete TINYINT NOT NULL DEFAULT 0,
    notes TEXT,
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rr_partused;
CREATE TABLE rr_partused(
    id INT NOT NULL AUTO_INCREMENT,
    jobId INT NOT NULL, -- FK ref rr_job.id
    partId INT NOT NULL, -- FK ref rr_part.id
    usageDescription VARCHAR(255), -- possibly redundant
    quantity INT NOT NULL DEFAULT 1,
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS rr_job_worker;
CREATE TABLE rr_job_worker(
    jobId INT NOT NULL, -- FK ref rr_job.id
    workerId INT NOT NULL, -- FK ref rr_worker.id
    PRIMARY KEY (jobId, workerId)
);