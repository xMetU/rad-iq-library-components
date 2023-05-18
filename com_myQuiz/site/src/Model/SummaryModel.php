<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */


class SummaryModel extends ListModel {

    
    // Retrieve the list of final answers for a quiz.
    public function getListQuery(){

        $db = $this->getDatabase();

        $userId = Factory::getUser()->id;
        $quizId = Factory::getApplication()->input->get('quizId');
        $attemptNumber = Factory::getApplication()->getUserState('myQuiz.userAttemptNumber');

        try{
            $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__myQuiz_userAnswers', 'ua'))
                ->join(
                    'LEFT',
                    $db->quoteName('#__myQuiz_question', 'q') . 'ON' . $db->quoteName('q.quizId') . '=' . $db->quoteName('ua.quizId')
                        . 'AND' . $db->quoteName('q.questionNumber') . '=' . $db->quoteName('ua.questionNumber'))
                ->join(
                    'LEFT',
                    $db->quoteName('#__myQuiz_answer', 'a') . 'ON' . $db->quoteName('a.quizId') . '=' . $db->quoteName('ua.quizId')
                        . 'AND' . $db->quoteName('a.questionNumber') . '=' . $db->quoteName('ua.questionNumber')
                        . 'AND' . $db->quoteName('a.answerNumber') . '=' . $db->quoteName('ua.answerNumber'))
                ->where($db->quoteName('ua.userId') . '=' . $db->quote($userId))
                ->where($db->quoteName('ua.quizId') . '=' . $db->quote($quizId))
                ->where($db->quoteName('ua.attemptNumber') . '=' . $db->quote($attemptNumber));
        }
        catch (\Exception $e) {
			echo $e->getMessage();
		}       

        return $query;
    }
        
}