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
$document->addScript("media/com_myimageviewer/js/imageFormView.js");
$document->addStyleSheet("media/com_myimageviewer/css/style.css");

?>

<!-- ========== UPLOAD IMAGE VIEW ========== -->

<div class="row">
	<div class="col">
		<a class="btn" href="<?php echo Uri::getInstance()->current() ?>">Back</a>
	</div>
	<div class="col-8 text-center">
		<h3><?php echo ($this->image ? "Edit " . $this->image->name : "Create New Image Viewer"); ?></h3>
	</div>
	<div class="col"></div>
</div>

<hr/>

<div class="row justify-content-center">
	<div class="col-8">
		<form 
			action="<?php echo Uri::getInstance()->current() . ($this->image ? '?task=Form.updateImage' : '?task=Form.saveImage'); ?>"
			method="post"
			id="adminForm"
			name="adminForm"
			enctype="multipart/form-data"
		>
			<?php if ($this->image) : ?>
				<input type="hidden" name="imageId" value="<?php echo $this->image->id; ?>"/>
			<?php endif; ?>
			<div class="form-group">
				<label for="imageName">Title: *</label>

				<input 
					type="text"
					name="imageName"
					class="form-control"
					placeholder="Enter title..."
					maxlength="60"
					required
					value="<?php echo $this->image ? $this->image->name : ""; ?>"
				/>
			</div>

			<hr/>

			<div class="row form-group">
				<div class="col-6">
					<label for="categoryId">Category: *</label>

					<select
						id="uploadCategory"
						name="categoryId"
						class="form-control form-select"
						required
					>
						<option value="" <?php if (!$this->image) echo "selected"; ?>disabled hidden>Select a category</option>
						<?php foreach ($this->categories as $row) : ?>
							<option 
								value="<?php echo $row->id; ?>"
								<?php if ($this->image && $row->id == $this->image->categoryId) echo "selected"; ?>
							>
								<?php echo $row->categoryName; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				
				<div class="col-6">
					<label for="imageUrl">File: *</label>

					<input 
						type="file"
						name="imageUrl"
						class="form-control"
						accept=".png,.jpg,.jpeg,.gif"
						required
						<?php if ($this->image) echo "disabled"; ?>
					/>
				</div>
			</div>
			
			<hr/>

			<div class="form-group">
				<label for="imageDescription">Description:</label>

				<textarea
					name="imageDescription"
					class="form-control"
					placeholder="Enter description..."
					maxlength="12000"
					rows="16"
				><?php echo $this->image ? $this->image->description : ""; ?></textarea>
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