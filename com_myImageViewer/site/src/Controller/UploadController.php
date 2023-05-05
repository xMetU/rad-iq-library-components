<?php

namespace Kieran\Component\MyImageViewer\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_myImageViewer
 *
 */

class UploadController extends BaseController {
    
    function upload() {
        echo "upload";
        Factory::getApplication()->enqueueMessage("upload");
    }


    public function display($cachable = false, $urlparams = array()) {     
        
        echo "this is the site controller";

        $document = Factory::getDocument();
        // $viewName = $this->input->getCmd('view', 'login');
        $viewFormat = $document->getType();

        $view = $this->getView('UploadImageView', $viewFormat);
        $view->setModel($this->getModel('UploadImage'), true);

        $view->document = $document;
        $view->display();
    }

    
}