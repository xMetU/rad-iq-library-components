<?php

namespace Kieran\Component\MyImageViewer\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 *
 */

class UploadImageModel extends BaseModel {

	public function getTable($type = 'ImageCategory', $prefix = '', $config = array()) {
		return Factory::getApplication()->bootComponent('com_myImageViewer')->getMVCFactory()->createTable($type);
	}

	public function getCategory($categoryId)  {
        $item = new \stdClass();

        $table = $this->getTable();
        $table->load($categoryId);

        $item->categoryName = $table->categoryName;
        return $item;	
	}

	public function getImages($ids = null) {
		$items = array();
		$table = $this->getTable('Image');
		
		if ($ids) {
			$table->load($ids);
		}
		else {
			$table->load();
		}

		foreach ($table as $image) {
			$item->id = $image->id;
			$item->name = $image->imageName;
			$item->category = getCategory($image->categoryId);
			$item->description = $image->imageDescription;
			$item->url = $image->imageUrl;
		}

		return $items;
    }

	public function saveImage($data) {
		$db = Factory::getDbo();
		$columns = array('imageName', 'categoryId', 'imageUrl', 'imageDescription');
		
		$query = $db->getQuery(true)
			->insert($db->quoteName('#__myImageViewer_image'))
			->columns($db->quoteName($columns))
			->values(implode(',', $db->quote($data)));
		
		$db->setQuery($query);
		$result = $db->execute();
		Factory::getApplication()->enqueueMessage("Image saved successfully.");
	}

	public function deleteImage($imageId) {
		try {
			$db = Factory::getDbo();
			$query = $db->getQuery(true)
				->delete($db->quoteName('#__myImageViewer_image'))
				->where($db->quoteName('id') . '=' . (int) $imageId);
			$db->setQuery($query);
			$db->execute();
			Factory::getApplication()->enqueueMessage("Image deleted successfully.");
			return true;
		}
		catch (Exception $e) {
			Factory::getApplication()->enqueueMessage("Error when deleting image: " . $e->getMessage());
			return false;
		}
	}
        
}