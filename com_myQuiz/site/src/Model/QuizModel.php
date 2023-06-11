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


class QuizModel extends ItemModel {

    public function getItem($pk = null) {
        $db = $this->getDatabase();

        $quizId = Factory::getApplication()->input->get('quizId');

        $query = $db->getQuery(true)
            ->select(['q.*', 'i.imageUrl'])
            ->from($db->quoteName('#__myQuiz_quiz', 'q'))
            ->join(
                'LEFT',
                $db->quoteName('#__myImageViewer_image', 'i') . 'ON' . $db->quoteName('i.id') . '=' . $db->quoteName('q.imageId'),
            )
            ->where($db->quoteName('q.id') . '=' . $db->quote($quizId));

        $result = $db->setQuery($query)->loadObject();

        return $result;
    }
   
}