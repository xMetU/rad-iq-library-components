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

class ImageFormModel extends BaseModel {

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


	public function getSubCategory($subcategoryId)  {
        $item = new \stdClass();

        $table = $this->getTable();
        $table->load($subcategoryId);

        $item->subcategoryName = $table->subcategoryName;
        return $item;
	}


	public function saveImage($data) {

		$db = Factory::getDbo();
		$columns = array('imageName', 'imageDescription', 'categoryId', 'subcategoryId', 'imageUrl');

		$query = $db->getQuery(true)
			->insert($db->quoteName('#__myImageViewer_image'))
			->columns($db->quoteName($columns))
			->values(implode(',', $db->quote($data)));
		$db->setQuery($query);

		try {
			$result = $db->execute();
			Factory::getApplication()->enqueueMessage("Image saved successfully.");
			return true;
		} catch (\Exception $e) {
			if (str_contains($e->getMessage(), "Duplicate")) {
				Factory::getApplication()->enqueueMessage("Error: An image already exists with that name and category.");
			} else {
				Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred. Please contact your administrator.");
			}
			return false;
		}
	}

	public function updateImage($data) {
		$db = Factory::getDbo();
		$columns = array('imageName', 'categoryId', 'imageDescription');
		
		$query = $db->getQuery(true)
			->update($db->quoteName('#__myImageViewer_image'))
			->set($db->quoteName('imageName') . ' = ' . $db->quote($data['imageName']))
			->set($db->quoteName('categoryId') . ' = ' . $db->quote($data['categoryId']))
			->set($db->quoteName('imageDescription') . ' = ' . $db->quote($data['imageDescription']))
			->where($db->quoteName('id') . ' = ' . $db->quote($data['imageId']));
		$db->setQuery($query);
		
		try {
			$result = $db->execute();
			Factory::getApplication()->enqueueMessage("Image updated successfully.");
			return true;
		} catch (\Exception $e) {
			if (str_contains($e->getMessage(), "Duplicate")) {
				Factory::getApplication()->enqueueMessage("Error: An image already exists with that name and category.");
			} else {
				Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred. Please contact your administrator.");
			}
			return false;
		}
	}
}