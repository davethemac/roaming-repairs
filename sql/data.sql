/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  davethemac
 * Created: 06-Jun-2017
 */

INSERT INTO `rr_customer` VALUES (2,'Leafy', 'Pasture'),(3,'Muddy', 'Fields'),(1,'Sunny', 'Meadows');

INSERT INTO `rr_part` VALUES (1,'01','Widget'),(2,'02','Dongle'),(3,'03','Geegaw'),(4,'A01','Advanced Widget'),(5,'A02','Advanced Dongle'),(6,'A03','Advanced Geegaw'),(7,'M01','Modified Widget'),(8,'M02','Modified Dongle'),(9,'M03','Modified Geegaw');

INSERT INTO `rr_device` VALUES (1, 'Basic Device'), (2, 'Advanced Device'), (3, 'Modified Device');

INSERT INTO `rr_component` VALUES (1, 1, 1), (1, 2, 1), (1, 3, 1), (2, 4, 1), (2, 5, 1), (2, 6, 1), (3, 7, 1), (3, 8, 1), (3, 9, 1);

INSERT INTO `rr_user` VALUES (1,'test','$2y$13$g1Zeb8OnxICfPv0A8FJXh.RwYNqtzKs/.Nkp1qK6jrvY3c9ytLpaC','ROLE_USER');

INSERT INTO `rr_worker` VALUES (1,'Fred','Flintstone'),(2,'Barney','Rubble'),(3,'Zaphod','Breeblebrox');

INSERT INTO `rr_customer_device` VALUES (1, 1, 1, 1), (2, 2, 2, 1), (3, 3, 3, 1);
