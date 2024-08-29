<?php

/**
 * Profile controller
 */
class Profile extends Controller
{

    function index()
    {
        // code...
        $this->view('auth/profile');
    }
}
