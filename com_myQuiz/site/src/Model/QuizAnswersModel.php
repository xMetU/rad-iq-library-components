<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */

class QuizAnswersModel extends ListModel {

    
    // Retrieves the list of answers for a quiz question
    public function getListQuery() {

        // Get a db connection.
        $db = $this->getDatabase();

        $id = Factory::getApplication()->getUserState('myQuiz.userQuizId');
        $question = Factory::getApplication()->input->get('question');

        
        $query = $db->getQuery(true)
                ->select($db->quoteName(['qu.quizId', 'q.title', 'qu.questionNumber', 'qu.questionDescription', 'q.imageId', 'i.imageUrl', 
                                        'a.answerNumber', 'a.answerDescription']))
                ->from($db->quoteName('#__myQuiz_quiz', 'q'))

                ->join(
                    'LEFT',
                    $db->quoteName('#__myImageViewer_image', 'i') . 'ON' . $db->quoteName('i.id') . '=' . $db->quoteName('q.imageId'))

                ->join('LEFT',
                    $db->quoteName('#__myQuiz_question', 'qu') . 'ON' .
                    $db->quoteName('qu.quizId') . '=' . $db->quoteName('q.id'))

                ->join('LEFT',
                    $db->quoteName('#__myQuiz_answer', 'a') . 'ON' .
                    $db->quoteName('a.quizId') . '=' . $db->quoteName('qu.quizId'). 'AND' .
                    $db->quoteName('a.questionNumber') . '=' . $db->quoteName('qu.questionNumber'))
                
                ->where($db->quoteName('q.id') . '=' . $db->quote($id) . 'AND' . $db->quoteName('qu.questionNumber') . '=' . $db->quote($question));

        return $query;
    }


        
}