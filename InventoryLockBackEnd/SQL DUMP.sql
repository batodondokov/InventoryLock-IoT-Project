DROP DATABASE inventory_lock;
CREATE DATABASE inventory_lock; --Создание базы данных
USE inventory_lock;

DROP TABLE IF EXISTS `users`; 

--Создание таблицы users
CREATE TABLE IF NOT EXISTS `users` ( 
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_email` VARCHAR(255) NOT NULL,
    `user_password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
);


--Удаление таблицы authentications
DROP TABLE IF EXISTS `authentications`; 

--Создание таблицы authentications
CREATE TABLE IF NOT EXISTS `authentications` ( 
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_email` VARCHAR(255) NOT NULL,
    `user_token` VARCHAR(255) NOT NULL,
    `authentificated_at` TIMESTAMP,
    PRIMARY KEY (`id`)
);


--Удаление таблицы containers
DROP TABLE IF EXISTS `containers`; 

--Создание таблицы containers
CREATE TABLE IF NOT EXISTS `containers` ( 
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `color` VARCHAR(50) NOT NULL,
    `status` BOOLEAN NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
);

-- Вставка значений в таблицу containers
INSERT INTO `containers` (`color`)
VALUES ('red');


--Удаление таблицы accounting_records
DROP TABLE IF EXISTS `accounting_records`; 

--Создание таблицы accounting_records
CREATE TABLE IF NOT EXISTS `accounting_records` ( 
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `container_id` INT UNSIGNED NOT NULL,
    `authentication_id` INT UNSIGNED NOT NULL,
    `status` BOOLEAN NOT NULL DEFAULT 0,
    `photo_path` VARCHAR(255),
    `recorded_at` TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`container_id`)  REFERENCES `containers` (`id`),
    FOREIGN KEY (`authentication_id`)  REFERENCES `authentications` (`id`)
);

--Триггер на обновление статуса контейнера
CREATE TRIGGER status_update
AFTER INSERT ON `accounting_records`
FOR EACH ROW
UPDATE `containers`
SET `status` = (SELECT `status` FROM `accounting_records` ORDER BY id DESC LIMIT 1)
WHERE `id` = (SELECT `container_id` FROM `accounting_records` ORDER BY id DESC LIMIT 1);
