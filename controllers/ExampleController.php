<?php
/**
 * Class Helloworld_ExampleController
 *
 * Sample MVC application to generate various
 * different responses based on input of GET "name" parameter
 *
 * Optionally receive JSON back
 *
 * Example usage:
 * ?name=paul
 * ?name=mike&json=1
 *
 * @author: djdavis
 */
class Helloworld_ExampleController extends Zend_Controller_Action
{
    /**
     * @var
     */
    private $logger;
    /**
     * @var
     */
    private $ini;
    /**
     * init function
     *
     * @access public
     */
    public function init()
    {
        // Setup module and render
        $module = $this->getRequest()->getModuleName();
        $this->_helper->viewRenderer->setNoRender(false);
        // Set ini
        $this->ini = new Zend_Config_Ini(APPLICATION_PATH . "/modules/"
            . $module . "/configs/" . $module . ".ini", APPLICATION_ENV);
        // Set logging
        $writer = new Zend_Log_Writer_Stream($this->ini->logpath . $module . ".log");
        $mainlog = new Zend_Log_Writer_Stream($this->ini->logpath . "global.log");
        $logger = new Application_Model_CustomLog($writer);
        $logger->addWriter($mainlog);
        Zend_Registry::set('logger', $logger);
        $this->logger = Zend_Registry::get('logger');
    }
    /**
     * indexAction
     */
    public function indexAction()
    {
        try {
            // Grab GET parameter "name"
            $name = $this->_getParam('name');
            // Grab GET parameter "json"
            $json = $this->_getParam('json');
            // Create "Example" object
            $exampleModel = new Helloworld_Model_Example($name, $json);
            // Get Response.
            $response = $exampleModel->getResponse();
            // Set response in Zend "view" property
            $this->view->message = $response;
        } catch (Exception $e) {
            // Log any exceptions
            $this->logger->err($e->getMessage());
            // Set error message in Zend "view" property"
            $this->view->message = $e->getMessage();
        }
    }
}
