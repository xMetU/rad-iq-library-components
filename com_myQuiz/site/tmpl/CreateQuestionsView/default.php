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


<!-- ====== CREATE QUESTION DISPLAY =========== -->
<div>
    <h3>QUESTION</h3>
</div>

<div class="mt-5">
    <form 
        action="<?php echo Uri::getInstance()->current() . '?&task=CreateQuiz.processQuestion' ?>"
        method="post"
        id="adminForm"
        name="adminForm"
        enctype="multipart/form-data"
    >

        <!-- Description -->
        <div class="form-group">
            <label for="questionDescription">Description:</label>
            <input type="text" name="questionDescription" placeholder="What is the question?" class="form-control"/>
        </div>

        <!-- Feedback -->
        <div class="form-group">
            <label for="questionFeedback">Feedback:</label>
            <input type="text" name="questionFeedback" placeholder="Feedback for wrong answer" class="form-control"/>
        </div>

        <!-- Value -->
        <div class="form-group">
            <label for="markValue">Mark Value:</label>
            <input type="number" name="markValue" placeholder="How many marks is this question worth?" min="1" class="form-control"/>
        </div>

        <div class="form-group">
            <input type="hidden" name="questionNumber" value="<?php echo $this->questionNumber; ?>" class="form-control"/>
        </div>

        <div class="row mt-5">
            <div class="col-6 form-group">
                <button class="btn btn-primary" id="createQuiz-submit" onclick="Joomla.submitbutton(CreateQuiz.processQuestion)">CREATE ANSWERS</button>
            </div>
        </div>
    </form>

</div>


