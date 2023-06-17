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
$document->addScript("media/com_myquiz/js/questionFormView.js");
$document->addStyleSheet("media/com_myquiz/css/style.css");

?>

<!-- QUESTION FORM VIEW -->

<!-- Header -->
<div class="row">
	<div class="col">
		<a class="btn"
            href="<?php echo Uri::getInstance()->current() . '?task=Display.quizForm&quizId=' . $this->quiz->id; ?>"
        >Back</a>
	</div>
	<div class="col-auto text-center">
		<h3>Questions: <?php echo $this->quiz->title; ?></h3>
	</div>
    <div class="col">
        <a class="btn float-end"
                href="<?php echo Uri::getInstance()->current() . '?task=Display.display'; ?>"
            >Back to Quizzes</a>
    </div>
	
</div>

<hr/>

<div class="row">
    <!-- Form -->
    <div class="col pe-5">
        <form 
            action="<?php echo Uri::getInstance()->current() . ($this->question ? '?task=Form.updateQuestion' : '?task=Form.saveQuestion'); ?>"
            method="post"
            enctype="multipart/form-data"
        >
            <input type="hidden" name="quizId" value="<?php echo $this->quiz->id; ?>"/>
            <?php if ($this->question): ?>
                <input type="hidden" name="questionId" value="<?php echo $this->question->id; ?>"/>
            <?php endif; ?>
            
            <!-- Description -->
            <div class="form-group">
                <label for="description">Question: *</label>

                <textarea
                    name="description"
                    class="form-control"
                    placeholder="What is the question?"
                    maxlength="200"
                    required
                    rows="3"
                ><?php if ($this->question) echo $this->question->description; ?></textarea>
            </div>

            <hr/>
            
            <!-- Feedback -->
            <div class="form-group">
                <label for="feedback">Feedback:</label>

                <textarea
                    name="feedback"
                    class="form-control"
                    placeholder="Feedback when the question is answered."
                    maxlength="200"
                    rows="3"
                ><?php if ($this->question) echo $this->question->feedback; ?></textarea>
            </div>

            <hr/>
            <!-- Submit button -->
            <div class="form-group">
                <button class="btn">
                    <?php if ($this->question): ?>
                        <i class="icon-check"></i> Save
                    <?php else: ?>
                        <i class="icon-plus"></i> Add
                    <?php endif; ?>
                </button>
                <?php if ($this->question): ?>
                    <a class="btn float-end" href="<?php echo 
                        Uri::getInstance()->current()
                        . '?task=Display.questionForm&quizId=' . $this->quiz->id;
                    ?>">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    <!-- Questions -->
    <div id="questions" class="col pt-4 fixed-height-2">
        <?php if ($this->items): ?>
            <?php foreach ($this->items as $row) : ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <!-- Info -->
                        <div class="row">
                            <div class="col">
                                <h5 class="pb-1"><?php echo $row->description; ?></h5>
                                <p><?php echo $row->feedback; ?></p>
                            </div>
                        </div>
                        <!-- Buttons -->
                        <div class="row">
                            <div class="col">
                                <a class="btn" href="<?php echo
                                    Uri::getInstance()->current()
                                    . '?task=Display.questionForm&quizId=' . $this->quiz->id
                                    . '&questionId=' . $row->id;
                                ?>"><i class="icon-pencil"></i> Edit</a>

                                <button id="<?php echo $row->id; ?>" class="delete-button btn"><i class="icon-delete"></i> Delete</button> 
                            </div>
                            
                            <div class="col-auto">
                                <a href="<?php echo
                                    Uri::getInstance()->current()
                                    . '?task=Display.answerForm&questionId=' . $row->id
                                ?>" class="btn"><?php echo 'Answers ' . '(' . $row->answerCount . ')'; ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center pt-5">There are currently no questions in this quiz</p>
        <?php endif; ?>
    </div>
</div>    

<!-- Delete confirmation -->
<div id="delete-confirmation" class="d-none">
	<form
		action="<?php echo Uri::getInstance()->current() . '?task=Form.deleteQuestion'; ?>"
		method="post"
		enctype="multipart/form-data"
	>
		<input type="hidden" name="quizId" value="<?php echo $this->quiz->id; ?>"/>
		<input type="hidden" name="questionId"/>

		<div class="overlay-background d-flex">
			<div class="m-auto text-center">
				<h5 class="mb-4"><!-- Message --></h5>
				<button id="delete-confirm" class="btn me-3">Yes, remove it</button>
				<button id="delete-cancel" class="btn ms-3">No, go back</button> 
			</div>
		</div>
	</form>
</div>
