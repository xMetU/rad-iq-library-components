<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */


class SubCategoriesModel extends ListModel {

    public function getListQuery() {

        $db = $this->getDatabase();

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
        $db = $this->getDatabase();

        $categoryId = Factory::getApplication()->input->get('categoryId');

        $query = $db->getQuery(true)
            ->select($db->quoteName(['isc.categoryId', 'isc.subcategoryId', 'isc.subcategoryName']))
            ->from($db->quoteName('#__myImageViewer_imageSubCategory', 'isc'));

        if($categoryId) {
            $query = $query->where($db->quoteName('isc.categoryId') . '=' . $categoryId); 
        }

        $db->setQuery($query);
        $db->execute();
        $db->loadObjectList();

        return $db->loadObjectList();
    }
}