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

<!-- CATEGORY FORM VIEW -->

<!-- Header -->
<div class="row">
	<div class="col">
		<a class="btn" href="<?php echo $this->toQuiz ? "index.php/quizzes" : Uri::getInstance()->current(); ?>">Back</a>
	</div>
	<div class="col-8 text-center">
		<h3>Manage Categories</h3>
	</div>
	<div class="col"></div>
</div>

<hr/>

<div class="row my-4">
	<!-- Create category form -->
	<div class="col">
		<h4 class="text-center">Create New Category</h4>

		<form 
			action="<?php echo Uri::getInstance()->current() . '?task=Form.saveCategory'; ?>"
			method="post"
			name="adminForm"
		>
			<div class="row form-group">
				<div class="col">
					<label for="categoryName">Name: *</label>

					<input
						type="text"
						name="categoryName"
						class="form-control"
						placeholder="Enter category name..."
						maxlength="30"
						required
					/>
				</div>

				<div class="col-auto">
					<button class="btn mt-4">
						<i class="icon-check"></i> Done
					</button> 
				</div>
			</div>
		</form>
	</div>

	<div class="col-1"></div>

	<!-- Delete category form -->
	<div class="col">
		<h4 class="text-center">Remove Category</h4>
		<form 
			action="<?php echo Uri::getInstance()->current() . '?task=Form.deleteCategory'; ?>"
			method="post"
			name="adminForm"
		>	
			<div class="row form-group">
				<div class="col">
					<label for="categoryId">Name: *</label>

					<select id="delete-select" name="categoryId" class="form-control form-select" required>
						<option value="" selected disabled hidden>Select a category</option>
						<?php foreach ($this->categories as $row) : ?>
							<option value="<?php echo $row->categoryId; ?>"><?php echo $row->categoryName; ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="col-auto">
					<button id="delete-button" class="btn mt-4">
						<i class="icon-times"></i> Remove
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
	
<hr/>

<div class="row my-4">
	<!-- Create subcategory form -->
	<div class="col">
		<h4 class="text-center">Create New Subcategory</h4>

		<form 
			action="<?php echo Uri::getInstance()->current() . '?task=Form.saveSubcategory'; ?>"
			method="post"
			id="adminForm"
			name="adminForm"
			enctype="multipart/form-data"
		>
			<div class="form-group">
				<label for="categoryId">Category Name: *</label>

				<select id="parent-category-select" name="categoryId" class="form-control form-select" required>
					<option value="" selected disabled hidden>Select a category</option>
					<?php foreach ($this->categories as $row) : ?>
						<option value="<?php echo $row->categoryId; ?>"><?php echo $row->categoryName; ?></option>
					<?php endforeach; ?>
				</select>

				
			</div>
			
			<div class="row form-group">
				<div class="col">
					<label for="categoryName">Subcategory Name: *</label>
				
					<input
						type="text"
						name="subcategoryName"
						class="form-control"
						placeholder="Enter subcategory name..."
						maxlength="30"
					/>
				</div>
				
				<div class="col-auto">
					<button class="btn mt-4">
						<i class="icon-check"></i> Done
					</button> 
				</div>
			</div>

		</form>
	</div>

	<div class="col-1"></div>

	<!-- Delete subcategory form -->
	<div class="col">
		<h4 class="text-center">Remove Subcategory</h4>

		<form 
			action="<?php echo Uri::getInstance()->current() . '?task=Form.deleteSubcategory'; ?>"
			method="post"
			name="adminForm"
		>	
			<div class="form-group">
				<label for="categoryId">Category Name: *</label>

				<select id="delete-parent-category-select" name="categoryId" class="form-control form-select" required>
					<option value="" selected disabled hidden>Select a parent category</option>
					<?php foreach ($this->categories as $row) : ?>
						<option value="<?php echo $row->categoryId; ?>"><?php echo $row->categoryName; ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="row form-group">
				<div class="col">
					<label for="subcategoryId">Subcategory Name: *</label>

					<select 
						id="delete-select-sub"
						name="subcategoryId"
						class="form-control form-select"
						required
					>
						<?php if ($this->subcategories) : ?>
							<option value="" selected disabled hidden>Select a subcategory</option>
							<?php foreach ($this->subcategories as $row) : ?>
								<?php if ($row->categoryId == $this->categoryId): ?>
									<option value="<?php echo $row->subcategoryId; ?>"><?php echo $row->subcategoryName; ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php else: ?>
							<option value="" selected>No subcategories</option>
						<?php endif ?>
					</select>
				</div>

				<div class="col-auto">
					<button id="delete-button-sub" class="btn mt-4">
						<i class="icon-times"></i> Remove
					</button> 
				</div>
				
			</div>

			<!-- Delete confirmation -->
			<div id="delete-confirmation-sub" class="overlay-background d-flex d-none">
				<div class="m-auto text-center">
					<h5 class="mb-4"><!-- Message --></h5>
					<button id="delete-confirm-sub" class="btn me-3">Yes, remove it</button>
					<button id="delete-cancel-sub" class="btn ms-3">No, go back</button>
				</div>
			</div>
			
		</form>	
	</div>
</div>

<hr/>

<script>
	const parent = document.getElementById("delete-parent-category-select");

	parent.onchange = (e) => {
		var catId = document.getElementById("delete-parent-category-select").value;
		window.location.href = `?task=Display.categoryForm&categoryId=${catId}`;
	}

	if ("<?php echo $this->categoryId; ?>") {
		for(i= 0; i < parent.options.length; i++) {
			if(parent.options[i].value == "<?php echo $this->categoryId; ?>") {
				parent.options[i].selected = true;
			}
		}
	}
</script>
