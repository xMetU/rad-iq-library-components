<?php

namespace Kieran\Component\MyImageViewer\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 */


class SubCategoriesModel extends ListModel {

    public function getListQuery() {
        $db = $this->getDbo();
        $query = $db->getQuery(true)
            ->select($db->quoteName(['isc.categoryId', 'isc.subcategoryId', 'isc.subcategoryName']))
            ->from($db->quoteName('#__myImageViewer_imageSubCategory', 'isc'));
        return $query;
    }

    // Override global list limit so all categories are displayed
    protected function populateState($ordering = null, $direction = null){
        $limit = 0;
        $this->setState('list.limit', $limit);
    }

    public function getCategorySubcategories() {
        $db = $this->getDbo();

        $categoryId = Factory::getApplication()->input->getInt('categoryId');
        if (!$categoryId) {
            $categoryId = Factory::getApplication()->getUserState('myImageViewer.categoryId');
        }

        $query = $db->getQuery(true)
            ->select($db->quoteName(['isc.categoryId', 'isc.subcategoryId', 'isc.subcategoryName']))
            ->from($db->quoteName('#__myImageViewer_imageSubCategory', 'isc'));

        if($categoryId) {
            $query = $query->where($db->quoteName('isc.categoryId') . '=' . $categoryId); 
        }

        $db->setQuery($query);
        $db->execute();

        return $db->loadObjectList();
    }
}