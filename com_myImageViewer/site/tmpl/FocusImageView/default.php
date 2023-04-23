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

<!-- Back Button -->
<div class="row">
    <div class="col-3">
        <a class="btn" href="<?php echo Uri::getInstance()->current() . '?&task=Display.display' ?>">Back</a>
    </div>
</div>

<hr/>

<!-- Main -->
<div class="row">
    <!-- Image -->
    <div class="col-8">
        <img 
            id="img-view"
            class="w-100"
            src="<?php echo $this->item->url; ?>"
        />
    </div>

    <!-- Name, category, description -->
    <div id="img-description" class="col-4">
        <h2><?php echo $this->item->name; ?></h2>

        <h5>Category: <?php echo $this->item->category; ?></h5>

        <hr/>

        <p><?php echo $this->item->description; ?></p>
    </div>
</div>

<!-- Focused viewer -->
<div id="focused-img-view" class="text-center d-none">
    <div class="h-100">
        <img id="focused-img" class="h-100" src="<?php echo $this->item->url; ?>"/>
    </div>
    <div id="controls" class="row fixed-top justify-content-center">
        <div class="col"></div>

        <div class="col-4 bg-dark d-flex align-items-center rounded-bottom">
            <label class="px-2">Contrast: </label>
            <input type="range" min="20" max="300" id="contrast-input"/>
        </div>

        <div class="col">
            <button id="exit-button" class="btn float-end rounded-circle m-2">X</button>
        </div>
    </div>
</div> 