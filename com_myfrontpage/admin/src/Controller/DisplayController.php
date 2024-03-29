<?php

namespace Kieran\Component\MyFrontPage\Administrator\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;

/**
 * @package     Joomla.Administrator
 * @subpackage  com_myImageViewer
 */


class DisplayController extends BaseController {

    
    public function display($cachable = false, $urlparams = array()) {

        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('AdminFrontPageView', $viewFormat);

        $view->document = $document;
        $view->display();

    }
    
}