<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */

class AnswersModel extends ListModel {
    // Override global list limit so all answers are returned
    protected function populateState($ordering = null, $direction = null){
        $limit = 0;
        $this->setState('list.limit', $limit);
    }

    public function getListQuery() {
        $db = $this->getDatabase();

        $questionId = Factory::getApplication()->input->get('questionId');

        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__myQuiz_answer', 'a'))
            ->where($db->quoteName('a.questionId') . '=' . $db->quote($questionId));

        return $query;
    }

}