<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 */

 // No direct access to this file
defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

$document = Factory::getDocument();
$document->addScript("media/com_myimageviewer/js/imageFormView.js");
$document->addStyleSheet("media/com_myimageviewer/css/style.css");

?>

<!-- EDIT IMAGE FORM VIEW -->

<div class="row">
	<div class="col">
		<a class="btn" href="<?php echo Uri::getInstance()->current() ?>">Back</a>
	</div>

	<div class="col-8 text-center">
		<h3><?php echo "Edit " . $this->imageName; ?></h3>
	</div>

	<div class="col"></div>
</div>

<hr/>



<div class="row justify-content-center">

	<div class="col-8">
		<form 
			action="<?php echo Uri::getInstance()->current() . '?task=Form.updateImage'; ?>"
			method="post"
			id="adminForm"
			name="adminForm"
			enctype="multipart/form-data"
		>
			<input type="hidden" id="imageId" name="imageId" value="<?php echo $this->image->id; ?>"/>

			<div class="form-group">
				<label for="imageName">Title: *</label>

				<input 
					type="text"
					id="imageName"
					name="imageName"
					class="form-control"
					placeholder="Enter title..."
					maxlength="60"
					required
					value="<?php echo $this->image->name; ?>"
				/>
			</div>

			<hr/>

			<div class="row form-group">
				<div class="col-6">
					<label for="categoryId">Category: *</label>

					<select
						id="editImageCategory"
						name="categoryId"
						class="form-control form-select"
						required
					>
						<?php foreach ($this->categories as $row) : ?>
							<option value="<?php echo $row->categoryId; ?>"
								<?php if ($row->categoryId == $this->categoryId) : ?>
									<?php echo "selected"; ?>
								<?php endif ?>
							><?php echo $row->categoryName; ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="col-6">
					<label for="subcategoryId">Subcategory: </label>

					<select
						id="editImageSubcategory"
						name="subcategoryId"
						class="form-control form-select"
					>
						<option value="" selected disabled hidden>
							<?php echo $this->subcategories ? "Select a subcategory" : "No Subcategories" ; ?>
						</option>

						<?php if ($this->categoryId): ?>
							
							<?php if ($this->subcategories): ?>
								<option value=""><?php echo "None" ; ?></option>
							<?php endif; ?>
							
							<?php foreach ($this->subcategories as $row) : ?>
								<option
									value="<?php echo $row->subcategoryId; ?>"
									<?php if ($row->subcategoryId == $this->image->subcategoryId) echo "selected"; ?>
								><?php echo $row->subcategoryName; ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>	
			</div>
			
			<hr/>

			<div class="form-group">
				<label for="imageDescription">Description:</label>

				<textarea
					id="imageDescription"
					name="imageDescription"
					class="form-control"
					placeholder="Enter description..."
					maxlength="12000"
					rows="16"
				><?php echo $this->image->description; ?></textarea>
			</div>

			<hr/>
			
			<div class="form-group">
				<button class="btn col-auto">
					<i class="icon-check"></i> Done
				</button>
			</div>
		</form>
	</div>
</div>

<script>
	// Handles persistent form data between redirects caused by selecting a category
	const parent = document.getElementById("editImageCategory");
	const imageId = "<?php echo $this->image->id; ?>";

	parent.onchange = (e) => {
		sessionStorage.setItem("imageName", document.getElementById("imageName").value);
		sessionStorage.setItem("imageDescription", document.getElementById("imageDescription").value);
		var changeId = document.getElementById("editImageCategory").value;

		window.location.href = `?task=Display.editImageForm&id=${imageId}&categoryId=${changeId}`;	
	}

	const imageName = sessionStorage.getItem("imageName");
	const imageDescription = sessionStorage.getItem("imageDescription");

	if (imageName) {
		document.getElementById("imageName").value = imageName;
		sessionStorage.removeItem("imageName");
	}
	if (imageDescription) {
		document.getElementById("imageDescription").value = imageDescription;
		sessionStorage.removeItem("imageDescription");
	}
</script>