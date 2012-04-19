<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		$page = $this->getRequest()->getParam('page');
		$flickrApp = new Application_Model_Flickr();
		$view = Zend_Layout::getMvcInstance()->getView();
		$view->result = $flickrApp->setPageNumber($page)->start()->getResponse();
    }


}

