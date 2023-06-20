<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ItemModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */

class QuestionModel extends ItemModel {

    public function getItem($pk = null) {
        $db = $this->getDbo();

        $questionId = Factory::getApplication()->input->get('questionId');

        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__myQuiz_question', 'q'))
            ->where($db->quoteName('q.id') . '=' . $db->quote($questionId));

        $result = $db->setQuery($query)->loadObject();

        return $result;
    }
}