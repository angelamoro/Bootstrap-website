drop database tracker;
CREATE DATABASE IF NOT EXISTS tracker;
USE tracker;

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
	id_user INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(45) NOT NULL, 
    surname VARCHAR(45) NOT NULL,
    email VARCHAR(45) NOT NULL,
    password char(70) NOT NULL,
	PRIMARY KEY (id_user)
);


DROP TABLE IF EXISTS categories;
CREATE TABLE IF NOT EXISTS categories (
	id_category INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(45) NOT NULL,
    type ENUM("Expense", "Income") NOT NULL,
    global BOOLEAN NOT NULL DEFAULT true,
    id_user INT,
	PRIMARY KEY (id_category),
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS transactions;
CREATE TABLE IF NOT EXISTS transactions (
	id_transaction INT NOT NULL AUTO_INCREMENT,
    type ENUM("Expense", "Income") NOT NULL,
    id_category INT NOT NULL,
	amount INT NOT NULL,
    date date NOT NULL,
    description VARCHAR(45), 
    id_user INT NOT NULL,
	PRIMARY KEY (id_transaction),
    CONSTRAINT fk_transactions_categories
		FOREIGN KEY (id_category)
		REFERENCES categories (id_category)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT fk_transactions_users
		FOREIGN KEY (id_user)
		REFERENCES users (id_user)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);

-- INSERTS FOR USERS

INSERT INTO users (name, surname, email, password)
VALUES ('Angela', 'Moro', 'angela@gmail.com', '$2y$10$BPOsA4vyMpd4m5INBV7w/e1XpsieSfJ8PEjFPI573.FPqA9ZblyQy');

INSERT INTO users (name, surname, email, password)
VALUES ('Unai', 'Benito', 'Unai@gmail.com', '$2y$10$wEOIcZ9GKOy4eFPysSH0HOyMr.bLmev3TN244fXUboTt4rfsTSRre');

-- INSERTS FOR EXPENSE CATEGORIES

INSERT INTO categories (name, type)
VALUES ('Food', 'expense');

INSERT INTO categories (name, type)
VALUES ('Transportation', 'expense');

INSERT INTO categories (name, type)
VALUES ('Housing', 'expense');

INSERT INTO categories (name, type)
VALUES ('Entertainment', 'expense');

INSERT INTO categories (name, type)
VALUES ('Shopping', 'expense');

INSERT INTO categories (name, type)
VALUES ('Subscriptions', 'expense');

-- INSERTS FOR INCOME CATEGORIES

INSERT INTO categories (name, type)
VALUES ('Salary', 'income');

INSERT INTO categories (name, type)
VALUES ('Bonus', 'income');

INSERT INTO categories (name, type)
VALUES ('Payments', 'income');

INSERT INTO categories (name, type)
VALUES ('Reimbursement', 'income');

INSERT INTO categories (name, type)
VALUES ('Side Hustle', 'income');

-- INSERTS FOR EXPENSES

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('expense', 1, 100, '2023-01-01', 'Groceries', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('expense', 5, 50, '2023-01-02', 'Utilities', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('expense', 2, 20, '2023-01-03', 'Transportation', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('expense', 3, 30, '2023-01-04', 'Entertainment', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('expense', 4, 40, '2023-01-05', 'Shopping', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('expense', 1, 150, '2023-01-06', 'Dining out', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('expense', 5, 75, '2023-01-07', 'Clothing', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('expense', 2, 10, '2023-01-08', 'Personal Care', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('expense', 3, 25, '2023-01-09', 'Subscriptions', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('expense', 4, 12, '2023-01-10', 'Fuel', 2);

-- INSERTS FOR INCOME

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('income', 7, 2800, '2023-01-01', 'Salary', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('income', 8, 150, '2023-01-02', 'Interest', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('income', 8, 75, '2023-01-03', 'Productivity Bonus', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('income', 9, 200, '2023-01-04', 'Debt', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('income', 11, 50, '2023-01-08', 'Freelance', 2);

-- Inserts para distintos meses del año 2023
INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('income', 7, 2800, '2023-02-01', 'Salary', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('income', 8, 150, '2023-03-02', 'Interest', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('income', 8, 75, '2023-04-03', 'Productivity Bonus', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('income', 9, 200, '2023-05-04', 'Debt', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('income', 11, 50, '2023-06-08', 'Freelance', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('income', 8, 2000, '2023-12-08', 'Extra Payment', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('income', 8, 4000, '2023-08-08', 'Extra Payment', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('expense', 3, 4000, '2023-05-08', 'Health Care', 2);