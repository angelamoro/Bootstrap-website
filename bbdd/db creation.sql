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
    global BOOLEAN NOT NULL DEFAULT false,
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

INSERT INTO categories (name, type, global)
VALUES ('Food', 'expense', 1);

INSERT INTO categories (name, type, global)
VALUES ('Transportation', 'expense', 1);

INSERT INTO categories (name, type, global)
VALUES ('Housing', 'expense', 1);

INSERT INTO categories (name, type, global)
VALUES ('Entertainment', 'expense', 1);

INSERT INTO categories (name, type, global)
VALUES ('Savings', 'expense', 1);

-- INSERTS FOR INCOME CATEGORIES

INSERT INTO categories (name, type, global)
VALUES ('Salary', 'income', 1);

INSERT INTO categories (name, type, global)
VALUES ('Bonus', 'income', 1);

INSERT INTO categories (name, type, global)
VALUES ('Side Hustle', 'income', 1);

-- INSERTS FOR EXPENSES

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 1, 150, '2023-01-01', 'Groceries', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 5, 450, '2023-02-02', 'Repair car', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 2, 80, '2023-03-03', 'Fuel', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 3, 800, '2023-04-04', 'Insurance', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 4, 150, '2023-05-05', 'Shopping', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 1, 150, '2023-06-06', 'Dining out', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 5, 75, '2023-07-07', 'Clothing', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 5, 140, '2023-08-08', 'Hair Care', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 4, 50, '2023-09-09', 'Subscriptions', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 3, 500, '2023-10-10', 'Painting', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 2, 20, '2023-11-11', 'Bus', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 4, 30, '2023-12-12', 'Cinema', 2);

---

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 3, 2000, '2023-01-01', 'Furniture', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 1, 200, '2023-02-02', 'Mercadona', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 4, 5, '2023-03-03', 'Suscriptions', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 2, 1000, '2023-04-04', 'Plane', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 5, 1500, '2023-05-05', 'Tokio trip', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 5, 50, '2023-06-06', 'Clothes', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 1, 150, '2023-07-07', 'Organic food', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 3, 560, '2023-08-08', 'Handyman', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 2, 50, '2023-09-09', 'Bus', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 1, 500, '2023-10-10', 'Dining out', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 3, 140, '2023-11-11', 'Chair', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Expense', 3, 150, '2023-12-12', 'Cat food', 1);

-- INSERTS FOR INCOME

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 2400, '2023-01-01', '', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 2400, '2023-02-02', '', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 2400,'2023-03-03', '', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 7, 1000,'2023-03-03', 'Productivity', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 2400, '2023-04-04', '', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 8, 4000, '2023-04-04', 'Web desing', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 2400, '2023-05-05', '', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 2400, '2023-06-06', '', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 2400, '2023-07-07', '', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 7, 1000,'2023-07-07', 'Productivity', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 2400, '2023-08-08', '', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 2400, '2023-09-09', '', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 2400, '2023-10-10', '', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 2400, '2023-11-11', '', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 8, 4000, '2023-11-11', 'Web desing', 2);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 2400, '2023-12-12', '', 2);

----

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 4000, '2023-01-01', '', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 4000, '2023-02-02', '', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 4000,'2023-03-03', '', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 7, 2500,'2023-03-03', 'Productivity', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 4000, '2023-04-04', '', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 8, 3000, '2023-04-04', 'Web desing', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 4000, '2023-05-05', '', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 4000, '2023-06-06', '', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 4000, '2023-07-07', '', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 7, 2500,'2023-07-07', 'Productivity', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 4000, '2023-08-08', '', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 4000, '2023-09-09', '', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 4000, '2023-10-10', '', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 4000, '2023-11-11', '', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 8, 3000, '2023-11-11', 'Web desing', 1);

INSERT INTO transactions (type, id_category, amount, date, description, id_user)
VALUES ('Income', 6, 4000, '2023-12-12', '', 1);
