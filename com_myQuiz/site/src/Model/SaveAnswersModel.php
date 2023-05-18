<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseModel;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */

class SaveAnswersModel extends BaseModel {


	public function checkAttempts($userId, $quizId) {
		$db = Factory::getDbo();  
		$attemptNumber = 0;  

		try {
			$query = $db->getQuery(true)
                ->select($db->quoteName('qus.attemptNumber'))
                ->from($db->quoteName('#__myQuiz_quizUserSummary', 'qus'))
				->where($db->quoteName('qus.userId') . '=' . $db->quote($userId) . 'AND' . $db->quoteName('qus.quizId') . '=' . $db->quote($quizId));
			
			$db->setQuery($query);
			$num = $db->loadObjectList();

			if($num) {
				foreach($num as $n) {
					if($n->attemptNumber > $attemptNumber) {
						$attemptNumber = $n->attemptNumber;
					}	
				}
			}
		}
		catch (\Exception $e) {
			echo $e->getMessage();
		}
		
		return $attemptNumber;		
	}


    
	public function saveAnswers($userQuestionData) {
		
		$db = Factory::getDbo();   
		$columns = array('userId', 'quizId', 'questionNumber', 'answerNumber', 'attemptNumber'); 
		
		$attemptNumber = Factory::getApplication()->getUserState('myQuiz.userAttemptNumber'); 
		
		foreach($userQuestionData as $data) {
			$userId = $data['userId'];
			$quizId = $data['quizId'];
			$questionNumber = $data['questionNumber'];
			$answerNumber = $data['answerNumber'];

			$userAnswerData = [$userId, $quizId, $questionNumber, $answerNumber, $attemptNumber]; 
			

			try {
				$query = $db->getQuery(true)
				->insert($db->quoteName('#__myQuiz_userAnswers'))
				->columns($db->quoteName($columns))
				->values(implode(',', $db->quote($userAnswerData)));
				
				$db->setQuery($query);
				$result = $db->execute();
			}
			catch (\Exception $e) {
				echo $e->getMessage();
			}
		}	
	}

	public function saveQuiz($marks, $total) {
		
		$db = Factory::getDbo();
		
		$userId = Factory::getApplication()->getUserState('myQuiz.userUserId'); 
		$quizId = Factory::getApplication()->getUserState('myQuiz.userQuizId'); 
		$attemptNumber = Factory::getApplication()->getUserState('myQuiz.userAttemptNumber'); 

		$columns = array('userId', 'quizId', 'attemptNumber', 'userScore', 'quizTotalMarks');
		$quizSummaryData = [$userId, $quizId, $attemptNumber, $marks, $total];

		try {
			$query = $db->getQuery(true)
			->insert($db->quoteName('#__myQuiz_quizUserSummary'))
			->columns($db->quoteName($columns))
			->values(implode(',', $db->quote($quizSummaryData)));
			
			$db->setQuery($query);
			$result = $db->execute();
		}
		catch (\Exception $e) {
			echo $e->getMessage();
		}
	}


        
}