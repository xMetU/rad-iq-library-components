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

class QuestionAnswersModel extends ListModel {

    
    // Get a list of images filtered by category
    public function getListQuery() {

        // Get a db connection.
        $db = $this->getDatabase();

        $id = Factory::getApplication()->input->get('id');
        $question = Factory::getApplication()->input->get('question');

        // Create a new query object.
        $query = $db->getQuery(true)
                //Query
                ->select('*')
                ->from($db->quoteName('#__myQuiz_quiz', 'q'))

                ->join('LEFT',
                    $db->quoteName('#__myQuiz_question', 'qu') . 'ON' .
                    $db->quoteName('qu.quizId') . '=' . $db->quoteName('q.id'))

                ->join('LEFT',
                    $db->quoteName('#__myQuiz_answer', 'a') . 'ON' .
                    $db->quoteName('a.quizId') . '=' . $db->quoteName('qu.quizId'). 'AND' .
                    $db->quoteName('a.questionNumber') . '=' . $db->quoteName('qu.questionNumber'))
                ->where($db->quoteName('q.id') . '=' . $db->quote($id) . 'AND' . $db->quoteName('qu.questionNumber') . '=' . $db->quote($question));

        // Check query is correct        
        // echo $query->dump();

        return $query;
    }


        
}