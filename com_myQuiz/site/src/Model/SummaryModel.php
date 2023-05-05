<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 *
 */

class SummaryModel extends ListModel {

    
    // Get a list of images filtered by category
    public function getListQuery(){

        // Get a db connection.
        $db = $this->getDatabase();

        $userId = Factory::getUser()->id;
        $quizId = Factory::getApplication()->input->get('id');

        // Create a new query object.
        $query = $db->getQuery(true)
                //Query
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
                ->where($db->quoteName('ua.userId') . '=' . $db->quote($userId) . 'AND' . $db->quoteName('ua.quizId') . '=' . $db->quote($quizId));

        // Check query is correct        
        // echo $query->dump();

        return $query;
    }


        
}