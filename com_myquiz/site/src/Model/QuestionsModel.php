<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */

class QuestionsModel extends ListModel {
    // Override global list limit so all questions are returned
    protected function populateState($ordering = null, $direction = null){
        $limit = 0;
        $this->setState('list.limit', $limit);
    }

    public function getListQuery() {
        $db = $this->getDbo();

        $id = Factory::getApplication()->input->get('quizId');

        $query = $db->getQuery(true)
            ->select([
                $db->quoteName('q.id'), $db->quoteName('q.description'), $db->quoteName('q.feedback'),
                'COUNT(a.id) AS ' . $db->quoteName('answerCount')
            ])
            ->group($db->quoteName(['q.id', 'q.description', 'q.feedback']))
            ->from($db->quoteName('#__myQuiz_question', 'q'))
            ->join(
                'LEFT', 
                $db->quoteName('#__myQuiz_answer', 'a') . 'ON' . $db->quoteName('a.questionId') . '=' . $db->quoteName('q.id'),
            )
            ->where($db->quoteName('q.quizId') . '=' . $db->quote($id));
            
        return $query;
    }

}