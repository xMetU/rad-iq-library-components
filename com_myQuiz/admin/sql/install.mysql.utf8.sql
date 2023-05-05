DROP TABLE IF EXISTS `#__myQuiz_userAnswers`;
DROP TABLE IF EXISTS `#__myQuiz_answer`;
DROP TABLE IF EXISTS `#__myQuiz_question`;
DROP TABLE IF EXISTS `#__myQuiz_quiz`;



CREATE TABLE IF NOT EXISTS `#__myQuiz_quiz` (
  `id` SERIAL NOT NULL,
  `imageId` bigint(20) UNSIGNED NOT NULL,
  `title` VARCHAR(45)  NOT NULL,
  `description` VARCHAR(255)  NOT NULL,
  `attemptNumber` INT,
  `attemptsAllowed` INT DEFAULT '1',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`imageId`) REFERENCES `#__myImageViewer_image` (`id`)
) ENGINE = InnoDB; 



CREATE TABLE IF NOT EXISTS `#__myQuiz_question` (
  `questionNumber` INT NOT NULL,
  `quizId` bigint(20) UNSIGNED NOT NULL,
  `questionDescription` VARCHAR(255),
  `feedback` VARCHAR(255),
  `markValue` INT DEFAULT '1',
  PRIMARY KEY (`questionNumber`, `quizId`),
  FOREIGN KEY (`quizId`) REFERENCES `#__myQuiz_quiz` (`id`)
) ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `#__myQuiz_answer` (
  `answerNumber` INT NOT NULL,
  `questionNumber` INT NOT NULL,
  `quizId` bigint(20) UNSIGNED NOT NULL,
  `answerDescription` VARCHAR(255),
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
  PRIMARY KEY (`userId`, `quizId`,`questionNumber`, `answerNumber`),
  FOREIGN KEY (`userId`) REFERENCES `#__users` (`id`),
  FOREIGN KEY (`quizId`) REFERENCES `#__myQuiz_quiz` (`id`),
  FOREIGN KEY (`questionNumber`, `quizId`) REFERENCES `#__myQuiz_question` (`questionNumber`, `quizId`),
  FOREIGN KEY (`answerNumber`, `questionNumber`, `quizId`) REFERENCES `#__myQuiz_answer` (`answerNumber`, `questionNumber`, `quizId`)
) ENGINE = InnoDB;




INSERT INTO `#__myQuiz_quiz` (`imageId`, `title`, `description`, `attemptsAllowed`) VALUES
	(1, 'Quiz Number 1', 'A series of questions about this image', 2),
	(2, 'Quiz Number 2', 'A series of questions about another image', 2);
	
	
	
INSERT INTO `#__myQuiz_question` (`quizId`, `questionNumber`, `questionDescription`, `feedback`, `markValue`) VALUES
	(1, 1, 'What is going on in this image?', 'The correct choice for this answer is c as there are reasons', 4),
	(1, 2, 'How many things are in this image?', 'The correct choice for this answer is a for reasons described', 8),
	(2, 1, 'Where are the bits in this image?', 'The correct choice for this answer is b. You should know this', 5),
	(2, 2, 'Where would everyone be in this image?', 'The correct choice for this answer is d. I cant say why', 3);
	
	
	
INSERT INTO `#__myQuiz_answer` (`quizId`, `questionNumber`, `answerNumber`, `answerDescription`, `isCorrect`) VALUES
	(1, 1, 1, 'It has a face', 0),
	(1, 1, 2, 'There are too many bones', 1),
	(1, 2, 1, 'There is a sophisticated answer', 1),
	(1, 2, 2, 'It is an alien', 0),
	(2, 1, 1, 'It has a library card', 0),
	(2, 1, 2, 'medical reasons', 1),
	(2, 2, 1, 'There is too much blood', 0),
	(2, 2, 2, 'The answer is elusive', 1);