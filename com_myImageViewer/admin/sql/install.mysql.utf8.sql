DROP TABLE IF EXISTS `#__myImageViewer_image`;
DROP TABLE IF EXISTS `#__myImageViewer_imageCategory`;

CREATE TABLE IF NOT EXISTS `#__myImageViewer_imageCategory` (
	`id` SERIAL NOT NULL,
	`categoryName` VARCHAR(30) NOT NULL UNIQUE,
	PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `#__myImageViewer_image` (
	`id` SERIAL NOT NULL,
	`imageName` VARCHAR(60) NOT NULL,
	`categoryId` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
	`imageDescription` VARCHAR(12000),
	`imageUrl` VARCHAR(200) NOT NULL,
	`isHidden` BOOLEAN NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`categoryId`) REFERENCES `#__myImageViewer_imageCategory` (`id`),
	UNIQUE KEY `unique_imageName_categoryId` (`imageName`, `categoryId`)
) ENGINE = InnoDB;



INSERT INTO `#__myImageViewer_imageCategory` (`categoryName`) VALUES
	('Hip'),
	('Acetabulum'),
    ('Abdomen'),
    ('Ankle'),
	('Calcaneum'),
	('Tibia-Fibula'),
	('Knee'),
	('Femur'),
	('Pelvis'),
	('AC Joints'),
	('Chest'),
	('Ribs'),
	('Sternum'),
	('SC Joints'),
	('Toes'),
	('Foot'),
	('Forearm'),
	('Elbow'),
	('Shoulder'),
	('Scapula'),
	('Humerus'),
	('Clavicle'),
	('Thumb'),
	('Finger'),
	('Hand'),
	('Norgaard\'s'),
	('Wrist'),
	('Scaphoid');

INSERT INTO `#__myimageviewer_image` (`imageName`, `categoryId`, `imageDescription`, `imageUrl`, `isHidden`) VALUES
('An x-ray of someones wrists, they look to be pretty healthy.', 26, CONCAT(REPEAT('This is a lengthy description that will test overflow handling. ', 180)), 'media/com_myImageViewer/images/Norgaard\'s/An x-ray of someones wrists, they look to be pretty healthy..jpeg', 0),
('Ankle x-ray', 4, '', 'media/com_myImageViewer/images/Ankle/Ankle x-ray.png', 0),
('Chest x-ray 1', 11, 'This is an x-ray of a chest.', 'media/com_myImageViewer/images/Chest/Chest x-ray 1.jpg', 0),
('Chest x-ray 2', 11, 'This is also an x-ray of a chest.', 'media/com_myImageViewer/images/Chest/Chest x-ray 2.png', 0),
('Arm (not broken)', 17, 'This is an x-ray image of an arm that is not broken. If your arm does not look like this, please consult a doctor.', 'media/com_myImageViewer/images/Forearm/Arm (not broken).png', 0),
('Example shoulder image', 19, 'This is a shoulder. The shoulder is important because we would not be able to carry backpacks without it.', 'media/com_myImageViewer/images/Shoulder/Example shoulder image.png', 0);
