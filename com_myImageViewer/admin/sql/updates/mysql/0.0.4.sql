DROP TABLE IF EXISTS `#__myImageViewer_image`;
DROP TABLE IF EXISTS `#__myImageViewer_imageCategory`;


CREATE TABLE IF NOT EXISTS `#__myImageViewer_imageCategory` (
  `id` SERIAL NOT NULL,
  `categoryName` VARCHAR(45)  NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `#__myImageViewer_image` (
  `id` SERIAL NOT NULL,
  `imageName` VARCHAR(45)  NOT NULL,
  `categoryId` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `imageDescription` VARCHAR(200),
  `imageProjection` VARCHAR(200),
  `imageUrl` VARCHAR(200) NOT NULL,
  `imageCitation` VARCHAR(200),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`categoryId`) REFERENCES `#__myImageViewer_imageCategory` (`id`)
) ENGINE = InnoDB;




INSERT INTO `#__myImageViewer_imageCategory` (`categoryName`) VALUES
	('Chest'),
	('Head'),
    ('Ankle'),
    ('Shoulder'),
	('Face'),
	('Arm');
	
	
INSERT INTO `#__myImageViewer_image` (`imageName`, `categoryId`, `imageDescription`, `imageUrl`) VALUES
	('Female1', 1, 'This is an image of a lung', 'media/com_myImageViewer/images/normal-chest-radiograph-female-5.png'),
	('Male2', 2, 'This is an image of a head', 'media/com_myImageViewer/images/abdominal-aortic-aneurysm-11.jpg'),
	('Female3', 3, 'This is an ankle', 'media/com_myImageViewer/images/Ankle1.png'),
    ('Male4', 4, 'This is a shoulder', 'media/com_myImageViewer/images/Shoulder1.png'),
	('Female5', 5, 'This is a face', 'media/com_myImageViewer/images/FemaleFace1.jpeg'),
    ('Male6', 6, 'This is an arm', 'media/com_myImageViewer/images/MaleArm2.png');



