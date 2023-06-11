DROP TABLE IF EXISTS `#__myQuiz_quizUserSummary`;
DROP TABLE IF EXISTS `#__myQuiz_userAnswers`;
DROP TABLE IF EXISTS `#__myQuiz_answer`;
DROP TABLE IF EXISTS `#__myQuiz_question`;
DROP TABLE IF EXISTS `#__myQuiz_quiz`;



CREATE TABLE IF NOT EXISTS `#__myQuiz_quiz` (
  `id` SERIAL NOT NULL,
  `imageId` bigint(20) UNSIGNED NOT NULL,
  `title` VARCHAR(60)  NOT NULL,
  `description` VARCHAR(200)  NOT NULL,
  `attemptsAllowed` INT DEFAULT '1',
  `isHidden` BOOLEAN NOT NULL DEFAULT 0,
  UNIQUE (`title`),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`imageId`) REFERENCES `#__myImageViewer_image` (`id`)
) ENGINE = InnoDB; 



CREATE TABLE IF NOT EXISTS `#__myQuiz_question` (
  `questionNumber` INT NOT NULL,
  `quizId` bigint(20) UNSIGNED NOT NULL,
  `questionDescription` VARCHAR(200),
  `feedback` VARCHAR(200),
  `markValue` INT DEFAULT '1',
  PRIMARY KEY (`questionNumber`, `quizId`),
  FOREIGN KEY (`quizId`) REFERENCES `#__myQuiz_quiz` (`id`)
) ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `#__myQuiz_answer` (
  `answerNumber` INT NOT NULL,
  `questionNumber` INT NOT NULL,
  `quizId` bigint(20) UNSIGNED NOT NULL,
  `answerDescription` VARCHAR(200),
  `isCorrect` BOOLEAN,
  PRIMARY KEY (`answerNumber`, `questionNumber`, `quizId`),
  FOREIGN KEY (`questionNumber`, `quizId`) REFERENCES `#__myQuiz_question` (`questionNumber`, `quizId`),
  FOREIGN KEY (`quizId`) REFERENCES `#__myQuiz_quiz` (`id`)
) ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `#__myQuiz_userAnswers` (
  `userId` int(11) NOT NULL,
  `quizId` bigint(20) UNSIGNED NOT NULL,
  `questionNumber` INT NOT NULL,
  `answerNumber` INT NOT NULL,
  `attemptNumber` INT NOT NULL,
  PRIMARY KEY (`userId`, `quizId`,`questionNumber`, `answerNumber`, `attemptNumber`),
  FOREIGN KEY (`userId`) REFERENCES `#__users` (`id`),
  FOREIGN KEY (`quizId`) REFERENCES `#__myQuiz_quiz` (`id`),
  FOREIGN KEY (`questionNumber`, `quizId`) REFERENCES `#__myQuiz_question` (`questionNumber`, `quizId`),
  FOREIGN KEY (`answerNumber`, `questionNumber`, `quizId`) REFERENCES `#__myQuiz_answer` (`answerNumber`, `questionNumber`, `quizId`)
) ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `#__myQuiz_quizUserSummary` (
  `userId` int(11) NOT NULL,
  `quizId` bigint(20) UNSIGNED NOT NULL,
  `attemptNumber` INT NOT NULL,
  `userScore` INT NOT NULL DEFAULT '0',
  `quizTotalMarks` INT NOT NULL,
  `quizStarted` DATETIME,
  `quizFinished` DATETIME,
  PRIMARY KEY (`userId`, `quizId`, `attemptNumber`),
  FOREIGN KEY (`userId`) REFERENCES `#__users` (`id`),
  FOREIGN KEY (`quizId`) REFERENCES `#__myQuiz_quiz` (`id`)
) ENGINE = InnoDB;






INSERT INTO `#__myQuiz_quiz` (`imageId`, `title`, `description`, `attemptsAllowed`) VALUES
	(1, 'Example Quiz', 'This is an example quiz to demonstrate quiz functionality', 5);
	
	
	
INSERT INTO `#__myQuiz_question` (`quizId`, `questionNumber`, `questionDescription`, `feedback`, `markValue`) VALUES
	(1, 1, 'Which medical terminology is relevant to this image?', 'The correct choice for this answer is (1), because of this particular medical reason', 4),
	(1, 2, 'What medical aspects are being demonstrated in this image?', 'The correct choice for this answer is (2), because of this other particular medical reason', 8);
	
	
	
INSERT INTO `#__myQuiz_answer` (`quizId`, `questionNumber`, `answerNumber`, `answerDescription`, `isCorrect`) VALUES
	(1, 1, 1, 'Fracture', 1),
	(1, 1, 2, 'Rupture', 0),
	(1, 1, 3, 'Swelling', 0),
	(1, 1, 4, 'Bleeding', 0),
	(1, 2, 1, 'Lupus', 0),
	(1, 2, 2, 'Endometriosis', 1),
	(1, 2, 3, 'Amnesia', 0),
	(1, 2, 4, 'Hypochondria', 0);
	
	
	
	

	
	
	
	


