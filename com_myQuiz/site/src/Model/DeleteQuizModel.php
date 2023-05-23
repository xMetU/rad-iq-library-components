<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseModel;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */

class DeleteQuizModel extends BaseModel {


	public function deleteQuiz($quizId) {
		$db = Factory::getDbo();  

		// Delete from quizUserSummary
		try {
			$query = $db->getQuery(true)
                ->delete($db->quoteName('#__myQuiz_quizUserSummary'))
				->where($db->quoteName('quizId') . '=' . $db->quote($quizId));
			
			$db->setQuery($query);
			$result = $db->execute();

		}
		catch (\Exception $e) {
			echo $e->getMessage();
		}

		// Delete from userAnswers
		try {
			$query = $db->getQuery(true)
                ->delete($db->quoteName('#__myQuiz_userAnswers'))
				->where($db->quoteName('quizId') . '=' . $db->quote($quizId));
			
			$db->setQuery($query);
			$result = $db->execute();

		}
		catch (\Exception $e) {
			echo $e->getMessage();
		}

		// Delete from answer
		try {
			$query = $db->getQuery(true)
                ->delete($db->quoteName('#__myQuiz_answer'))
				->where($db->quoteName('quizId') . '=' . $db->quote($quizId));
			
			$db->setQuery($query);
			$result = $db->execute();

		}
		catch (\Exception $e) {
			echo $e->getMessage();
		}

		// Delete from question
		try {
			$query = $db->getQuery(true)
                ->delete($db->quoteName('#__myQuiz_question'))
				->where($db->quoteName('quizId') . '=' . $db->quote($quizId));
			
			$db->setQuery($query);
			$result = $db->execute();

		}
		catch (\Exception $e) {
			echo $e->getMessage();
		}

		// Delete from quiz
		try {
			$query = $db->getQuery(true)
                ->delete($db->quoteName('#__myQuiz_quiz'))
				->where($db->quoteName('id') . '=' . $db->quote($quizId));
			
			$db->setQuery($query);
			$result = $db->execute();

		}
		catch (\Exception $e) {
			echo $e->getMessage();
		}
		
	}
        
}