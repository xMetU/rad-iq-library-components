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
        $db = $this->getDatabase();

        $category = Factory::getApplication()->input->getVar('category');
        $search = Factory::getApplication()->input->getVar('search');

        $query = $db->getQuery(true)
            ->select($db->quoteName(['image.imageName', 'image.imageUrl', 'image.id', 'isHidden']))
            ->from($db->quoteName('#__myImageViewer_image', 'image'))
            ->join(
                'LEFT',
                $db->quoteName('#__myImageViewer_imageCategory', 'c') . 'ON' . $db->quoteName('c.id') . '=' . $db->quoteName('image.categoryId')
            );

        if (isset($category)) {
            $query = $query->where($db->quoteName('c.id') . '=' . $category);
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

}