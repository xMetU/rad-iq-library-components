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

class ImageDisplayModel extends ListModel {




    // Get a general list of images to display on home page
    public function getListQuery(){
        
        // Factory::getApplication()->enqueueMessage("imageDisplayModel getListQuery()");


        // Get a db connection.
        $db = $this->getDatabase();

        // Create a new query object.
        $query = $db->getQuery(true)
                //Query
                ->select($db->quoteName(['image.imageName', 'image.imageUrl', 'c.categoryName', 'image.id']))
                ->from($db->quoteName('#__myImageViewer_image', 'image'))
                ->join(
                    'LEFT',
                    $db->quoteName('#__myImageViewer_imageCategory', 'c') . 'ON' . $db->quoteName('c.id') . '=' . $db->quoteName('image.id'));

        // Check query is correct        
        // echo $query->dump();

        return $query;
    }

        
}