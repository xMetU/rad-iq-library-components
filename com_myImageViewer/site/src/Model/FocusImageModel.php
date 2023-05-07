<?php

namespace Kieran\Component\MyImageViewer\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ItemModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 *
 */

class FocusImageModel extends ItemModel {
    // Retrieve the chosen image for focused display.
    public function getItem($pk = null) {
        $id = Factory::getApplication()->input->get('id');

        $item   = new \stdClass();

        $table1  = $this->getTable('Image');
        $table1->load($id);

        $table2 = $this->getTable('ImageCategory');
        $table2->load($table1->categoryId);

        $item->id           =   $table1->id;
        $item->name         =   $table1->imageName;
        $item->category     =   $table2->categoryName;
        $item->description  =   $table1->imageDescription;
        $item->url          =   $table1->imageUrl;

        return $item;
    }
   
}