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

class UploadImageModel extends ListModel {

    public function getImageList(){

        // Get a db connection.
        $db = $this->getDatabase();
        $query = $db->getQuery(true)       
            //Query
            ->select('image.imageCategory')
            ->from($db->quoteName('#__myImageViewer_image', 'image'))
            ->where($db->quoteName('image.imageCategory') . '=' . $db->quoteName('image'));
            // ->where($db->quoteName('image.imageCategory') . '= :category')
            // ->bind(':category', $category);

        // Check query is correct        
        echo $query;

    }


    public function getCategories(){

        // Get a db connection.
        $db = $this->getDatabase();

        // Create a new query object.
        $query = $db->getQuery(true)
                //Query
                ->select('image.imageCategory')
                ->from($db->quoteName('#__myImageViewer_image', 'image'));

        // Check query is correct        
        echo $query;

        return $query;
    }

        
}