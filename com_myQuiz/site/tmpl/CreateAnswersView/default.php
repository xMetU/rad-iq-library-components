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


<!-- ====== CREATE ANSWERS DISPLAY =========== -->

<div class="row">
	<div class="col">
		<a 
            class="btn float-start"
            href="<?php echo Uri::getInstance()->current() . '?task=Display.createQuestions&questionNumber=' . $this->questionNumber; ?>"
        >Add Another Question</a>
	</div>
	<div class="col-8 text-center text-truncate">
		<h4>Add Answers to "<?php echo substr($this->questionDescription, 0, 40) . "..."; ?>"</h4>
	</div>
	<div class="col">
        <a 
            class="btn float-end"
            href="<?php echo Uri::getInstance()->current() . '?task=CreateQuiz.saveAllQuiz'; ?>"
        >Finish and Save Quiz</a>
    </div>
</div>

<hr/>

<!-- TODO: Make this table look prettier -->
<div class="row justify-content-center">
    <div class="col-8">
        <?php if ($this->answerArray) : ?>
            <div id="answers">
                <?php foreach ($this->answerArray as $row) : ?>
                    <?php if ($row['questionNumber'] == $this->questionNumber) : ?>
                        <div class="row p-2 mb-3">
                            <div class="col-1"><?php echo $row['answerNumber']; ?>.</div>
                            <div class="col-1"><i class="<?php if ($row['isCorrect']) echo " icon-checkmark-circle"; ?>"></i></div>
                            <div class="col text-truncate"><?php echo $row['answerDescription']; ?></div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <hr/>
        <?php endif; ?>

        <form 
            action="<?php echo Uri::getInstance()->current() . '?task=CreateQuiz.processAnswers' ?>"
            method="post"
            id="adminForm"
            name="adminForm"
            enctype="multipart/form-data"
        >
            <input type="hidden" name="questionNumber" value="<?php echo $this->questionNumber; ?>"/>
            <input type="hidden" name="answerNumber" value="<?php echo $this->answerNumber; ?>"/>

            <div class="form-group">
                <label for="answerDescription">New Answer: *</label>

                <textarea 
                    type="text"
                    name="answerDescription"
                    class="form-control"
                    placeholder="Enter answer text..."
                    maxlength="200"
                    required
                    rows="2"
                ></textarea>
            </div>

            <div class="row form-group">
                <div class="col">
                    <input type="checkbox" name="isCorrect" value="1"/>
                    <label for="isCorrect">Is this a correct answer?</label>
                </div>
            
                <div class="col-auto">
                    <button class="btn" id="createQuiz-submit" onclick="Joomla.submitbutton(CreateQuiz.processAnswers)">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>
