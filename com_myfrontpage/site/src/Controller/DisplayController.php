<?php

namespace Kieran\Component\MyFrontPage\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myFrontPage
 */

class DisplayController extends BaseController {

    public function display($cachable = false, $urlparams = array()) {     
        $document = Factory::getDocument();
        $viewFormat = $document->getType();

        $view = $this->getView('FrontPageView', $viewFormat);   

        $view->document = $document;
        $view->display();
    }

}