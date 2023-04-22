DROP TABLE IF EXISTS `#__myImageViewer_image`;

CREATE TABLE `#__myImageViewer_image` (
  `id` SERIAL NOT NULL,
  `imageName` VARCHAR(45)  NOT NULL,
  `imageCategory` VARCHAR(45)  NOT NULL,
  `imageDescription` VARCHAR(200),
  `imageProjection` VARCHAR(200),
  `imageUrl` VARCHAR(200),
  `imageCitation` VARCHAR(200),
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;


INSERT INTO `#__myImageViewer_image` (`imageName`, `imageCategory`, `imageProjection`, `imageDescription`, imageUrl) VALUES
    ('Female1','Chest','AP','This is an image of a lung','media/com_myImageViewer/images/normal-chest-radiograph-female-5.png'),
    ('Male2','Head','Lat','This is an image of a head','media/com_myImageViewer/images/abdominal-aortic-aneurysm-11.jpg'),
	('Female3','Ankle','Obl','This is an ankle','media/com_myImageViewer/images/Ankle1.png'),
    ('Male4','Shoulder','Axial','This is a shoulder','media/com_myImageViewer/images/Shoulder1.png'),
	('Female5','Face','Obl','This is a face','media/com_myImageViewer/images/FemaleFace1.jpeg'),
    ('Male6','Arm','Lat','This is an arm','media/com_myImageViewer/images/MaleArm2.png');
