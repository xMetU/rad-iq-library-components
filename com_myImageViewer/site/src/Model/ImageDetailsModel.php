<?php

namespace Kieran\Component\MyImageViewer\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\ItemModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 */


class ImageDetailsModel extends ItemModel {
    // Retrieve the chosen image for focused display.
    public function getItem($pk = null) {
        $id = Factory::getApplication()->input->get('id');

        $item = new \stdClass();

        $table1 = $this->getTable('Image');
        $table1->load($id);

        $table2 = $this->getTable('ImageCategory');
        $table2->load($table1->categoryId);

        $item->id = $table1->id;
        $item->name = $table1->imageName;
        $item->categoryId = $table1->categoryId;
        $item->category = $table2->categoryName;
        $item->description = $table1->imageDescription;
        $item->url = $table1->imageUrl;
        $item->isHidden = $table1->isHidden;

        return $item;
    }

    public function deleteImage($imageId) {
        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->delete($db->quoteName('#__myImageViewer_image'))
            ->where($db->quoteName('id') . '=' . (int) $imageId);
        $db->setQuery($query);

        try {
			$db->execute();
			Factory::getApplication()->enqueueMessage("Image removed successfully.");
			return true;
		}
		catch (\Exception $e) {
            if (str_contains($e-getMessage(), "foreign key constraint")) {
                Factory::getApplication()->enqueueMessage(
                    "Error: Quizzes are referencing this image, please re-assign or remove these quizzes and try again."
                );
            } else {
                Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred, please contact your administrator.");
            }
			return false;
		}
	}

    public function toggleIsHidden($imageId) {
        $db = $this->getDatabase();
        
        $query = $db->getQuery(true)
            ->update($db->quoteName('#__myImageViewer_image'))
            ->set($db->quoteName('isHidden') . ' = NOT ' . $db->quoteName('isHidden'))
            ->where($db->quoteName('id') . ' = ' . $db->quote($imageId));
        
        $db->setQuery($query);
		
		try {
			$result = $db->execute();		
			return true;
		} catch (\Exception $e) {
			Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred. Please contact your administrator.");
			return false;
		}
    }
   
}