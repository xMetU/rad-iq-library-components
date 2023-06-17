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
$document->addScript("media/com_myquiz/js/quizFormView.js");
$document->addStyleSheet("media/com_myquiz/css/style.css");

?>

<!-- QUIZ FORM VIEW -->

<!-- Header -->
<div class="row">
	<div class="col">
		<a class="btn" href="<?php echo Uri::getInstance()->current(); ?>">Back</a>
	</div>
	<div class="col-8 text-center">
        <h3><?php echo ($this->isEdit ? "Edit " . $this->quizTitle : "Create New Quiz"); ?></h3>
	</div>
	<div class="col">
        <?php if ($this->isEdit): ?>
            <a
                class="btn float-end"
                href="<?php echo Uri::getInstance()->current() . '?task=Display.questionForm&quizId=' . $this->quiz->id; ?>"
            >Questions</a>
        <?php endif; ?>
    </div>
</div>

<hr/>

<div class="row justify-content-center">
    <div class="col-8">
        <form 
            action="<?php echo Uri::getInstance()->current() . ($this->isEdit ? '?task=Form.updateQuiz' : '?task=Form.saveQuiz'); ?>"
            method="post"
            id="adminForm"
            name="adminForm"
            enctype="multipart/form-data"
        >
            <?php if ($this->isEdit) : ?>
				<input type="hidden" name="quizId" value="<?php echo $this->quiz->id; ?>"/>
			<?php endif; ?>

            <div class="form-group">
                <label for="title">Title: *</label>

                <input 
                    type="text"
                    name="title"
                    class="form-control"
                    placeholder="Enter title..."
                    maxlength="60"
                    required
                    value="<?php if (isset($this->quiz->title)) echo $this->quiz->title; ?>"
                />
            </div>

            <hr/>

            <div class="row">
                <div class="col">
                    <label for="imageId">Image: *</label>
                    <select name="imageId"  placeholder="Select quiz image..." class="form-control form-select" required>
                        <option value="" <?php if (!isset($this->quiz->imageId)) echo "selected"; ?>disabled hidden>Select an image</option>
                        <?php foreach ($this->images as $row) : ?>
                            <option
                                value="<?php echo $row->id; ?>"
                                <?php if (isset($this->quiz->imageId) && $row->id == $this->quiz->imageId) echo "selected"; ?>
                            ><?php echo $row->imageName; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col">
                    <label for="attemptsAllowed">Attempts Allowed: *</label>

                    <input
                        type="number"
                        name="attemptsAllowed"
                        class="form-control"
                        placeholder="Enter number of attempts allowed..."
                        required
                        min="1"
                        max="1000"
                        value="<?php if (isset($this->quiz->attemptsAllowed)) echo $this->quiz->attemptsAllowed; ?>"
                    />
                </div>
            </div>

            <hr/>

            <div class="form-group">
                <label for="description">Description:</label>

                <textarea
                    name="description"
                    class="form-control"
                    placeholder="Enter description..."
                    maxlength="200"
                    rows="4"
                ><?php if (isset($this->quiz->description)) echo $this->quiz->description; ?></textarea>
            </div>

            <hr/>

            <div class="row form-group">
                <div class="col">
                    <button class="btn"><i class="icon-check"></i> Done</button>
                </div>
                <?php if (!$this->quiz): ?>
                    <div class="col-auto d-flex">
                        <p class="my-auto"><i>New quizzes are hidden by default</i></p>
                    </div>

                    <div class="col"></div>
                <?php endif; ?>
			</div>
        </form>
    </div>
</div>
