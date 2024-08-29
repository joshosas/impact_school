<?php

/**
 * login controller
 */
class Signup extends Controller
{

    function index()
    {
        // code...
        $errors = [];
        if (count($_POST) > 0) {

            $user = new User();

            if ($user->validate($_POST)) {

                // $data['firstname'] = $_POST['firstname'];
                // $data['lastname'] = $_POST['lastname'];
                // $data['gender'] = $_POST['gender'];
                // $data['rank'] = $_POST['rank'];
                // $data['password'] = $_POST['password'];
                $_POST['date'] = date("Y-m-d H:i:s");

                $user->insert($_POST);
                $this->redirect('login');
            } else {
                //errors
                $errors = $user->errors;
            }
        }

        $this->view('auth/signup', [
            'errors' => $errors,
        ]);
    }
}
