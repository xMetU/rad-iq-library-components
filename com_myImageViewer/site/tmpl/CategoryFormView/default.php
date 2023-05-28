<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 */

 // No direct access to this file
defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

$document = Factory::getDocument();
$document->addScript("media/com_myimageviewer/js/categoryFormView.js");
$document->addStyleSheet("media/com_myimageviewer/css/style.css");


?>

<!-- ========== ADD NEW CATEGORY VIEW ========== -->

<!-- Header -->
<div class="row">
	<div class="col">
		<a class="btn" href="<?php echo Uri::getInstance()->current(); ?>">Back</a>
	</div>
	<div class="col-8 text-center">
		<h3>Manage Categories</h3>
	</div>
	<div class="col"></div>
</div>

<hr/>

<div class="row justify-content-center">
	<div class="col-8">
		<!-- Create form -->
		<form 
			action="<?php echo Uri::getInstance()->current() . '?task=Form.saveCategory' ?>"
			method="post"
			id="adminForm"
			name="adminForm"
		>
			<div class="row form-group">
				<h5 class="text-center">Create New Category</h5>

				<div class="col">
					<label for="categoryName">Category Name: *</label>

					<input
						type="text"
						name="categoryName"
						class="form-control"
						placeholder="Enter name..."
						maxlength="30"
						required
					/>
				</div>

				<div class="col-auto">
					<button class="btn mt-4">
						<i class="icon-check icon-white"></i> Done
					</button> 
				</div>
			</div>
		</form>

		<hr/>

		<!-- Delete form -->
		<form 
			action="<?php echo Uri::getInstance()->current() . '?task=Form.deleteCategory' ?>"
			method="post"
			name="adminForm"
		>	
			<div class="row form-group">
				<h5 class="text-center">Remove Category</h5>

				<div class="col">
					<label for="categoryId">Category Name: *</label>

					<select id="delete-select" name="categoryId" class="form-control form-select" required>
						<option value="" selected disabled hidden>Select a category</option>
						<?php foreach ($this->categories as $row) : ?>
							<option value="<?php echo $row->id; ?>"><?php echo $row->categoryName; ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="col-auto">
					<button id="delete-button" class="btn mt-4">
						<i class="icon-times icon-white"></i> Remove
					</button> 
				</div>
			</div>

			<!-- Delete confirmation -->
			<div id="delete-confirmation" class="overlay-background d-flex d-none">
				<div class="m-auto text-center">
					<h5 class="mb-4"><!-- Message --></h5>
					<button id="delete-confirm" class="btn me-3">Yes, remove it</button>
					<button id="delete-cancel" class="btn ms-3">No, go back</button>
				</div>
			</div>
		</form>
	</div>
</div>



