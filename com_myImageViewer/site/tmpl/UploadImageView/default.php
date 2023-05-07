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
$document->addScript("media/com_myimageviewer/js/uploadImageView.js");
$document->addStyleSheet("media/com_myimageviewer/css/style.css");

$selectedImage = "1";
?>

<!-- ========== UPLOAD IMAGE VIEW ========== -->

<div class="row">
	<div class="col">
		<a class="btn" href="<?php echo Uri::getInstance()->current() ?>">Back</a>
	</div>
	<div class="col-8 text-center">
		<h3>Manage Images</h3>
	</div>
	<div class="col"></div>
</div>

<hr/>

<div class="row">
	<div class="col-8 pe-5">
		<h5 class="text-center">Add New Image</h5>
		<form 
			action="<?php echo Uri::getInstance()->current() . '?&task=Form.saveImage' ?>"
			method="post"
			id="adminForm"
			name="adminForm"
			enctype="multipart/form-data"
		>
			<div class="form-group">
				<label for="imageName">Name: *</label>

				<input 
					type="text"
					name="imageName"
					placeholder="Enter name..."
					class="form-control"
					maxlength="50"
					required
				/>
			</div>

			<hr/>

			<div class="row form-group">
				<div class="col-6">
					<label for="categoryId">Category: *</label>

					<select id="uploadCategory" name="categoryId" class="form-control form-select" required>
						<option value="" selected disabled hidden>Select a category</option>
						<?php foreach ($this->categories as $row) : ?>
							<option value="<?php echo $row->id; ?>"><?php echo $row->categoryName; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				
				<div class="col-6">
					<label for="imageUrl">File: *</label>

					<input type="file" name="imageUrl" class="form-control" required/>
				</div>
			</div>		
			
			<hr/>

			<div class="form-group">
				<label for="imageDescription">Description:</label>

				<textarea type="textarea" name="imageDescription" placeholder="Enter description..." rows="16" class="form-control"></textarea>
			</div>

			<hr/>
			
			<div class="form-group">
				<button id="uploadImage-submit" class="btn col-auto">
					<i class="icon-check icon-white"></i> Done
				</button>
			</div>
		</form>
	</div>
	
	<div id="images" class="col">
		<h5 class="text-center pb-4">Remove Images</h5>

		<?php foreach ($this->images as $row) : ?>
			<form
				action="<?php echo Uri::getInstance()->current() . '?&task=Form.deleteImage' ?>"
				method="post"
				enctype="multipart/form-data"
			>
				<input type="hidden" name="imageId" value="<?php echo $row->id; ?>"/>

				<input type="hidden" name="imageUrl" value="<?php echo $row->imageUrl; ?>">

				<div class="row mb-2">
					<div class="col">
						<div class="row p-1">
							<div class="col-4 text-truncate border-end"><?php echo $row->imageName; ?></div>

							<div class="col-3 text-truncate border-end"><?php echo $row->categoryName; ?></div>

							<div class="col-5 text-truncate"><?php echo $row->imageDescription; ?></div>
						</div>
					</div>
					
					<div class="col-auto">
						<button class="delete btn btn-sm">delete</button>
					</div>
				</div>

				<div class="overlay-background d-flex d-none">
					<div class="m-auto justify-content-center">
						<div class="row mb-4 text-center">
							<h5>Are you sure you want to delete <?php echo $row->imageName; ?>?<br/>This action cannot be undone.</h5>
						</div>
						<div class="row">
							<div class="col">
								<button id="deleteImage-submit" class="delete-yes btn float-end me-3">Yes, delete it</button>
							</div>
							<div class="col">
								<button class="delete-no btn ms-3">No, go back</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		<?php endforeach; ?>
	</div>
</div>