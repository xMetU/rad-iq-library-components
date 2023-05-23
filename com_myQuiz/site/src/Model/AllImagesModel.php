<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 */

class AllImagesModel extends ListModel {

    
    // Get a list of images
    public function getListQuery(){

        // Get a db connection.
        $db = $this->getDatabase();

        $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__myImageViewer_image', 'i'));

        return $query;
    }


        
}