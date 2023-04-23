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
$document->addScript("media/com_myimageviewer/js/imageView.js");
$document->addStyleSheet("media/com_myimageviewer/css/style.css");

?>

<!-- ========== IMAGE VIEW ========== -->

<!-- Headers -->
<div class="row">
	<div class="col-2 text-center">
		<p>Select Category</p>
	</div>
	<div class="col-10 text-center">
		<h2>Images</h2>
	</div>
</div>

<!-- Categories -->
<div class="row">
	<div class="col-2 text-center">
		<table class="w-100">
			<tbody id="categories">
				<?php if (!empty($this->buttonCategories)) : ?>
					<?php foreach ($this->buttonCategories as $category) : ?>
						<tr>
							<td class="p-2">
								<a
									class="btn d-flex justify-content-center"
									href="<?php echo Uri::getInstance()->current() . Route::_('?imageCategory='. $category->categoryName . '&task=Display.changeImageList') ?>"
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
	<div class="col-10">
		<table class="table table-borderless">
			<tfoot>
				<tr>
					<td class="d-flex justify-content-center p-0" colspan="3">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>

			<tbody id="images">
				<?php if (!empty($this->items)) : ?>
					<?php foreach (array_chunk($this->items, 4) as $row) : ?>
						<tr class="row">
							<?php foreach ($row as $item) : ?>
								<td class="col-3 p-2">
									<div class="card p-3 pb-0">
										<img
											id="<?php echo $item->id; ?>"
											class="card-img-top"
											src="<?php echo $item->imageUrl; ?>"
										/>

										<div class="card-body text-center p-2">
											<h5><?php echo $item->imageName; ?></h5>
										</div>
									</div>
								</td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>	
</div>