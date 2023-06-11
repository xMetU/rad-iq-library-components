<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */


class ScoresModel extends ListModel {
    // Retrieve the list of quiz scores for a user.
    public function getListQuery() {

        $db = $this->getDatabase();
        $userId = Factory::getUser()->id;

        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__myQuiz_quizUserSummary', 'qus'))
            ->join(
                'LEFT',
                $db->quoteName('#__myQuiz_quiz', 'q') . 'ON' . $db->quoteName('qus.quizId') . '=' . $db->quoteName('q.id')
            )
            ->where($db->quoteName('qus.userId') . '=' . $db->quote($userId));

		return $query;
    }

    // Override global list limit so a reasonable number of scores are returned
    protected function populateState($ordering = null, $direction = null) {
        $limit = 12;
        $start = Factory::getApplication()->input->getVar('start');
        $this->setState('list.limit', $limit);
        $this->setState('list.start', $start);
    }
        
}