<?php

/**
 * Students Controller: Handles requests for the students page
 */
class Students extends Controller
{
    function index()
    {
        // Calls the "students" view, which displays the students page
        echo $this->view("students");
    }
}
