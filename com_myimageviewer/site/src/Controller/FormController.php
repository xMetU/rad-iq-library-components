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

		$resume = false;

		if (!isset($subcategoryId)) {
			if ($model->checkSubcategory($categoryId)) {
				$subcategoryId = 0;
				$resume = true;
			}
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

			//Prepare data
			$data = ['imageName' => $imageName, 'imageDescription' => $imageDescription, 'categoryId' => $categoryId, 'subcategoryId' => $subcategoryId];
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
		}
		

        $this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?task=Display.saveImageForm',
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

		
		if (!isset($subcategoryId)) {
			if ($model->checkSubcategory($categoryId)) {
				$subcategoryId = 0;
				$resume = true;
			}
		}

		$data = array('imageId' => $imageId, 'imageName' => $imageName, 'categoryId' => $categoryId, 
		'subcategoryId' => $subcategoryId, 'imageDescription' => $imageDescription);

		if ($model->updateImage($data)) {
			$this->setRedirect(Route::_(
				Uri::getInstance()->current() . '?task=Display.imageDetails&id=' . $data['imageId'],
				false,
			));
		} else {
			$this->setRedirect(Route::_(
				Uri::getInstance()->current() . '?task=Display.editImageForm&id=' . $data['imageId'],
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
		
		$categoryId = Factory::getApplication()->input->getInt('categoryId');

		$model->deleteCategory($categoryId);

		$this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?task=Display.categoryForm',
			false,
		));
	}


	public function saveSubcategory() {
		$model = $this->getModel('CategoryForm');
		
		$categoryId = Factory::getApplication()->input->getInt('categoryId');
		$subcategoryName = Factory::getApplication()->input->getVar('subcategoryName');

		$model->saveSubcategory($categoryId, $subcategoryName);

		$this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?task=Display.categoryForm',
			false,
		));
    }


	public function deleteSubcategory() {
		$model = $this->getModel('CategoryForm');
		
		$categoryId = Factory::getApplication()->input->getInt('categoryId');
		$subcategoryId = Factory::getApplication()->input->getInt('subcategoryId');

		if(empty($subcategoryId) || $subcategoryId == 0) {
			Factory::getApplication()->enqueueMessage("Error: No subcategory to remove. Please choose a parent category with a subcategory");			
		}
		else{
			$model->deleteSubcategory($categoryId, $subcategoryId);
		}

		$this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?task=Display.categoryForm',
			false,
		));
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


	private function validateImageData($imageName, $imageDescription, $categoryId) {

		if(strlen($imageName) > 60) {
            Factory::getApplication()->enqueueMessage("Image name too long.");
            return false;
        }

        if(empty($categoryId)) {
            Factory::getApplication()->enqueueMessage("Please select a category for this image.");
            return false;
        }
        
        if(strlen($imageDescription) > 12000) {
            Factory::getApplication()->enqueueMessage("You have reached the description limit");
            return false;
        }
        return true;
    }

}