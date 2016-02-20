CREATE SCHEMA `merchant` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;

CREATE TABLE `merchant`.`transaction` (
  `id_transaction` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_user` INT UNSIGNED NOT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `is_successful` TINYINT NULL,
  `message` TEXT NULL,
  PRIMARY KEY (`id_transaction`));
