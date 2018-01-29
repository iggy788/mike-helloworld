<?php
/**
 * Class Helloworld_Model_Example
 *
 * Model for HelloWorld Controller
 * Performs all of the "logic" of our application
 *
 * @author: djdavis
*/
class Helloworld_Model_Example extends Application_Model_CommonModel
{
    /**
     * @var string
     */
    private $name = '';
    /**
     * @var int
     */
    private $json = 0;
    /**
     * @var string
     */
    private $response = '';
    /**
     * Helloworld_Model_Example constructor.
     * Sets the name and json value
     * @param $name
     * @param $json
     */
    public function __construct($name, $json)
    {
        parent::__construct();
        $this->name = ucfirst(strtolower($name));
        $this->json = $json;
        $this->setResponse();
    }
    /**
     * Perform logic on the value of "name"
     * @return bool
     */
    private function setResponse() {
        switch ($this->name) {
            case "Kevin":
                $response = ", have a great day!";
            break;
            case "Mike":
                $response = ", this is a basic MVC example.";
            break;
            case "Paul":
                $response = ", the weather is cold today.";
            break;
            case "Darius":
                $response = ", I like returning responses.";
            break;
            default:
                $response = "World, MVC is beautiful! Try using names in the name parameter.";
            break;
        }
        $this->response = "Hello " . $this->name . $response;
        return true;
    }
    /**
     * Return response back to controller
     * @return mixed
     */
    public function getResponse() {
        // If JSON was set to 1, return our response as a
        // JSON formatted string.
        if ($this->json === "1") {
            $this->getResponseJson();
        } else {
            return $this->response;
        }
    }
    /**
     * Return response back to controller, as JSON
     * @return string
     */
    public function getResponseJson() {
        return json_encode(array('response' => $this->response));
    }
}