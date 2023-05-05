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

class ButtonCategoriesModel extends ListModel {

    // A list of all categories to populate the button list for the user to filter by category
    public function getListQuery() {

        // Factory::getApplication()->enqueueMessage("imageDisplayModel changeCategory()");

        // Get a db connection.
        $db = $this->getDatabase();  

        // Create a new query object.
        $query = $db->getQuery(true)
                //Query
                ->select($db->quoteName(['ic.id', 'ic.categoryName']))
                ->from($db->quoteName('#__myImageViewer_imageCategory', 'ic'));

        // Check query is correct        
        // echo $query->dump();
        return $query;
    }

    // Override global list limit so all categories are displayed
    protected function populateState($ordering = null, $direction = null){
        $limit = 0;
        $this->setState('list.limit', $limit);
    }
     
}