<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_myImageViewer
 *
 */

 // No direct access to this file
defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

$document = Factory::getDocument();
$document->addStyleSheet("media/com_myimageviewer/css/style.css");

?>

<!-- ========== ADD NEW CATEGORY VIEW ========== -->

<div class="row justify-content-center">
	<div class="col-8">
		<div class="row">
			<div class="col">
				<a class="btn" href="<?php echo Uri::getInstance()->current() . Route::_('?&task=Display.uploadForm') ?>">Back</a>
			</div>
			<div class="col-8 text-center">
				<h3>Create New Category</h3>
			</div>
			<div class="col"></div>
		</div>
		<form action="<?php echo Uri::getInstance()->current() . '?&task=Form.saveCategory' ?>" method="post" id="adminForm" name="adminForm">
			<hr/>

			<div class="form-group row">
				<label for="categoryName">Category Name:</label>

				<div class="col">
					<?php echo $this->form->renderFieldSet('addNewCategory'); ?>
				</div>
				<div class="col-auto">
					<button class="btn" id="addNewCategory-submit" onclick="Joomla.submitbutton(Form.saveCategory)"></i>Create</button> 
				</div>
			</div>
		</form>
	</div>
</div>



