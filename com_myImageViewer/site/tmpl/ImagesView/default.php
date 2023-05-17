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
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;

$document = Factory::getDocument();
$document->addScript("media/com_myimageviewer/js/imagesView.js");
$document->addStyleSheet("media/com_myimageviewer/css/style.css");

// get categories from url
$categories = isset($_GET['categories']) ? explode(',', $_GET['categories']) : [];
// filter out empty entries caused by implode/explode
$categories = array_filter($categories);

// if $id is in $categories, remove it, otherwise add it
function toggleCategory($id, $categories) {
	if (in_array($id, $categories)) {
		return array_diff($categories, [$id]);
	} else {
		return array_merge($categories, [$id]);
	}
}

?>

<!-- ========== IMAGE VIEW ========== -->

<!-- Headers -->
<div class="row">
	<div class="col-2 text-center my-auto">
		<h6>Categories</h6>
	</div>
	<div class="col-10 row ps-5">
		<div class="col">
			<a class="btn" href="<?php echo Uri::getInstance()->current() . '?task=Display.categoryForm'; ?>">Manage</a>
		</div>
		<div class="col text-center">
			<h3>Images</h3>
		</div>
		<div class="col">
			<a class="btn float-end" href="<?php echo Uri::getInstance()->current() . '?task=Display.imageForm'; ?>">
				<i class="icon-plus icon-white"></i> New
			</a>
		</div>
	</div>
</div>

<div class="row">
	<!-- Categories -->
	<div class="col-2">
		<table id="categories" class="w-100">
			<tbody>
				<?php if (!empty($this->buttonCategories)) : ?>
					<?php foreach ($this->buttonCategories as $category) : ?>
						<tr>
							<td class="pt-3 overflow-hidden">
								<a
									class="btn w-100 py-1 text-center<?php echo in_array($category->id, $categories) ? " active" : ""; ?>"
									href="<?php
										echo Uri::getInstance()->current()
										. Route::_('?categories='. implode(',', toggleCategory($category->id, $categories)));
									?>"
								>
									<?php echo $category->categoryName; ?>
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<!-- Images -->
	<div class="col-10 row ps-5">
		<table id="images" class="table table-borderless">
			<tfoot>
				<tr>
					<td class="d-flex justify-content-center p-2" colspan="3">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>

			<tbody>
				<?php if (!empty($this->items)) : ?>
					<tr class="row">
						<?php foreach ($this->items as $item) : ?>
							<td class="col-3 pt-3 px-3">
								<div class="card p-3 pb-0">
									<img
										id="<?php echo $item->id; ?>"
										class="card-img-top"
										src="<?php echo $item->imageUrl; ?>"
									/>
									<div class="card-body text-center p-2">
										<h5 class="text-truncate"><?php echo $item->imageName; ?></h5>
									</div>
								</div>
							</td>
						<?php endforeach; ?>
					</tr>
				<?php else: ?>
					<tr>
						<td>
							<p class="text-secondary text-center pt-5">Select a category to view images</p>
						</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>	
</div>

