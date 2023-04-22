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

?>



<!-- Display all images -->
<div class="row mt-5 mb-5">
	<div class="bg-muted col-3">
		<table>
			<thead>
				<tr>
					<th>
						<?php echo Text::_('CATEGORY'); ?>
					</th>
				</tr>	
			</thead>
			
			<tbody>
				<?php if (!empty($this->buttonCategories)) : ?>
					<?php foreach ($this->buttonCategories as $bc => $row) : ?>
						<tr>
							<td class="col-2">
								<a class="btn btn-primary" href="<?php echo Uri::getInstance()->current() . Route::_('?imageCategory='. $row->categoryName . '&task=Display.changeImageList') ?>"><?php echo $row->categoryName; ?></a>
								<!-- <a class="btn btn-primary" href="index.php?imageCategory=<?php echo $row->categoryName; ?>&task=Display.changeImageList"><?php echo $row->categoryName; ?></a> -->
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<div id="test" class="bg-muted col-4">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>
						<?php echo Text::_('IMAGES'); ?>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td>
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody id="images">
				<?php if (!empty($this->items)) : ?>
					<?php foreach ($this->items as $i => $row) : ?>
						<tr>
							<td class="col-3">								
								<img id="<?php echo $row->id; ?>" src="<?php echo $row->imageUrl; ?>" style="width:150px;height:180px;"/>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
	
</div>


<!-- Makes the images clickable and directs to the focus image view -->
<script>
	window.onload = function() {
    let tableBody = document.getElementById("images");
    
    tableBody.querySelectorAll("img").forEach(function (image) {
        image.addEventListener("click", function () {
    
            window.location.href = "<?php echo Uri::getInstance()->current() . '?&task=Display.focusImage&id=' ; ?>" + image.id;
        });
    });
};
</script>

