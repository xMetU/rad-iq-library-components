<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */

class QuizQuestionsModel extends ListModel {

    
    // Retrieves the question list for a selected quiz.
    public function getListQuery(){

        // Get a db connection.
        $db = $this->getDatabase();

        $id = Factory::getApplication()->getUserState('myQuiz.userQuizId');

        $query = $db->getQuery(true)
                ->select($db->quoteName(['q.id', 'qu.questionNumber']))
                ->from($db->quoteName('#__myQuiz_quiz', 'q'))
                    
                ->join(
                    'LEFT',
                    $db->quoteName('#__myQuiz_question', 'qu') . 'ON' . $db->quoteName('qu.quizId') . '=' . $db->quoteName('q.id'))

                ->where($db->quoteName('q.id') . '=' . $db->quote($id));

        return $query;
    }


    // Override global list limit so all questions are returned
    protected function populateState($ordering = null, $direction = null){
        $limit = 0;
        $this->setState('list.limit', $limit);
    }


        
}