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

?>


<!-- Upload image Form -->
<form action="index.php?option=com_myImageViewer&view=UploadImageView" method="post" id="adminForm" name="adminForm">
	<table class="table table-hover mt-5">
		<tbody>
			<tr>
				<td>
					<?php echo Text::_('TITLE'); ?>:
				</td>
				<td>
					<input type="text" id="myImageViewer-upload-title" name="myImageVieweruploadtitle" value=""  maxlength="255" class="form-control" />
				</td>
			</tr>

			<tr>
				<td>
					<?php echo Text::_('CATEGORY'); ?>:
				</td>
				<td>
					<!-- Drop down list to display the categories -->
					<select id="myImageViewer-Upload-Category" name="myImageViewerUploadCategory" class="form-control">
						<?php foreach ($this->items as $i => $row) : ?>
							<option value="<?php echo $row->imageCategory; ?>"><?php echo $row->imageCategory; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td>
					<a href="index.php?task=Upload.display" class="btn btn-outline-primary"><?php echo Text::_('NEW CATEGORY'); ?></a>
				</td>
			</tr>

			<tr>
				<td><?php echo Text::_('DESCRIPTION'); ?>:</td>
				<td>
					<textarea id="myImageViewer-Upload-Description" name="myImageViewerUploadDescription" 
					onkeyup="countCharsUpload('<?php echo $this->t['upload_form_id']; ?>');" cols="30" rows="10" 
					class="form-control"></textarea>
				</td>				
			</tr>

			<tr>
				<td><?php echo Text::_('FILENAME');?>:</td>
				<td>
					<input type="file" id="file-upload" name="Filedata" class="form-control" />
					<button class="btn btn-primary" id="file-upload-submit"><i class="icon-upload icon-white"></i><?php echo Text::_(' SAVE'); ?></button>
				</td>
			</tr>
		</tbody>
	</table>
</form>



