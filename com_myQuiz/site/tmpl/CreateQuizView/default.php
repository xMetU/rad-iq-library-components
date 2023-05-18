<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_myQuiz
 */

 // No direct access to this file
defined('_JEXEC') or die('Restricted Access');

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;


?>


<!-- ====== CREATE QUIZ DISPLAY =========== -->
<div class="mt-5">
    <form 
        action="<?php echo Uri::getInstance()->current() . '?&task=CreateQuiz.processQuiz' ?>"
        method="post"
        id="adminForm"
        name="adminForm"
        enctype="multipart/form-data"
    >

        <!-- Title -->
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" placeholder="Enter title..." class="form-control"/>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea type="textarea" name="description" placeholder="Enter description..." rows="5" class="form-control"></textarea>
        </div>

        <div class="form-group">
			<label for="imageUrl">Image:</label>	
		    <select name="imageId"  placeholder="Select quiz image..." class="form-control">
				<?php foreach ($this->images as $row) : ?>
					<option value="<?php echo $row->id; ?>"><?php echo $row->imageName; ?></option>
				<?php endforeach; ?>
		    </select>
		</div>

        <div class="form-group">
            <input type="number" name="attemptsAllowed" placeholder="Number of attempts allowed..." min="1" class="form-control"/>
        </div>

        <div class="col-6 form-group">
            <button class="btn btn-primary" id="createQuiz-submit" onclick="Joomla.submitbutton(CreateQuiz.processQuiz)"><i class="icon-check icon-white"></i> CREATE QUIZ</button>
        </div>
    </form>
    

</div>


