<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 *
 */

class SaveAnswersModel extends BaseModel {

    
	public function saveAnswer($userId, $quizId, $questionNumber, $answerNumber) {
		
		$db = Factory::getDbo();      


		$check = $db->getQuery(true)
			//Query
			->select('*')
			->from($db->quoteName('#__myQuiz_userAnswers', 'ua'))
			->where($db->quoteName('ua.userId') . '=' . $db->quote($userId) 
				. 'AND' . $db->quoteName('ua.quizId') . '=' . $db->quote($quizId)
				. 'AND' . $db->quoteName('ua.questionNumber') . '=' . $db->quote($questionNumber));


		$columns = array('userId','quizId','questionNumber', 'answerNumber');
		$data = [$userId, $quizId, $questionNumber, $answerNumber]; 

		
		if(!$check) {
			$query = $db->getQuery(true)
			->insert($db->quoteName('#__myQuiz_userAnswers'))
			->columns($db->quoteName($columns))
			->values(implode(',', $db->quote($data)));
		
			$db->setQuery($query);
			$result = $db->execute();

			return true;
		}

		else{
			$query = $db->getQuery(true)
				->delete($db->quoteName('#__myQuiz_userAnswers'))
				->where($db->quoteName('userId') . '=' . $db->quote($userId)
				. 'AND' . $db->quoteName('quizId') . '=' . $db->quote($quizId)
				. 'AND' . $db->quoteName('questionNumber') . '=' . $db->quote($questionNumber));
		
			// Check query is correct    
        	// echo $query->dump();

			try {
				$db->setQuery($query);
				$result = $db->execute();
			}
			catch (RuntimeException $e){
				echo $e->getMessage();
			}

			if($result) {
				$query = $db->getQuery(true)
				->insert($db->quoteName('#__myQuiz_userAnswers'))
				->columns($db->quoteName($columns))
				->values(implode(',', $db->quote($data)));
			
				$db->setQuery($query);
	
				$result = $db->execute();
				return true;
			}

			return false;
		}
		
	}


        
}