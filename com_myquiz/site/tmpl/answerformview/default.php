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
$document->addScript("media/com_myquiz/js/answerFormView.js");
$document->addStyleSheet("media/com_myquiz/css/style.css");

?>

<!-- ASNWER FORM VIEW -->

<div class="row">
	<div class="col">
		<a class="btn" href="<?php echo
            Uri::getInstance()->current()
            . '?task=Display.questionForm&quizId=' . $this->question->quizId;
        ?>">Back</a>
	</div>
	<div class="col-8 text-center">
		<h3 class="text-truncate">Answers: <?php echo $this->question->description; ?></h3>
	</div>
	<div class="col">
		<a class="btn float-end" href="<?php echo
            Uri::getInstance()->current()
            . '?task=Display.display';
        ?>">Back to Quizzes</a>
	</div>
</div>

<hr/>

<div class="row">
    <div class="col pe-5">
        <form 
            action="<?php echo Uri::getInstance()->current() . ($this->answer ? '?task=Form.updateAnswer' : '?task=Form.saveAnswer'); ?>"
            method="post"
            id="adminForm"
            name="adminForm"
            enctype="multipart/form-data"
        >
            <input type="hidden" name="questionId" value="<?php echo $this->question->id; ?>"/>
            <?php if ($this->answer): ?>
                <input type="hidden" name="answerId" value="<?php echo $this->answer->id; ?>"/>
            <?php endif; ?>
            <!-- Description -->
            <div class="form-group">
                <label for="description">Answer text: *</label>

                <textarea 
                    type="text"
                    name="description"
                    class="form-control"
                    placeholder="Enter answer text..."
                    maxlength="200"
                    required
                    rows="3"
                ><?php if ($this->answer) echo $this->answer->description; ?></textarea>
            </div>

            <hr/>
            <!-- Mark value -->
            <div class="form-group">
                <label data-toggle="tooltip" for="markValue">Marks: *</label>

                <input
                    type="number"
                    name="markValue"
                    class="form-control"
                    placeholder="How many marks is this answer worth?"
                    required
                    min="-100"
                    max="100"
                    value="<?php if ($this->answer) echo $this->answer->markValue; ?>"
                />
            </div>

            <hr/>

            <div class="form-group">
                <button class="btn">
                    <?php if ($this->answer): ?>
                        <i class="icon-check"></i> Save
                    <?php else: ?>
                        <i class="icon-plus"></i> Add
                    <?php endif; ?>
                </button>
                <?php if ($this->answer): ?>
                    <a class="btn float-end" href="<?php echo 
                        Uri::getInstance()->current()
                        . '?task=Display.answerForm&questionId=' . $this->question->id;
                    ?>">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    <!-- Answers -->
    <div id="answers" class="col pt-4 fixed-height-2">
        <?php if ($this->items): ?>
            <?php foreach ($this->items as $row) : ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="pb-1"><?php echo $row->description; ?></h5>
                            </div>
                        </div>
                        <div class="row d-flex">
                            <!-- Correct -->

                            <div class="col my-auto">
                                Marks: <?php echo $row->markValue; ?>
                            </div>
                            
                            <!-- Buttons -->
                            <div class="col-auto">
                                <a class="btn" href="<?php echo
                                    Uri::getInstance()->current()
                                    . '?task=Display.answerForm&questionId=' . $this->question->id
                                    . '&answerId=' . $row->id;
                                ?>"><i class="icon-pencil"></i> Edit</a>

                                <button id="<?php echo $row->id; ?>" class="delete-button btn"><i class="icon-delete"></i> Delete</button> 
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center pt-5">There are currently no answers for this question</p>
        <?php endif; ?>
    </div>
</div>

<!-- Delete confirmation -->
<div id="delete-confirmation" class="d-none">
	<form
		action="<?php echo Uri::getInstance()->current() . '?task=Form.deleteAnswer'; ?>"
		method="post"
		enctype="multipart/form-data"
	>
		<input type="hidden" name="questionId" value="<?php echo $this->question->id; ?>"/>
		<input type="hidden" name="answerId"/>

		<div class="overlay-background d-flex">
			<div class="m-auto text-center">
				<h5 class="mb-4"><!-- Message --></h5>
				<button id="delete-confirm" class="btn me-3">Yes, remove it</button>
				<button id="delete-cancel" class="btn ms-3">No, go back</button> 
			</div>
		</div>
	</form>
</div>