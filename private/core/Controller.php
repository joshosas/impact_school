<?php

/**
 * Main controller class
 */
class Controller
{
    // Method to load views
    public function view($view, $data = array())
    {
        // Extract variables from the $data array for use in the view
        extract($data);

        // Check if the view file exists
        if (file_exists("../private/views/" . $view . ".view.php")) {
            // Return the content of the view file
            include "../private/views/" . $view . ".view.php";
        } else {
            // Return the 404 page if the view is not found
            include "../private/views/404.view.php";
        };
    }

    public function load_model($model)
    {

        if (file_exists("../private/models/" . ucfirst($model) . ".php")) {
            require("../private/models/" . ucfirst($model) . ".php");
            return $model = new $model();
        }

        return false;
    }

    public function redirect($link)
    {

        header("Location: " . ROOT . "/" . trim($link, "/"));
        die;
    }
}
