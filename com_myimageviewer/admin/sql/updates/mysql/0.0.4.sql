DROP TABLE IF EXISTS `#__myImageViewer_image`;
DROP TABLE IF EXISTS `#__myImageViewer_imageSubCategory`;
DROP TABLE IF EXISTS `#__myImageViewer_imageCategory`;



CREATE TABLE IF NOT EXISTS `#__myImageViewer_imageCategory` (
	`categoryId` SERIAL NOT NULL,
	`categoryName` VARCHAR(30) NOT NULL UNIQUE,
	PRIMARY KEY (`categoryId`)
) ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `#__myImageViewer_imageSubCategory` (
	`categoryId` bigint(20) UNSIGNED NOT NULL,
	`subcategoryId` SERIAL NOT NULL,
	`subcategoryName` VARCHAR(30) NOT NULL,
	PRIMARY KEY (`categoryId`, `subcategoryId`),
	FOREIGN KEY (`categoryId`) REFERENCES `#__myImageViewer_imageCategory` (`categoryId`)
) ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `#__myImageViewer_image` (
	`id` SERIAL NOT NULL,
	`imageName` VARCHAR(60) NOT NULL,
	`categoryId` bigint(20) UNSIGNED NOT NULL,
	`subcategoryId` bigint(20) UNSIGNED,
	`imageDescription` VARCHAR(12500),
	`imageUrl` VARCHAR(200) NOT NULL,
	`isHidden` BOOLEAN NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`),
	UNIQUE KEY `unique_imageName_categoryId` (`imageName`, `categoryId`),
	FOREIGN KEY (`categoryId`) REFERENCES `#__myImageViewer_imageCategory` (`categoryId`)
) ENGINE = InnoDB;



INSERT INTO `#__myImageViewer_imageCategory` (`categoryName`) VALUES
	('Chest'),
    ('Abdomen'),
    ('Pelvis'),
	('Upper Extremities'),
	('Lower Extremities');

INSERT INTO `#__myImageViewer_imageSubCategory` (`categoryId`, `subcategoryId`, `subcategoryName`) VALUES
	(4, 1, 'Shoulder'),
    (4, 2, 'Elbow'),
    (4, 3, 'Forearm'),
	(4, 4, 'Wrist'),
	(4, 5, 'Hand'),
	(5, 6, 'Knee'),
    (5, 7, 'Ankle'),
    (5, 8, 'Foot');