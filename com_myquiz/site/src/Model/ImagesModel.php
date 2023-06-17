<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */

class ImagesModel extends ListModel {

    public function getListQuery(){
        $db = $this->getDbo();

        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__myImageViewer_image', 'i'));

        return $query;
    }

    // Override global list limit so all images are returned
    protected function populateState($ordering = null, $direction = null){
        $limit = 0;
        $this->setState('list.limit', $limit);
    }

}