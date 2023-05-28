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
	(1, 'Quiz Number 1', 'A series of questions about this image', 5),
	(2, 'Quiz Multiple Answers Score Test', 'Multiple answers have been selected as correct. Is the score correct? The whole selection and scoring process might break if multiples are allowed', 5);
	
	
	
INSERT INTO `#__myQuiz_question` (`quizId`, `questionNumber`, `questionDescription`, `feedback`, `markValue`) VALUES
	(1, 1, 'What is going on in this image?', 'The correct choice for this answer is c as there are reasons', 4),
	(1, 2, 'How many things are in this image?', 'The correct choice for this answer is a for reasons described', 8),
	(2, 1, 'Where are the bits in this image?', 'The correct choice for this answer is b. You should know this', 5),
	(2, 2, 'Where would everyone be in this image?', 'The correct choice for this answer is d. I cant say why', 5);
	
	
	
INSERT INTO `#__myQuiz_answer` (`quizId`, `questionNumber`, `answerNumber`, `answerDescription`, `isCorrect`) VALUES
	(1, 1, 1, 'It has a face', 0),
	(1, 1, 2, 'There are too many bones', 1),
	(1, 2, 1, 'There is a sophisticated answer', 1),
	(1, 2, 2, 'It is an alien', 0),
	(2, 1, 1, 'It has a library card', 1),
	(2, 1, 2, 'medical reasons', 1),
	(2, 2, 1, 'There is too much blood', 1),
	(2, 2, 2, 'The answer is elusive', 1);
	
	
	
	
	
INSERT INTO `#__myQuiz_quiz` (`imageId`, `title`, `description`, `attemptsAllowed`) VALUES
	(3, 'Questions Display Test', '15 Questions to check if they display correctly', 5),
	(4, 'Many Questions Display Test', '30 Questions to check if they display correctly', 5);
	
	
	
INSERT INTO `#__myQuiz_question` (`quizId`, `questionNumber`, `questionDescription`, `feedback`, `markValue`) VALUES
	(3, 1, 'What is going on in this image?', 'The correct choice for this answer is c as there are reasons', 5),
	(3, 2, 'How many things are in this image?', 'The correct choice for this answer is a for reasons described', 5),
	(3, 3, 'Where are the bits in this image?', 'The correct choice for this answer is b. You should know this', 5),
	(3, 4, 'Where would everyone be in this image?', 'The correct choice for this answer is d. I cant say why', 5),
	(3, 5, 'What is going on in this image?', 'The correct choice for this answer is c as there are reasons', 5),
	(3, 6, 'How many things are in this image?', 'The correct choice for this answer is a for reasons described', 5),
	(3, 7, 'Where are the bits in this image?', 'The correct choice for this answer is b. You should know this', 5),
	(3, 8, 'Where would everyone be in this image?', 'The correct choice for this answer is d. I cant say why', 5),
	(3, 9, 'What is going on in this image?', 'The correct choice for this answer is c as there are reasons', 5),
	(3, 10, 'How many things are in this image?', 'The correct choice for this answer is a for reasons described', 5),
	(3, 11, 'Where are the bits in this image?', 'The correct choice for this answer is b. You should know this', 5),
	(3, 12, 'Where would everyone be in this image?', 'The correct choice for this answer is d. I cant say why', 5),
	(3, 13, 'What is going on in this image?', 'The correct choice for this answer is c as there are reasons', 5),
	(3, 14, 'How many things are in this image?', 'The correct choice for this answer is a for reasons described', 5),
	(3, 15, 'Where are the bits in this image?', 'The correct choice for this answer is b. You should know this', 5);
	
	
	
	
INSERT INTO `#__myQuiz_answer` (`quizId`, `questionNumber`, `answerNumber`, `answerDescription`, `isCorrect`) VALUES
	(3, 1, 1, 'It has a face', 0),
	(3, 1, 2, 'There are too many bones', 1),
	(3, 2, 1, 'There is a sophisticated answer', 1),
	(3, 2, 2, 'It is an alien', 0),
	(3, 3, 1, 'It has a library card', 0),
	(3, 3, 2, 'medical reasons', 1),
	(3, 4, 1, 'There is too much blood', 0),
	(3, 4, 2, 'The answer is elusive', 1),
	(3, 5, 1, 'It has a face', 0),
	(3, 5, 2, 'There are too many bones', 1),
	(3, 6, 1, 'There is a sophisticated answer', 1),
	(3, 6, 2, 'It is an alien', 0),
	(3, 7, 1, 'It has a library card', 0),
	(3, 7, 2, 'medical reasons', 1),
	(3, 8, 1, 'There is too much blood', 0),
	(3, 8, 2, 'The answer is elusive', 1),
	(3, 9, 1, 'It has a face', 0),
	(3, 9, 2, 'There are too many bones', 1),
	(3, 10, 1, 'There is a sophisticated answer', 1),
	(3, 10, 2, 'It is an alien', 0),
	(3, 11, 1, 'It has a library card', 0),
	(3, 11, 2, 'medical reasons', 1),
	(3, 12, 1, 'There is too much blood', 0),
	(3, 12, 2, 'The answer is elusive', 1),
	(3, 13, 1, 'It has a face', 0),
	(3, 13, 2, 'There are too many bones', 1),
	(3, 14, 1, 'There is a sophisticated answer', 1),
	(3, 14, 2, 'It is an alien', 0),
	(3, 15, 1, 'It has a library card', 0),
	(3, 15, 2, 'medical reasons', 1);
	
	
INSERT INTO `#__myQuiz_question` (`quizId`, `questionNumber`, `questionDescription`, `feedback`, `markValue`) VALUES
	(4, 1, 'What is going on in this image?', 'The correct choice for this answer is c as there are reasons', 5),
	(4, 2, 'How many things are in this image?', 'The correct choice for this answer is a for reasons described', 5),
	(4, 3, 'Where are the bits in this image?', 'The correct choice for this answer is b. You should know this', 5),
	(4, 4, 'Where would everyone be in this image?', 'The correct choice for this answer is d. I cant say why', 5),
	(4, 5, 'What is going on in this image?', 'The correct choice for this answer is c as there are reasons', 5),
	(4, 6, 'How many things are in this image?', 'The correct choice for this answer is a for reasons described', 5),
	(4, 7, 'Where are the bits in this image?', 'The correct choice for this answer is b. You should know this', 5),
	(4, 8, 'Where would everyone be in this image?', 'The correct choice for this answer is d. I cant say why', 5),
	(4, 9, 'What is going on in this image?', 'The correct choice for this answer is c as there are reasons', 5),
	(4, 10, 'How many things are in this image?', 'The correct choice for this answer is a for reasons described', 5),
	(4, 11, 'Where are the bits in this image?', 'The correct choice for this answer is b. You should know this', 5),
	(4, 12, 'Where would everyone be in this image?', 'The correct choice for this answer is d. I cant say why', 5),
	(4, 13, 'What is going on in this image?', 'The correct choice for this answer is c as there are reasons', 5),
	(4, 14, 'How many things are in this image?', 'The correct choice for this answer is a for reasons described', 5),
	(4, 15, 'Where are the bits in this image?', 'The correct choice for this answer is b. You should know this', 5),
	(4, 16, 'What is going on in this image?', 'The correct choice for this answer is c as there are reasons', 5),
	(4, 17, 'How many things are in this image?', 'The correct choice for this answer is a for reasons described', 5),
	(4, 18, 'Where are the bits in this image?', 'The correct choice for this answer is b. You should know this', 5),
	(4, 19, 'Where would everyone be in this image?', 'The correct choice for this answer is d. I cant say why', 5),
	(4, 20, 'What is going on in this image?', 'The correct choice for this answer is c as there are reasons', 5),
	(4, 21, 'How many things are in this image?', 'The correct choice for this answer is a for reasons described', 5),
	(4, 22, 'Where are the bits in this image?', 'The correct choice for this answer is b. You should know this', 5),
	(4, 23, 'Where would everyone be in this image?', 'The correct choice for this answer is d. I cant say why', 5),
	(4, 24, 'What is going on in this image?', 'The correct choice for this answer is c as there are reasons', 5),
	(4, 25, 'How many things are in this image?', 'The correct choice for this answer is a for reasons described', 5),
	(4, 26, 'Where are the bits in this image?', 'The correct choice for this answer is b. You should know this', 5),
	(4, 27, 'Where would everyone be in this image?', 'The correct choice for this answer is d. I cant say why', 5),
	(4, 28, 'What is going on in this image?', 'The correct choice for this answer is c as there are reasons', 5),
	(4, 29, 'How many things are in this image?', 'The correct choice for this answer is a for reasons described', 5),
	(4, 30, 'Where are the bits in this image?', 'The correct choice for this answer is b. You should know this', 5);
	
	
	
	
INSERT INTO `#__myQuiz_answer` (`quizId`, `questionNumber`, `answerNumber`, `answerDescription`, `isCorrect`) VALUES
	(4, 1, 1, 'It has a face', 0),
	(4, 1, 2, 'There are too many bones', 1),
	(4, 2, 1, 'There is a sophisticated answer', 1),
	(4, 2, 2, 'It is an alien', 0),
	(4, 3, 1, 'It has a library card', 0),
	(4, 3, 2, 'medical reasons', 1),
	(4, 4, 1, 'There is too much blood', 0),
	(4, 4, 2, 'The answer is elusive', 1),
	(4, 5, 1, 'It has a face', 0),
	(4, 5, 2, 'There are too many bones', 1),
	(4, 6, 1, 'There is a sophisticated answer', 1),
	(4, 6, 2, 'It is an alien', 0),
	(4, 7, 1, 'It has a library card', 0),
	(4, 7, 2, 'medical reasons', 1),
	(4, 8, 1, 'There is too much blood', 0),
	(4, 8, 2, 'The answer is elusive', 1),
	(4, 9, 1, 'It has a face', 0),
	(4, 9, 2, 'There are too many bones', 1),
	(4, 10, 1, 'There is a sophisticated answer', 1),
	(4, 10, 2, 'It is an alien', 0),
	(4, 11, 1, 'It has a library card', 0),
	(4, 11, 2, 'medical reasons', 1),
	(4, 12, 1, 'There is too much blood', 0),
	(4, 12, 2, 'The answer is elusive', 1),
	(4, 13, 1, 'It has a face', 0),
	(4, 13, 2, 'There are too many bones', 1),
	(4, 14, 1, 'There is a sophisticated answer', 1),
	(4, 14, 2, 'It is an alien', 0),
	(4, 15, 1, 'It has a library card', 0),
	(4, 15, 2, 'medical reasons', 1),
	(4, 16, 1, 'It has a face', 0),
	(4, 16, 2, 'There are too many bones', 1),
	(4, 17, 1, 'There is a sophisticated answer', 1),
	(4, 17, 2, 'It is an alien', 0),
	(4, 18, 1, 'It has a library card', 0),
	(4, 18, 2, 'medical reasons', 1),
	(4, 19, 1, 'There is too much blood', 0),
	(4, 19, 2, 'The answer is elusive', 1),
	(4, 20, 1, 'It has a face', 0),
	(4, 20, 2, 'There are too many bones', 1),
	(4, 21, 1, 'There is a sophisticated answer', 1),
	(4, 21, 2, 'It is an alien', 0),
	(4, 22, 1, 'It has a library card', 0),
	(4, 22, 2, 'medical reasons', 1),
	(4, 23, 1, 'There is too much blood', 0),
	(4, 23, 2, 'The answer is elusive', 1),
	(4, 24, 1, 'It has a face', 0),
	(4, 24, 2, 'There are too many bones', 1),
	(4, 25, 1, 'There is a sophisticated answer', 1),
	(4, 25, 2, 'It is an alien', 0),
	(4, 26, 1, 'It has a library card', 0),
	(4, 26, 2, 'medical reasons', 1),
	(4, 27, 1, 'There is too much blood', 0),
	(4, 27, 2, 'The answer is elusive', 1),
	(4, 28, 1, 'It has a face', 0),
	(4, 28, 2, 'There are too many bones', 1),
	(4, 29, 1, 'There is a sophisticated answer', 1),
	(4, 29, 2, 'It is an alien', 0),
	(4, 30, 1, 'It has a library card', 0),
	(4, 30, 2, 'medical reasons', 1);
