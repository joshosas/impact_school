<?php

/**
 * Home Controller: Handles requests for the home page
 */
class Home extends Controller
{
    function index()
    {
        #code...
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $user = new User();

        $data = $user->findAll();
        $this->view("home", ['rows' => $data]);
    }
}
