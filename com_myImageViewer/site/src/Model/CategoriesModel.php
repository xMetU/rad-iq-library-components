<?php

namespace Kieran\Component\MyImageViewer\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 */


class CategoriesModel extends ListModel {

    public function getListQuery() {
        $db = $this->getDatabase();

        $query = $db->getQuery(true)
            ->select($db->quoteName(['ic.id', 'ic.categoryName']))
            ->from($db->quoteName('#__myImageViewer_imageCategory', 'ic'))
            ->order('ic.categoryName ASC');

        return $query;
    }

    // Override global list limit so all categories are displayed
    protected function populateState($ordering = null, $direction = null){
        $limit = 0;
        $this->setState('list.limit', $limit);
    }
}