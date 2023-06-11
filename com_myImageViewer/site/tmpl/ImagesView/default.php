<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 */

 // No direct access to this file
defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Kieran\Component\MyImageViewer\Site\Helper\CheckGroup;

$document = Factory::getDocument();
$document->addScript("media/com_myimageviewer/js/imagesView.js");
$document->addStyleSheet("media/com_myimageviewer/css/style.css");

?>

<!-- IMAGES VIEW -->

<!-- Headers -->
<div class="row">
	<div class="col">
		<?php if (CheckGroup::isGroup("Manager")) : ?>
			<!-- Manage categories button -->
			<a class="btn" href="<?php echo Uri::getInstance()->current() . '?task=Display.categoryForm'; ?>">Manage Categories</a>
		<?php endif; ?>
	</div>

	<div class="col-auto"><h3>Image Viewers</h3></div>

	<div class="col">
		<?php if (CheckGroup::isGroup("Manager")) : ?>
			<!-- New image button -->
			<a class="btn float-end" href="<?php echo Uri::getInstance()->current() . '?task=Display.imageForm'; ?>"><i class="icon-plus"></i> New Image</a>
		<?php endif; ?>
	</div>
</div>

<hr/>

<div class="row pb-3">
	<div class="col-2 text-center my-auto">
		<h6>Filter by Category</h6>
	</div>

	<div class="col-10 ps-5">
		<div class="row">
			<div class="col"></div>

			<div class="col-6">
				<!-- Searchbar -->
				<form
					action="<?php echo Uri::getInstance()->current(); ?>"
					method="get"
					enctype="multipart/form-data"
				>
					<?php if ($this->category): ?>
						<input type="hidden" name="category" value="<?php echo $this->category; ?>">
					<?php endif; ?>
					<div class="input-group">
						<input
							name="search"
							id="text"
							class="form-control"
							placeholder="Search..."
							value="<?php if ($this->search) echo $this->search; ?>"
						/>
						<button type="submit" class="btn"><i class="icon-search"></i></button>
					</div>
				</form>
			</div>

			<div class="col"></div>
		</div>
	</div>
</div>

<div class="row">
	<!-- Categories -->
	<div class="col-2 fixed-height-1">
		<table id="categories" class="w-100">
			<tbody>
				<?php if (!empty($this->categories)) : ?>
					<?php foreach ($this->categories as $row) : ?>
						<tr>
							<td class="pb-3">
								<a
									class="btn w-100 py-1 text-center<?php if ($row->id == $this->category) echo " active"; ?>"
									href="<?php echo Uri::getInstance()->current()
										. ($row->id == $this->category ? "" : '?category='. $row->id)
									?>"
								>
									<?php echo $row->categoryName; ?>
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<!-- Images -->
	<div class="col-10 ps-5 fixed-height-1">
		<table id="images" class="table table-borderless">
			<tfoot>
				<tr>
					<td class="d-flex justify-content-center p-2" colspan="4">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>

			<tbody>
				<tr class="row">
					<?php if (!empty($this->items)) : ?>
						<?php foreach ($this->items as $item) : ?>
							<?php $render = CheckGroup::isGroup("Manager") ? true : !$item->isHidden; ?>
							<?php if ($render) : ?>
								<td class="col-3 pt-0 pb-4">
									<div class="card h-100 p-3 pb-0">
										<?php if (CheckGroup::isGroup("Manager") && $item->isHidden) : ?>
											<div class="card-overlay d-flex">
												<h5 class="m-auto">Hidden</h5>
											</div>
										<?php endif; ?>
										<img
											id="<?php echo $item->id; ?>"
											class="card-img-top"
											src="<?php echo $item->imageUrl . '.thumb'; ?>"
										/>

										<div class="card-body text-center p-2">
											<h5 class="word-break"><?php echo $item->imageName; ?></h5>
										</div>
									</div>
								</td>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php else: ?>
						<td>
                            <?php if ($this->category): ?>
                                <p class="text-center pt-5">No image viewers are assigned to this category</p>
                            <?php else: ?>
                                <p class="text-center pt-5">Could not find any matching image viewers</p>
                            <?php endif; ?>							
						</td>
					<?php endif; ?>
				</tr>
			</tbody>
		</table>
	</div>	
</div>
