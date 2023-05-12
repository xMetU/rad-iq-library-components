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
		$model = $this->getModel('UploadImage');
		
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

		array_splice($data, 2, 0, $imageUrl);

		$model->saveImage($data);
        $this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?&task=Display.uploadForm',
			false,
		));
    }

	public function deleteImage() {
		$model = $this->getModel('FocusImage');
		
		$data = $_POST;
		$imageUrl = $data['imageUrl'];
		$imageId = $data['imageId'];
		// Error messages handled by UploadImageModel.deleteImage
		if ($model->deleteImage($imageId)) {
			if (File::exists($imageUrl)) {
				File::delete($imageUrl);
			}
		}

		$this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?&task=Display',
			false,
		));
	}

    public function saveCategory() {
		$model = $this->getModel('AddNewCategory');

		$data = $_POST;

		$model->saveCategory($data);

		$this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?&task=Display.addNewCategory',
			false,
		));
    }

	public function deleteCategory() {
		$model = $this->getModel('AddNewCategory');
		
		$data = $_POST;
		$categoryId = $data['categoryId'];

		$model->deleteCategory($categoryId);

		$this->setRedirect(Route::_(
			Uri::getInstance()->current() . '?&task=Display.addNewCategory',
			false,
		));
	}

    public function submit($key = null, $urlVar = null) {
		$this->checkToken();

		$app = Factory::getApplication();
		$model = $this->getModel('Form');
		$form = $model->getForm($data, false);

		if (!$form) {
			$app->enqueueMessage($model->getError(), 'error');
			return false;
		}
		// name of array 'form' must match 'control' => 'form' line in the model code
		$data  = $this->input->post->get('Form', array(), 'array');
		// This is validate() from the FormModel class, not the Form class
		// FormModel::validate() calls both Form::filter() and Form::validate() methods
		$validData = $model->validate($form, $data);
		if ($validData === false) {
			$errors = $model->getErrors();
			foreach ($errors as $error) {
				if ($error instanceof \Exception) {
					$app->enqueueMessage($error->getMessage(), 'warning');
				}
				else {
					$app->enqueueMessage($error, 'warning');
				}
			}

			// Save the form data in the session, using a unique identifier
			$app->setUserState('com_sample_form2.sample', $data);
		}
		else {
			$app->enqueueMessage("Data successfully validated", 'notice');
			// Clear the form data in the session
			$app->setUserState('com_sample_form2.sample', null);
		}
		// Redirect back to the form in all cases
		$this->setRedirect(Route::_('index.php?option=com_sample_form2&view=form&layout=edit', false));
	}

}