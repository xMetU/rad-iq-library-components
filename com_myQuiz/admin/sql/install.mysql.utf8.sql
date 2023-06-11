DROP TABLE IF EXISTS `#__myQuiz_quizUserSummary`;
DROP TABLE IF EXISTS `#__myQuiz_userAnswers`;
DROP TABLE IF EXISTS `#__myQuiz_answer`;
DROP TABLE IF EXISTS `#__myQuiz_question`;
DROP TABLE IF EXISTS `#__myQuiz_quiz`;



CREATE TABLE IF NOT EXISTS `#__myQuiz_quiz` (
  `id` SERIAL NOT NULL,
  `imageId` bigint(20) UNSIGNED NOT NULL,
  `title` VARCHAR(60) NOT NULL,
  `description` VARCHAR(200),
  `attemptsAllowed` INT NOT NULL,
  `isHidden` BOOLEAN NOT NULL DEFAULT '1',
  UNIQUE (`title`),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`imageId`) REFERENCES `#__myImageViewer_image` (`id`)
) ENGINE = InnoDB; 

CREATE TABLE IF NOT EXISTS `#__myQuiz_question` (
  `id` SERIAL NOT NULL,
  `quizId` bigint(20) UNSIGNED NOT NULL,
  `description` VARCHAR(200) NOT NULL,
  `feedback` VARCHAR(200),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`quizId`) REFERENCES `#__myQuiz_quiz` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `#__myQuiz_answer` (
  `id` SERIAL NOT NULL,
  `questionId` bigint(20) UNSIGNED NOT NULL,
  `description` VARCHAR(200) NOT NULL,
  `markValue` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`questionId`) REFERENCES `#__myQuiz_question` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `#__myQuiz_userAnswers` (
  `userId` int(11) NOT NULL,
  `answerId` bigint(20) UNSIGNED NOT NULL,
  `attemptNumber` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`userId`, `answerId`, `attemptNumber`),
  FOREIGN KEY (`userId`) REFERENCES `#__users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`answerId`) REFERENCES `#__myQuiz_answer` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `#__myQuiz_quizUserSummary` (
  `userId` int(11) NOT NULL,
  `quizId` bigint(20) UNSIGNED NOT NULL,
  `attemptNumber` INT NOT NULL,
  `score` INT NOT NULL,
  `maxScore` INT NOT NULL,
  `startTime` DATETIME,
  `finishTime` DATETIME,
  PRIMARY KEY (`userId`, `quizId`, `attemptNumber`),
  FOREIGN KEY (`userId`) REFERENCES `#__users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`quizId`) REFERENCES `#__myQuiz_quiz` (`id`)  ON DELETE CASCADE
) ENGINE = InnoDB;



INSERT INTO `#__myQuiz_quiz` (`imageId`, `title`, `description`, `attemptsAllowed`) VALUES
	(1, 'Example Quiz', 'A quiz that is to be used as an example.', 5);

INSERT INTO `#__myQuiz_question` (`quizId`, `description`, `feedback`) VALUES
	(1, 'Is this quiz an example?', 'The quiz is an example, you can tell by the title.'),
	(1, 'What should you use this quiz for?', 'The example quiz should only be used to test the website.'),
	(1, 'Does this quiz effectively test the website?', 'While it tests basic functionality, it misses some edge cases.'),
  (1, 'Which of the following statements are true?', 'They are all true.');
	
INSERT INTO `#__myQuiz_answer` (`questionId`, `description`, `markValue`) VALUES
	(1, 'Yes', 1),
	(1, 'No', 0),
	(2, 'Testing the website', 1),
	(2, 'Measuring IQ', 0),
	(2, 'Passing the time', 0),
	(3, 'Yes, completely', 0),
	(3, 'Yes, but only partially', 1),
	(3, 'No, not at all', 0),
  (4, 'This answer is worth 0 marks', 0),
  (4, 'This answer is worth 1 mark', 1),
  (4, 'This answer is worth 2 marks', 2),
  (4, 'This answer is worth 3 marks', 3);
