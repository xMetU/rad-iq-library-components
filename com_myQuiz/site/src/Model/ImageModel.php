<?php

namespace Kieran\Component\MyQuiz\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;

/**
 * @package     Joomla.Site
 * @subpackage  com_myQuiz
 *
 */

class ImageModel extends ListModel {

    
    // Get a list of images filtered by category
    public function getListQuery(){

        // Get a db connection.
        $db = $this->getDatabase();
        
        $id = Factory::getApplication()->input->get('id');

        // Create a new query object.
        $query = $db->getQuery(true)
                //Query
            ->select('*')
            ->from($db->quoteName('#__myQuiz_quiz', 'q'))
            ->join(
                'LEFT',
                $db->quoteName('#__myImageViewer_image', 'i') . 'ON' . $db->quoteName('i.id') . '=' . $db->quoteName('q.imageId'))
            ->where($db->quoteName('q.id') . '=' . $db->quote($id));

        // Check query is correct        
        // echo $query->dump();

        return $query;
    }


        
}