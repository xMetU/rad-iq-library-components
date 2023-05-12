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

$document = Factory::getDocument();
$document->addScript("media/com_myimageviewer/js/focusImageView.js");
$document->addStyleSheet("media/com_myimageviewer/css/style.css");

?>

<!-- ========== FOCUS IMAGE VIEW ========== -->

<!-- Header -->
<div class="row mb-3">
	<div class="col">
		<a class="btn" href="<?php echo Uri::getInstance()->current(); ?>">Back</a>
        <button id="delete-button" class="btn float-end">Delete</button>
        <button id="edit-button" class="btn me-3 float-end">Edit</button>
	</div>
</div>

<!-- Main -->
<div class="row">
    <!-- Image -->
    <div class="col-6 position-relative">
        <a id="open-button" class="btn position-absolute m-2">Open</a>
        <img class="w-100 rounded" src="<?php echo $this->item->url; ?>"/>
    </div>

    <!-- Category, description -->
    <div id="img-description" class="col-6">
        <h2><?php echo $this->item->name; ?></h2>

        <h5>Category: <?php echo $this->item->category; ?></h5>

        <hr/>

        <p><?php echo $this->item->description; ?></p>
    </div>
</div>

<!-- Focused viewer -->
<div id="focused-img-view" class="overlay-background text-center d-none">
    <div class="h-100">
        <img id="focused-img" class="h-100" src="<?php echo $this->item->url; ?>"/>
    </div>
    <div id="controls-container" class="row fixed-top justify-content-center m-2">
        <div class="col"></div>

        <div id="controls" class="col-4 d-flex align-items-center rounded">
            <label class="px-2">Contrast: </label>
            <input type="range" min="20" max="420" id="contrast-input"/>
        </div>

        <div class="col">
            <button id="exit-button" class="btn float-end rounded-circle"><i class="icon-times icon-white"></i></button>
        </div>
    </div>
</div>

<!-- Delete confirmation -->
<form
    action="<?php echo Uri::getInstance()->current() . '?&task=Form.deleteImage' ?>"
    method="post"
    enctype="multipart/form-data"
>
    <input type="hidden" name="imageId" value="<?php echo $this->item->id; ?>"/>

    <input type="hidden" name="imageUrl" value="<?php echo $this->item->url; ?>">

    <div id="delete-confirmation" class="overlay-background d-flex d-none">
        <div class="m-auto justify-content-center">
            <div class="row mb-4 text-center">
                <h5>Are you sure you want to delete <?php echo $this->item->name; ?>?<br/>This action cannot be undone.</h5>
            </div>
            <div class="row">
                <div class="col">
                    <button id="delete-confirm" class="delete-yes btn float-end me-3">Yes, delete it</button>
                </div>
                <div class="col">
                    <button id="delete-cancel" class="btn ms-3">No, go back</button>
                </div>
            </div>
        </div>
    </div>
</form>