CREATE TABLE `kchat_rooms` (
	`user` VARCHAR(36) NOT NULL,
	`room` VARCHAR(255) NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	`deleted` TINYINT(1) NOT NULL,
	PRIMARY KEY (`user`, `room`)
)
ENGINE=InnoDB;
