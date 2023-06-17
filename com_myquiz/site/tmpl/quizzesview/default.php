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
use Kieran\Component\MyQuiz\Site\Helper\CheckGroup;

$document = Factory::getDocument();
$document->addScript("media/com_myquiz/js/quizzesView.js");
$document->addStyleSheet("media/com_myquiz/css/style.css");

?>

<!-- QUIZZES VIEW -->

<!-- Headers -->
<div class="row">
    <div class="col">
        <?php if (CheckGroup::isGroup("Manager")) : ?>
            <!-- Manage categories button -->
            <a class="btn" href="index.php/image-viewers?task=Display.categoryForm">Manage Categories</a>
        <?php endif; ?>
    </div>

    <div class="col-auto"><h3>Quizzes</h3></div>

    <div class="col">
        <?php if (CheckGroup::isGroup("Manager")) : ?>
            <!-- New quiz button -->
            <a 
                class="btn float-end" 
                href="<?php echo Uri::getInstance()->current() . '?task=Display.quizForm'; ?>">
                <i class="icon-plus"></i> New Quiz
            </a>
        <?php endif; ?>
    </div>
</div>

<hr/>

<div class="row pb-3">

    <div class="col-2 text-center my-auto">
        <h6>Filter by Category</h6>
    </div>

	<div class="col-10 ps-5">
        <div class="row">
            <div class="col"></div>

            <div class="col-6">
                <!-- Searchbar -->
                <form
                    action="<?php echo Uri::getInstance()->current(); ?>"
                    method="get"
                    enctype="multipart/form-data"
                >
                    <?php if ($this->category): ?>
						<input type="hidden" name="category" value="<?php echo $this->category; ?>">
					<?php endif; ?>
                    <?php if ($this->subcategory): ?>
						<input type="hidden" name="subcategory" value="<?php echo $this->subcategory; ?>">
					<?php endif; ?>
                    <div class="input-group">
                        <input
                            name="search"
                            id="text"
                            class="form-control"
                            placeholder="Search..."
                            value="<?php if ($this->search) echo $this->search; ?>"
                        />
                        <button type="submit" class="btn"><i class="icon-search"></i></button>
                    </div>
                </form>
            </div>

            <div class="col">
                <a 
                    class="btn float-end"
                    href="<?php echo Uri::getInstance()->current() . '?task=Display.scores'; ?>"
                >View Scores</a>
            </div>
        </div>
	</div>
</div>

<div class="row">
    <!-- Categories -->
	<div class="col-2 fixed-height-1">
		<table id="categories" class="w-100">
			<tbody>
				<?php if (!empty($this->categories)) : ?>
					<?php foreach ($this->categories as $row) : ?>
						<tr>
							<td class="pb-3">
								<a
									class="btn py-1 text-center w-100<?php if ($row->categoryId == $this->category) echo " active"; ?>"
									href="<?php echo Uri::getInstance()->current()
										. ($row->categoryId == $this->category ? "" : '?category='. $row->categoryId)
									?>"
								>
									<?php echo $row->categoryName . ' (' . $row->count . ')'; ?>
								</a>
							</td>
						</tr>

						<?php foreach ($this->subcategories as $subrow) : ?>
                            <tr>
                                <?php if ($subrow->categoryId == $row->categoryId) : ?>
                                    <?php if ($row->categoryId == $this->category) : ?>
                                        <td class="pb-3 ps-4">
                                            <a
                                                class="btn py-1 text-center w-100<?php if ($subrow->subcategoryId == $this->subcategory) echo " active"; ?>"
                                                href="<?php echo Uri::getInstance()->current() . '?category=' . $this->category
                                                    . ($subrow->subcategoryId == $this->subcategory ? "" : '&subcategory=' . $subrow->subcategoryId)
                                                ?>"
                                            >
                                                <?php echo $subrow->subcategoryName . ' (' . $subrow->count . ')'; ?>							
                                            </a>									
                                        </td>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </tr>
						<?php endforeach; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

    <!-- Quizzes -->
    <div class="col-10 ps-5 fixed-height-1">
        <table id="quizzes" class="table table-borderless">
            <tfoot>
                <tr>
                    <td class="d-flex justify-content-center p-2">
                        <?php echo $this->pagination->getListFooter(); ?>
                    </td>
                </tr>
            </tfoot>

            <tbody>
                <tr class="row">
                    <?php if (!empty($this->items)): ?>
                        <?php foreach ($this->items as $row) : ?>
                            <?php $render = CheckGroup::isGroup("Manager") ? true : !$row->isHidden; ?>
                            <?php if ($render): ?>
                                <td class="col-12 pt-0 pb-4">
                                    <div class="card p-3">
                                        <div class="row">
                                            <!-- Image -->
                                            <div class="col-3">
                                                <img
                                                    class="card-img-top"
                                                    src="<?php echo $row->imageUrl . '.thumb'; ?>"
                                                />
                                            </div>
                                            <!-- Info -->
                                            <div class="col">
                                                <h5><?php echo $row->title; ?></h5>
                                                <p><?php echo $row->description; ?></p>
                                                <p><?php echo $row->questionCount; ?> Question(s) </p>
                                                <a class="btn" href="<?php echo
                                                    Uri::getInstance()->current()
                                                    . '?task=Quiz.startQuiz&quizId=' . $row->id
                                                    . '&questionId=' . $row->firstQuestionId
                                                    . '&attemptsAllowed=' . $row->attemptsAllowed;
                                                ?>">Attempt Quiz (<?php if ($this->userId) echo $row->attemptsRemaining; ?> remaining)</a>
                                            </div>
                                            
                                            <?php if (CheckGroup::isGroup("Manager")): ?>
                                                <!-- Manager Buttons -->
                                                <div class="col-auto d-flex flex-column">
                                                    <a
                                                        class="btn"
                                                        href="<?php echo Uri::getInstance()->current() . '?task=Display.toggleIsHidden&id=' . $row->id; ?>"
                                                    >
                                                        <?php if($row->isHidden): ?>
                                                            <i class="icon-eye-open"></i> Show
                                                        <?php else: ?>
                                                            <i class="icon-eye-close"></i> Hide
                                                        <?php endif; ?>
                                                    </a>
                                                    <a
                                                        class="btn mt-2"
                                                        href="<?php echo Uri::getInstance()->current() . '?task=Display.quizForm&quizId=' . $row->id; ?>"
                                                    ><i class="icon-pencil"></i> Edit</a>
                                                    <button id="<?php echo $row->id; ?>" class="delete-button btn mt-2"><i class="icon-delete"></i> Delete</button> 
                                                </div>
                                                <?php if ($row->isHidden) : ?>
                                                    <div class="card-overlay d-flex">
                                                        <h5 class="m-auto">Hidden</h5>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>	
                                    </div>
                                </td>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <td>
                            <?php if ($this->category): ?>
                                <p class="text-center pt-5">No quizzes are assigned to this category</p>
                            <?php else: ?>
                                <p class="text-center pt-5">Could not find any matching quizzes</p>
                            <?php endif; ?>							
                        </td>
                    <?php endif; ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php if (CheckGroup::isGroup("Manager")) : ?>
    <!-- Delete confirmation -->
    <div id="delete-confirmation" class="d-none">
        <form
            action="<?php echo Uri::getInstance()->current() . '?task=Form.deleteQuiz'; ?>"
            method="post"
            enctype="multipart/form-data"
        >
            <input type="hidden" name="quizId"/>

            <div class="overlay-background d-flex">
                <div class="m-auto text-center">
                    <h5 class="mb-4"><!-- Message --></h5>
                    <button id="delete-confirm" class="btn me-3">Yes, remove it</button>
                    <button id="delete-cancel" class="btn ms-3">No, go back</button> 
                </div>
            </div>
        </form>
    </div>
<?php endif; ?>
