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
        Factory::getApplication()->enqueueMessage("FormController/saveImage");
        

		$model = $this->getModel('UploadImage');
		
		$data = $_POST;
		$file = Factory::getApplication()->input->files->get('imageUrl');		
		
		$name = $file['name'];
		$tmp = $file['tmp_name'];

		$path = JPATH_ROOT . '/media/com_myImageViewer/images/';
		$categoryName = $model->getCategory($data['categoryId'])->categoryName;


		$folderUrl = $path . $categoryName;
		$uploadUrl = $path . $categoryName . '/' . $name;

		$imageUrl = 'media/com_myImageViewer/images/' . $categoryName . '/' . $name;


		Folder::create($folderUrl);
		File::upload($tmp, $uploadUrl);

		array_push($data, $imageUrl);
		// $validData = $model->validate($form, $data);

		$model->saveImage($data);

        // $this->setRedirect(Route::_('index.php?option=com_myImageViewer&view=ImageView', false));
    }



    public function cancelImage($key = null) {
        Factory::getApplication()->enqueueMessage("FormController/cancelImage");

        parent::cancel($key);
    }



    public function saveCategory() {  

		$app = Factory::getApplication();

        $app->enqueueMessage("FormController/saveCategory");


		$input = $app->input;

		// $val = $input->post->get('myImageViewerAddNewCategoryName', 'none');
		// $input->post->set('myImageViewerAddNewCategoryName', 't');

		$model = $this->getModel('AddNewCategory');

        $data  = $input->post->get('formArray', array(), 'array');
		$form = $model->getForm($data, false);
        
		// $validData = $model->validate($form, $data);

		if($model->save($data)){
			$app->enqueueMessage("Category Added Successfully");
			$this->setRedirect(Route::_('index.php?&task=Display.display', false));
		}
		else{
			$app->enqueueMessage("Could not add category");
			$this->setRedirect(Route::_('index.php?&task=Display.addNewCategory', false));
		}
		
		
    }



    public function submit($key = null, $urlVar = null) {     

		$this->checkToken();

		$app   = Factory::getApplication();
		$model = $this->getModel('Form');
		$form = $model->getForm($data, false);


		if (!$form)
		{
			$app->enqueueMessage($model->getError(), 'error');
			return false;
		}

		// name of array 'form' must match 'control' => 'form' line in the model code
		$data  = $this->input->post->get('Form', array(), 'array');

		// This is validate() from the FormModel class, not the Form class
		// FormModel::validate() calls both Form::filter() and Form::validate() methods
		$validData = $model->validate($form, $data);

		if ($validData === false)
		{
			$errors = $model->getErrors();

			foreach ($errors as $error)
			{
				if ($error instanceof \Exception)
				{
					$app->enqueueMessage($error->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($error, 'warning');
				}
			}

			// Save the form data in the session, using a unique identifier
			$app->setUserState('com_sample_form2.sample', $data);
		}
		else
		{
			$app->enqueueMessage("Data successfully validated", 'notice');
			// Clear the form data in the session
			$app->setUserState('com_sample_form2.sample', null);
		}

		// Redirect back to the form in all cases
		$this->setRedirect(Route::_('index.php?option=com_sample_form2&view=form&layout=edit', false));
	}

}