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
        $db = $this->getDatabase();

        $id = Factory::getApplication()->input->get('quizId');

        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__myQuiz_question', 'q'))
            ->where($db->quoteName('q.quizId') . '=' . $db->quote($id));

        return $query;
    }

}