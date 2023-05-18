<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */


class QuizScoresModel extends ListModel {

    
    // Retrieve the list of quiz scores for a user.
    public function getListQuery(){

        $db = $this->getDatabase();
        $userId = Factory::getUser()->id;

        try {
			$query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__myQuiz_quizUserSummary', 'qus'))
                ->join(
                    'LEFT',
                    $db->quoteName('#__myQuiz_quiz', 'q') . 'ON' . $db->quoteName('qus.quizId') . '=' . $db->quoteName('q.id'))
				->where($db->quoteName('qus.userId') . '=' . $db->quote($userId));
			
		}
		catch (\Exception $e) {
			echo $e->getMessage();
		}
		
		return $query;
    }
        
}