CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/expresspay_invoices (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`amount` DECIMAL(10,2) NOT NULL,
	`description` TEXT NULL DEFAULT NULL,
	`itemnumber` TEXT NULL DEFAULT NULL,
	`extra` TEXT NULL DEFAULT NULL,
	`datecreated` DATETIME NOT NULL,
	`status` TINYINT(4) NOT NULL,
	`dateofpayment` DATETIME NULL DEFAULT NULL,
	`options` TEXT NULL DEFAULT NULL,
	`options_id` INT(11) NOT NULL,
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `id` (`id`) USING BTREE
) ENGINE = InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/expresspay_options (
	`id` MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
	`name` TINYTEXT NOT NULL,
	`type` TINYTEXT NOT NULL,
	`options` TEXT NOT NULL,
	`isactive` TINYINT(4) NOT NULL,
	PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';