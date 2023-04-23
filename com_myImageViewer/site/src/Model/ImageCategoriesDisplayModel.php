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

class ImageCategoriesDisplayModel extends ListModel {

    
    // Get a list of images filtered by category
    public function getListQuery(){

        // Factory::getApplication()->enqueueMessage("imageDisplayModel changeCategory()");

        // Get a db connection.
        $db = $this->getDatabase();

        $imageCategory = Factory::getApplication()->input->get('imageCategory');       

        // Create a new query object.
        $query = $db->getQuery(true)
                //Query
                ->select($db->quoteName(['image.imageName', 'image.imageUrl', 'c.categoryName', 'image.id']))
                ->from($db->quoteName('#__myImageViewer_image', 'image'))
                ->join(
                    'LEFT',
                    $db->quoteName('#__myImageViewer_imageCategory', 'c') . 'ON' . $db->quoteName('c.id') . '=' . $db->quoteName('image.id'))
                ->where($db->quoteName('c.categoryName') . '=' . $db->quote($imageCategory));


        // Check query is correct        
        // echo $query->dump();

        return $query;
    }


        
}