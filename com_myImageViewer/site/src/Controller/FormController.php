<?php

namespace Kieran\Component\MyImageViewer\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filesystem\File;

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 *
 */

class FormController extends BaseController {
    public function saveImage() {
		$model = $this->getModel('ImageForm');
		
		$data = $_POST;
		$file = Factory::getApplication()->input->files->get('imageUrl');		
		
		$name = $file['name'];
		$tmp = $file['tmp_name'];
		$categoryName = $model->getCategory($data['categoryId'])->categoryName;

		$path = JPATH_ROOT . '/media/com_myImageViewer/images/';
		$folderUrl = $path . $categoryName;
		$uploadUrl = $path . $categoryName . '/' . $name;
		$imageUrl = 'media/com_myImageViewer/images/' . $categoryName . '/' . $name;

		Folder::create($folderUrl);
		File::upload($tmp, $uploadUrl);

		array_push($data, $imageUrl);

		$model->saveImage($data);
        $this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?task=Display.imageForm',
			false,
		));
    }

	public function updateImage() {
		$model = $this->getModel('ImageForm');

		$data = $_POST;

		$model->updateImage($data);
		
		$this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?task=Display.imageForm',
			false,
		));
	}

	public function deleteImage() {
		$model = $this->getModel('ImageDetails');
		
		$data = $_POST;
		$imageUrl = $data['imageUrl'];
		$imageId = $data['imageId'];
		// Error messages handled by ImageFormModel.deleteImage
		if ($model->deleteImage($imageId)) {
			if (File::exists($imageUrl)) {
				File::delete($imageUrl);
			}
		}

		$this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?task=Display',
			false,
		));
	}

    public function saveCategory() {
		$model = $this->getModel('CategoryForm');

		$data = $_POST;

		$model->saveCategory($data);

		$this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?task=Display.categoryForm',
			false,
		));
    }

	public function deleteCategory() {
		$model = $this->getModel('CategoryForm');
		
		$data = $_POST;
		$categoryId = $data['categoryId'];

		$model->deleteCategory($categoryId);

		$this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?task=Display.categoryForm',
			false,
		));
	}

}