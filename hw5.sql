DROP DATABASE IF EXISTS auto_park;
CREATE DATABASE IF NOT EXISTS auto_park;
USE auto_park;

CREATE TABLE IF NOT EXISTS parks (id INT(11) PRIMARY KEY AUTO_INCREMENT, address VARCHAR(255) NOT NULL);

CREATE TABLE  IF NOT EXISTS cars (id INT(11) PRIMARY KEY AUTO_INCREMENT, model VARCHAR(255) NOT NULL, price FLOAT NOT NULL, park_id INT(11) NOT NULL, FOREIGN KEY (park_id) REFERENCES parks(id));

CREATE TABLE  IF NOT EXISTS drivers (id INT(11) PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL,  phone VARCHAR(255),  car_id INT(11) NOT NULL, FOREIGN KEY (car_id) REFERENCES cars(id));

CREATE TABLE  IF NOT EXISTS customers (id INT(11) PRIMARY KEY AUTO_INCREMENT, name TEXT NOT NULL, phone VARCHAR(255));

CREATE TABLE  IF NOT EXISTS orders (id INT(11) PRIMARY KEY AUTO_INCREMENT, start TEXT NOT NULL, finish TEXT NOT NULL, total FLOAT NOT NULL, driver_id INT(11) NOT NULL, customer_id INT(11) NOT NULL, FOREIGN KEY (driver_id) REFERENCES drivers(id), FOREIGN KEY (customer_id) REFERENCES customers(id));

CREATE TABLE  IF NOT EXISTS managers (id INT(11) PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255) NOT NULL);


DROP TABLE managers;

ALTER TABLE customers MODIFY COLUMN name VARCHAR(255);

INSERT INTO parks (address) VALUES ('Kharkiv Sumskaya 1');
INSERT INTO parks (address) VALUES ('Kharkiv Naukova 10');
INSERT INTO parks (address) VALUES ('Kharkiv Profesorska 14');
INSERT INTO parks (address) VALUES ('Kharkiv Lozivskaya 15 ');
INSERT INTO parks (address) VALUES ('Kharkiv Beketova 67');

INSERT INTO cars (model, price,park_id) VALUES ('Toyoya RAV4', 3000,1);
INSERT INTO cars (model, price,park_id) VALUES ('Toyoya Prado', 5500,1);
INSERT INTO cars (model, price,park_id) VALUES ('Toyoya Camry', 2800,2);
INSERT INTO cars (model, price,park_id) VALUES ('Toyoya Prius', 3300,3);
INSERT INTO cars (model, price,park_id) VALUES ('Toyoya Crown', 4200,4);

INSERT INTO drivers (name, phone,car_id) VALUES ('Alex', '380661776767',1);
INSERT INTO drivers (name, phone,car_id) VALUES ('Boris', '380669776712',2);
INSERT INTO drivers (name, phone,car_id) VALUES ('Anna', '380669776790',3);
INSERT INTO drivers (name, phone,car_id) VALUES ('Kostya', '380501236790',4);
INSERT INTO drivers (name, phone,car_id) VALUES ('Ivan', '380937865790',5);

INSERT INTO customers (name, phone) VALUES ('Olya', '380931115790');
INSERT INTO customers (name, phone) VALUES ('Misha', '380631115792');
INSERT INTO customers (name, phone) VALUES ('Inna', '380631234592');
INSERT INTO customers (name, phone) VALUES ('Maksim', '380631231234');

INSERT INTO orders (start, finish, total, driver_id, customer_id) VALUES ('2024-01-01', '2024-01-07', 5500, 1,1);
INSERT INTO orders (start, finish, total, driver_id, customer_id) VALUES ('2024-02-01', '2024-02-09', 3500, 2,2);
INSERT INTO orders (start, finish, total, driver_id, customer_id) VALUES ('2024-04-05', '2024-04-09', 3500, 3,3);
INSERT INTO orders (start, finish, total, driver_id, customer_id) VALUES ('2024-05-05', '2024-05-19', 4500, 4,3);
INSERT INTO orders (start, finish, total, driver_id, customer_id) VALUES ('2024-05-15', '2024-05-22', 4500, 3,3);


UPDATE cars SET price=2000 WHERE model='Toyoya Prius';

DELETE FROM orders WHERE id=5;

SELECT o.id, o.driver_id FROM `orders` AS o  WHERE total >= 4500;
SELECT * FROM `customers` WHERE phone LIKE '%063%';
SELECT * FROM `cars` WHERE price IN(2000,3000);
SELECT phone FROM `drivers` WHERE name LIKE 'A%';


/* Join info about customers and orders */

SELECT o.id as order_id, c.id as customer_id, c.name, o.total FROM orders AS o INNER JOIN customers AS c ON c.id = o.customer_id;

/* Customers without orders */
SELECT c.id, c.name
FROM customers AS c 
LEFT JOIN orders AS o
ON c.id = o.customer_id WHERE o.id IS NULL;


/* Parks without cars */
SELECT p.address FROM `parks` as p LEFT JOIN cars AS c ON c.park_id=p.id WHERE c.park_id IS NULL;

/* Add new column */
ALTER TABLE drivers ADD COLUMN age INT(11);

/* Get orders amount */
SELECT COUNT(id) as orders_amount  FROM `orders` WHERE 1;

/* Get orders total sum */
SELECT SUM(total) as total_sum  FROM `orders` WHERE 1;

/* Get customer who made more than 2 orders*/
SELECT COUNT(c.id) as count_id, c.id as customer_id, c.name
FROM customers AS c
INNER JOIN orders AS o ON o.customer_id=c.id
GROUP BY c.id
HAVING count_id >= 2;






