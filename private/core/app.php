<?php

// Main application file
class App
{
    // Default controller, method, and parameters
    protected $controller = "home";
    protected $method = "index";
    protected $params = array();

    public function __construct()
    {


        // Get the URL components
        $URL = $this->getURL();

        // Check if the controller file exists
        if (file_exists("../private/controllers/" . $URL[0] . ".php")) {
            // Set the controller if it exists and capitalize the first letter
            $this->controller = ucfirst($URL[0]);
            // Remove the controller from the URL array
            unset($URL[0]);
        }

        // Include the controller file
        require "../private/controllers/" . $this->controller . ".php";

        // Instantiate the controller class
        $this->controller = new $this->controller();

        // Check if a method is provided in the URL and if it exists in the controller
        if (isset($URL[1]) && method_exists($this->controller, $URL[1])) {
            // Set the method if it exists
            $this->method = $URL[1];
            // Remove the method from the URL array
            unset($URL[1]);
        }

        // Reindex the URL array and store any remaining elements as parameters
        $URL = array_values($URL);
        $this->params = $URL;

        // Call the controller's method with the provided parameters
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Parse the URL into an array of components
    private function getURL()
    {
        // Retrieve the 'url' parameter from the GET request, defaulting to "home"
        $url = isset($_GET['url']) ? $_GET['url'] : "home";

        // Sanitize and split the URL into an array
        $filtered_url = filter_var(trim($url, "/"), FILTER_SANITIZE_URL);
        return explode("/", $filtered_url);
    }
}
