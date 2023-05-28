<?php

namespace Kieran\Component\MyImageViewer\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Image\Image;

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 */

class FormController extends BaseController {
	
	public function saveImage() {
		$model = $this->getModel('ImageForm');
		
		// Get request params
		$data = Factory::getApplication()->input->post->getArray();
		$file = Factory::getApplication()->input->files->get('imageUrl');
		
		// Temporary file path on the server
		$tmp = $file['tmp_name'];

		// Create and append imageUrl
		$name = $data["imageName"] . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
		$categoryName = $model->getCategory($data['categoryId'])->categoryName;
		$imageUrl = 'media/com_myimageviewer/images/' . $categoryName . '/' . $name;
		array_push($data, $imageUrl);

		if ($model->saveImage($data)) {
			// Create the category folder
			$folderUrl = JPATH_ROOT . '/media/com_myimageviewer/images/' . $categoryName;
			$uploadUrl = $folderUrl . '/' . $name;
			Folder::create($folderUrl);

			// Create and save main copy
			$image = new Image($tmp);
			$image->toFile($uploadUrl);

			// Create and save thumbnail copy
			$thumbImage = $image->createThumbs(['200x200']);
			$thumbImage[0]->toFile($uploadUrl . '.thumb');

			// Clear temporary file
			unlink($tmp);
		}

        $this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?task=Display.imageForm',
			false,
		));
    }

	public function updateImage() {
		$model = $this->getModel('ImageForm');

		$data = Factory::getApplication()->input->getArray();

		if ($model->updateImage($data)) {
			$this->setRedirect(Route::_(
				Uri::getInstance()->current() . '?task=Display.imageDetails&id=' . $data['imageId'],
				false,
			));
		} else {
			$this->setRedirect(Route::_(
				Uri::getInstance()->current() . '?task=Display.imageForm&id=' . $data['imageId'],
				false,
			));
		}
	}

	public function deleteImage() {
		$model = $this->getModel('ImageDetails');

		$data = Factory::getApplication()->input->getArray();
		
		// Delete files if db delete is successful
		if ($model->deleteImage($data['imageId'])) {
			if (File::exists($data['imageUrl'])) {
				File::delete($data['imageUrl']);
			}
			if (File::exists($data['imageUrl']) . '.thumb') {
				File::delete($data['imageUrl'] . '.thumb');
			}
			// Delete parent folder if empty
			$folderUrl = pathinfo($data['imageUrl'], PATHINFO_DIRNAME);
			if (count(Folder::files($folderUrl)) + count(Folder::folders($folderUrl)) == 0) {
				Folder::delete($folderUrl);
			}
		}

		$this->setRedirect(Route::_(
			Uri::getInstance()->current(),
			false,
		));
	}

    public function saveCategory() {
		$model = $this->getModel('CategoryForm');
		
		$categoryName = Factory::getApplication()->input->getVar('categoryName');

		$model->saveCategory($categoryName);

		$this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?task=Display.categoryForm',
			false,
		));
    }

	public function deleteCategory() {
		$model = $this->getModel('CategoryForm');
		
		$categoryId = Factory::getApplication()->input->getVar('categoryId');

		$model->deleteCategory($categoryId);

		$this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?task=Display.categoryForm',
			false,
		));
	}

	public function toggleIsHidden() {
		$model = $this->getModel('ImageDetails');

		$imageId = Factory::getApplication()->input->getVar('id');

		$model->toggleIsHidden($imageId);

		$this->setRedirect(Route::_(
			Uri::getInstance()->current(),
			false,
		));
	}

}