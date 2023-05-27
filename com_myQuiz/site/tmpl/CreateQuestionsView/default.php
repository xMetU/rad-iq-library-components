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

$document = Factory::getDocument();
$document->addStyleSheet("media/com_myquiz/css/style.css");

?>

<!-- ====== CREATE QUESTION DISPLAY =========== -->

<div class="row">
	<div class="col">
		<a class="btn" href="<?php echo Uri::getInstance()->current(); ?>">Back</a>
	</div>
	<div class="col-8 text-center">
		<h3>Add Questions to <?php echo Factory::getApplication()->getUserState('myQuiz.createQuizData')['title']; ?></h3>
	</div>
	<div class="col"></div>
</div>

<hr/>

<div class="row justify-content-center">
    <div class="col-8">
        <form 
            action="<?php echo Uri::getInstance()->current() . '?task=CreateQuiz.processQuestion' ?>"
            method="post"
            id="adminForm"
            name="adminForm"
            enctype="multipart/form-data"
        >
            <input type="hidden" name="questionNumber" value="<?php echo $this->questionNumber; ?>"/>

            <div class="form-group">
                <label for="questionDescription">Question: *</label>

                <textarea
                    name="questionDescription"
                    class="form-control"
                    placeholder="What is the question?"
                    maxlength="200"
                    required
                    rows="3"
                ></textarea>
            </div>

            <hr/>

            <div class="form-group">
                <label for="questionFeedback">Feedback: *</label>

                <textarea
                    name="questionFeedback"
                    class="form-control"
                    placeholder="Feedback when the question is answered."
                    maxlength="200"
                    required
                    rows="3"
                ></textarea>
            </div>

            <hr/>

            <div class="form-group">
                <label data-toggle="tooltip" for="markValue">Marks: *</label>

                <input
                    type="number"
                    name="markValue"
                    class="form-control"
                    placeholder="How many marks is this question worth?"
                    min="1"
                />
            </div>

            <hr/>

            <div class="form-group">
                <button class="btn">Create Answers</button>
            </div>
        </form>
    </div>
</div>
