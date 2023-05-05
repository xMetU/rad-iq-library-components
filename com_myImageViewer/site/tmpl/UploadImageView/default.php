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

<!-- ========== UPLOAD IMAGE VIEW ========== -->

<div class="row justify-content-center">
	<div class="col-8">
		<div class="row">
			<div class="col">
				<a class="btn" href="<?php echo Uri::getInstance()->current() . Route::_('?&task=Display.display') ?>">Back</a>
			</div>
			<div class="col-8 text-center">
				<h3>Upload New Image</h3>
			</div>
			<div class="col"></div>
		</div>

		<form 
			action="<?php echo Uri::getInstance()->current() . '?&task=Form.saveImage' ?>"
			method="post"
			id="adminForm"
			name="adminForm"
			enctype="multipart/form-data"
		>
			<hr/>

			<div class="form-group">
				<label for="imageName">Name:</label>
				<input type="text" name="imageName" placeholder="My new image" class="form-control"/>
			</div>

			<hr/>

			<div class="form-group">
				<label for="imageDescription">Description:</label>
				<input type="textarea" name="imageDescription" placeholder="My new images description" rows="4" class="form-control"/>
			</div>

			<hr/>

			<div class="form-group row">
				<label for="categoryId">Category:</label>

				<div class="col">
					<select id="uploadCategory" name="categoryId" class="form-control">
						<?php foreach ($this->categories as $c => $row) : ?>
							<option value="<?php echo $row->id; ?>"><?php echo $row->categoryName; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				
				<div class="col-auto">
					<a
						href="<?php echo Uri::getInstance()->current() . '?&task=Display.addNewCategory' ?>"
						class="btn"
					>New Category</a>
				</div>
			</div>

			<hr/>

			<div class="form-group">
				<label for="imageUrl">File:</label>
				
				<input type="file" name="imageUrl" class="form-control"/>
			</div>
			
			<hr/>
			
			<div class="form-group">
				<button class="btn col-auto" id="uploadImage-submit" onclick="Joomla.submitbutton(Form.saveImage)"><i class="icon-check icon-white"></i> Done</button>
			</div>
		</form>	
	</div>
</div>

