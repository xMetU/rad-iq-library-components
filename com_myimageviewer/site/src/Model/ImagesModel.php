<?php

namespace Kieran\Component\MyImageViewer\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 *
 */

class ImagesModel extends ListModel {

    public function getListQuery() {
        $db = $this->getDbo();

        if (Factory::getApplication()->getUserState('myImageViewer_myQuiz.view') == 'IMAGES') {
            $category = Factory::getApplication()->input->getVar('category');
            $subcategory = Factory::getApplication()->input->getVar('subcategory');
            Factory::getApplication()->setUserState('myImageViewer_myQuiz.category', $category);
            Factory::getApplication()->setUserState('myImageViewer_myQuiz.subcategory', $subcategory);
        } else {
            $category = Factory::getApplication()->getUserState('myImageViewer_myQuiz.category');
            $subcategory = Factory::getApplication()->getUserState('myImageViewer_myQuiz.subcategory');
        }
        $search = Factory::getApplication()->input->getVar('search');

        $query = $db->getQuery(true)
            ->select($db->quoteName(['image.imageName', 'image.imageUrl', 'image.id', 'image.categoryId', 'c.categoryName', 'image.subcategoryId', 'sc.subcategoryName',  'image.isHidden']))
            ->from($db->quoteName('#__myImageViewer_image', 'image'))
            ->join(
                'LEFT',
                $db->quoteName('#__myImageViewer_imageCategory', 'c') . ' ON ' . $db->quoteName('c.categoryId') . '=' . $db->quoteName('image.categoryId')
            )
            ->join(
                'LEFT',
                $db->quoteName('#__myImageViewer_imageSubCategory', 'sc') . ' ON ' . $db->quoteName('sc.categoryId') . '=' . $db->quoteName('image.categoryId')
                . ' AND ' . $db->quoteName('sc.subcategoryId') . '=' . $db->quoteName('image.subcategoryId')
            );

        if (isset($category)) {
            $query = $query->where($db->quoteName('image.categoryId') . ' = ' . $category);
            if (isset($subcategory)) {
                $query = $query->where($db->quoteName('image.subcategoryId') . ' = ' . $subcategory);
            }
        }
        
        if (isset($search)) {
            $query = $query->where($db->quoteName('image.imageName') . ' LIKE ' . $db->quote('%' . $search . '%'));
        }

        return $query;
    }

    // Override global list limit so a reasonable number images are displayed
    protected function populateState($ordering = null, $direction = null) {
        $limit = 12;
        $start = Factory::getApplication()->input->getVar('start');
        $this->setState('list.limit', $limit);
        $this->setState('list.start', $start);
    }

    public function getTable($type = 'Image', $prefix = '', $config = array()) {
		return Factory::getApplication()->bootComponent('com_myImageViewer')->getMVCFactory()->createTable($type);
	}

    
    public function getAllImages() {
        $db = $this->getDbo();

        $query = $db->getQuery(true)
            ->select($db->quoteName(['c.categoryId', 'c.categoryName', 'sc.subcategoryId', 'sc.subcategoryName', 'image.isHidden']))
            ->from($db->quoteName('#__myImageViewer_image', 'image'))
            ->join(
                'LEFT',
                $db->quoteName('#__myImageViewer_imageCategory', 'c') . ' ON ' . $db->quoteName('c.categoryId') . '=' . $db->quoteName('image.categoryId')
            )
            ->join(
                'LEFT',
                $db->quoteName('#__myImageViewer_imageSubCategory', 'sc') . ' ON ' . $db->quoteName('sc.categoryId') . '=' . $db->quoteName('image.categoryId')
                    . ' AND ' . $db->quoteName('sc.subcategoryId') . '=' . $db->quoteName('image.subcategoryId')
            );

        $db->setQuery($query);
        $db->execute();
            
        return $db->loadObjectList();
    }

}