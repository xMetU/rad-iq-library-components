<?php

namespace Kieran\Component\MyImageViewer\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 */


class CategoryFormModel extends BaseModel {

	public function getTable($type = 'ImageCategory', $prefix = '', $config = array()) {
		return Factory::getApplication()->bootComponent('com_myImageViewer')->getMVCFactory()->createTable($type);
	}

    /**
	 * Method to get the record form.
	 *
	 * @param array    $data      Data for the form.
	 * @param boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed    A Form object on success, false on failure
	 */
	public function saveCategory($categoryName) {
		$db = Factory::getDbo();
		$query = $db->getQuery(true)
			->insert($db->quoteName('#__myImageViewer_imageCategory'))
			->columns($db->quoteName(['categoryName']))
			->values($db->quote($categoryName));
		$db->setQuery($query);

		try {
			$db->execute();
			Factory::getApplication()->enqueueMessage("Category saved successfully.");
			return true;
		} catch (\Exception $e) {
			if (str_contains($e->getMessage(), "Duplicate")) {
				Factory::getApplication()->enqueueMessage("Error: A category with this name already exists.");
			} else {
				Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred, please contact your administrator.");
			}
			return false;
		}
	}

	public function deleteCategory($categoryId) {
		$db = Factory::getDbo();
		$query = $db->getQuery(true)
			->delete($db->quoteName('#__myImageViewer_imageCategory'))
			->where($db->quoteName('categoryId') . '=' . $categoryId);
		$db->setQuery($query);
			
		try {
			$db->execute();
			Factory::getApplication()->enqueueMessage("Category removed successfully.");
			return true;
		}
		catch (\Exception $e) {
			if (str_contains($e->getMessage(), "foreign key")) {
				Factory::getApplication()->enqueueMessage(
					"Error: Images or subcategories are assigned to this category, please re-assign or remove them and try again."
				);
			} else {
				Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred, please contact your administrator.");
			}
			return false;
		}
	}

	public function saveSubcategory($categoryId, $subcategoryName) {
		$db = Factory::getDbo();
		$data = array($categoryId, $subcategoryName);

		$query = $db->getQuery(true)
			->insert($db->quoteName('#__myImageViewer_imageSubCategory'))
			->columns($db->quoteName(['categoryId', 'subcategoryName']))
			->values(implode(',', $db->quote($data)));
		$db->setQuery($query);

		try {
			$db->execute();
			Factory::getApplication()->enqueueMessage("Subcategory saved successfully.");
			return true;
		} catch (\Exception $e) {
			if (str_contains($e->getMessage(), "Duplicate")) {
				Factory::getApplication()->enqueueMessage("Error: A subcategory with this name already exists.");
			} else {
				Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred, please contact your administrator.");
			}
			return false;
		}
	}

	public function deleteSubcategory($categoryId, $subcategoryId) {
		$db = Factory::getDbo();
		$query = $db->getQuery(true)
			->delete($db->quoteName('#__myImageViewer_imageSubCategory'))
			->where($db->quoteName('categoryId') . '=' . $categoryId . ' AND ' . $db->quoteName('subcategoryId') . '=' . $subcategoryId);
		$db->setQuery($query);
			
		try {
			$db->execute();
			if (Factory::getApplication()->getUserState('myImageViewer_myQuiz.category') == $categoryId) {
				Factory::getApplication()->setUserState('myImageViewer_myQuiz.category', null);
			}
			Factory::getApplication()->enqueueMessage("Category removed successfully.");
			return true;
		}
		catch (\Exception $e) {
			if (str_contains($e->getMessage(), "foreign key")) {
				Factory::getApplication()->enqueueMessage(
					"Error: Images are assigned to this category, please re-assign or remove it and try again."
				);
			} else {
				Factory::getApplication()->enqueueMessage("Error: An unknown error has occurred, please contact your administrator.");
			}
			return false;
		}
	}

}