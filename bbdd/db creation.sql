CREATE DATABASE IF NOT EXISTS tracker;
USE tracker;

DROP TABLE IF EXISTS categories;
CREATE TABLE IF NOT EXISTS categories (
	id_categorie INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(45) NOT NULL,
    type ENUM("expense", "income") NOT NULL,
	PRIMARY KEY (id_categorie)
);


DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
	id_user INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(45) NOT NULL, 
    surname VARCHAR(45) NOT NULL,
    email VARCHAR(45) NOT NULL,
    password char(70) NOT NULL,
	PRIMARY KEY (id_user)
);


DROP TABLE IF EXISTS transactions;
CREATE TABLE IF NOT EXISTS transactions (
	id_transaction INT NOT NULL AUTO_INCREMENT,
    type ENUM("expense", "income") NOT NULL,
    id_categorie INT NOT NULL,
	amount INT NOT NULL,
    date date NOT NULL,
    description VARCHAR(45), 
    id_user INT NOT NULL,
	PRIMARY KEY (id_transaction),
    CONSTRAINT fk_transactions_categories
		FOREIGN KEY (id_categorie)
		REFERENCES categories (id_categorie)
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
VALUES ('Angela', 'Moro', 'angela@gmail.com', 'angela');

INSERT INTO users (name, surname, email, password)
VALUES ('Unai', 'Benito', 'Unai@gmail.com', 'unaiElMejor');

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
VALUES ('Personal Care', 'expense');

INSERT INTO categories (name, type)
VALUES ('Subscriptions', 'expense');

INSERT INTO categories (name, type)
VALUES ('Fuel', 'expense');

-- INSERTS FOR INCOME CATEGORIES

INSERT INTO categories (name, type)
VALUES ('Salary', 'income');

INSERT INTO categories (name, type)
VALUES ('Interest', 'income');

INSERT INTO categories (name, type)
VALUES ('Bonus', 'income');

INSERT INTO categories (name, type)
VALUES ('Payments', 'income');

INSERT INTO categories (name, type)
VALUES ('Referrals', 'income');

INSERT INTO categories (name, type)
VALUES ('Reimbursement', 'income');

INSERT INTO categories (name, type)
VALUES ('Side Hustle', 'income');

INSERT INTO categories (name, type)
VALUES ('Stocks', 'income');

-- INSERTS FOR EXPENSES

INSERT INTO transactions (type, id_categorie, amount, date, description, id_user)
VALUES ('expense', 1, 100, '2023-01-01', 'Groceries', 1);

INSERT INTO transactions (type, id_categorie, amount, date, description, id_user)
VALUES ('expense', 5, 50, '2023-01-02', 'Utilities', 1);

INSERT INTO transactions (type, id_categorie, amount, date, description, id_user)
VALUES ('expense', 2, 20, '2023-01-03', 'Transportation', 1);

INSERT INTO transactions (type, id_categorie, amount, date, description, id_user)
VALUES ('expense', 3, 30, '2023-01-04', 'Entertainment', 1);

INSERT INTO transactions (type, id_categorie, amount, date, description, id_user)
VALUES ('expense', 4, 40, '2023-01-05', 'Shopping', 1);

INSERT INTO transactions (type, id_categorie, amount, date, description, id_user)
VALUES ('expense', 1, 150, '2023-01-06', 'Dining out', 1);

INSERT INTO transactions (type, id_categorie, amount, date, description, id_user)
VALUES ('expense', 5, 75, '2023-01-07', 'Clothing', 1);

INSERT INTO transactions (type, id_categorie, amount, date, description, id_user)
VALUES ('expense', 2, 10, '2023-01-08', 'Personal Care', 1);

INSERT INTO transactions (type, id_categorie, amount, date, description, id_user)
VALUES ('expense', 3, 25, '2023-01-09', 'Subscriptions', 1);

INSERT INTO transactions (type, id_categorie, amount, date, description, id_user)
VALUES ('expense', 4, 12, '2023-01-10', 'Fuel', 1);

-- INSERTS FOR INCOME

INSERT INTO transactions (type, id_categorie, amount, date, description, id_user)
VALUES ('income', 6, 1800, '2023-01-01', 'Salary', 1);

INSERT INTO transactions (type, id_categorie, amount, date, description, id_user)
VALUES ('income', 7, 150, '2023-01-02', 'Interest', 1);

INSERT INTO transactions (type, id_categorie, amount, date, description, id_user)
VALUES ('income', 8, 75, '2023-01-03', 'Bonus', 1);

INSERT INTO transactions (type, id_categorie, amount, date, description, id_user)
VALUES ('income', 6, 200, '2023-01-04', 'Payments', 1);

INSERT INTO transactions (type, id_categorie, amount, date, description, id_user)
VALUES ('income', 8, 50, '2023-01-08', 'Stocks', 1);


