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

		// Perform filtering
		$imageName = Factory::getApplication()->input->post->getVar("imageName");
		$imageDescription = Factory::getApplication()->input->post->getVar("imageDescription");
		$categoryId = Factory::getApplication()->input->post->getInt("categoryId");
		$subcategoryId = Factory::getApplication()->input->post->getInt("subcategoryId");

		$data = ['imageName' => $imageName, 'imageDescription' => $imageDescription,
			'categoryId' => $categoryId, 'subcategoryId' => $subcategoryId];
		Factory::getApplication()->setUserState('myImageViewer.imageForm', $data);

		if (!isset($subcategoryId)) {
			$subcategoryId = 0;
		}

		// Perform server-side validation
		if ($this->validateImageData($imageName, $imageDescription, $categoryId)){
			$file = Factory::getApplication()->input->files->get('imageUrl');
			// Temporary file path on the server
			$tmp = $file['tmp_name'];

			// Create and append imageUrl
			$name = $imageName . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
			$categoryName = $model->getCategory($categoryId)->categoryName;
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

				// Clear temporary file and user state
				unlink($tmp);
				Factory::getApplication()->setUserState('myImageViewer.imageForm', null);

				$this->setRedirect(Route::_(
					Uri::getInstance()->current() . '?task=Display.saveImageForm&categoryId=' . $categoryId,
					false,
				));
				return;
			}
		}
        $this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?task=Display.saveImageForm&categoryId=' . $categoryId,
			false,
		));
    }

	public function updateImage() {
		$model = $this->getModel('ImageForm');

		$imageId = Factory::getApplication()->input->post->getInt('imageId');
		$imageName = Factory::getApplication()->input->post->getVar('imageName');
		$categoryId = Factory::getApplication()->input->post->getInt('categoryId');
		$subcategoryId = Factory::getApplication()->input->post->getInt('subcategoryId');
		$imageDescription = Factory::getApplication()->input->post->getVar('imageDescription');

		$data = ['imageId' => $imageId, 'imageName' => $imageName, 'categoryId' => $categoryId,
			'subcategoryId' => $subcategoryId, 'imageDescription' => $imageDescription];
		Factory::getApplication()->setUserState('myImageViewer.imageForm', $data);

		// If no subcategory, set subcategoryId to 0 instead of null
		if (!isset($subcategoryId)) {
			$subcategoryId = 0;
		}

		if ($this->validateImageData($imageName, $imageDescription, $categoryId)) {
			if ($model->updateImage($data)) {
				Factory::getApplication()->setUserState('myImageViewer.imageForm', null);
				$this->setRedirect(Route::_(
					Uri::getInstance()->current() . '?task=Display.imageDetails&id=' . $imageId,
					false,
				));
				return;
			}
		}
		$this->setRedirect(Route::_(
			Uri::getInstance()->current() 
			. '?task=Display.editImageForm&id=' . $imageId
			. '&categoryId=' . $categoryId,
			false,
		));
	}

	public function deleteImage() {
		$model = $this->getModel('ImageDetails');

		$imageId = Factory::getApplication()->input->post->getInt('imageId');
		$imageUrl = Factory::getApplication()->input->post->getVar('imageUrl');
		
		// Delete files if db delete is successful
		if ($model->deleteImage($imageId)) {
			if (File::exists($imageUrl)) {
				File::delete($imageUrl);
			}
			if (File::exists($imageUrl) . '.thumb') {
				File::delete($imageUrl . '.thumb');
			}
			// Delete parent folder if empty
			$folderUrl = pathinfo($imageUrl, PATHINFO_DIRNAME);
			if (count(Folder::files($folderUrl)) + count(Folder::folders($folderUrl)) == 0) {
				Folder::delete($folderUrl);
			}
		}
		$this->setRedirect(Route::_(Uri::getInstance()->current(), false));
	}

    public function saveCategory() {
		$model = $this->getModel('CategoryForm');
		$categoryName = Factory::getApplication()->input->getVar('categoryName');
		$model->saveCategory($categoryName);
		$this->navigateToCategoryForm();
    }

	public function deleteCategory() {
		$model = $this->getModel('CategoryForm');
		$categoryId = Factory::getApplication()->input->getInt('categoryId');
		$model->deleteCategory($categoryId);
		$this->navigateToCategoryForm();
	}

	public function saveSubcategory() {
		$model = $this->getModel('CategoryForm');
		$categoryId = Factory::getApplication()->input->getInt('categoryId');
		$subcategoryName = Factory::getApplication()->input->getVar('subcategoryName');
		$model->saveSubcategory($categoryId, $subcategoryName);
		$this->navigateToCategoryForm();
    }

	public function deleteSubcategory() {
		$model = $this->getModel('CategoryForm');
		$categoryId = Factory::getApplication()->input->getInt('categoryId');
		$subcategoryId = Factory::getApplication()->input->getInt('subcategoryId');
		if (empty($subcategoryId) || $subcategoryId == 0) {
			Factory::getApplication()->enqueueMessage("Error: Please choose a parent category with a subcategory.");			
		} else {
			$model->deleteSubcategory($categoryId, $subcategoryId);
		}
		$this->navigateToCategoryForm();
	}

	public function toggleIsHidden() {
		$model = $this->getModel('ImageDetails');
		$imageId = Factory::getApplication()->input->getInt('id');
		$model->toggleIsHidden($imageId);
		$this->setRedirect(Route::_(
			Uri::getInstance()->current(),
			false,
		));
	}

	private function navigateToCategoryForm() {
		$this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?task=Display.categoryForm',
			false,
		));
	}

	private function validateImageData($imageName, $imageDescription, $categoryId) {
		if (strlen($imageName) > 60) {
            Factory::getApplication()->enqueueMessage("Name must be less than 60 characters.");
            return false;
        }
        if (empty($categoryId)) {
            Factory::getApplication()->enqueueMessage("Please select a category for this image.");
            return false;
        }  
        if (strlen($imageDescription) > 12000) {
            Factory::getApplication()->enqueueMessage("Description must be less than 12000 characters.");
            return false;
        }
        return true;
    }

}