<?php

/**
 * login controller
 */
class Login extends Controller
{

    function index()
    {
        // code...
        $errors = [];

        if (count($_POST) > 0) {

            $user = new User();
            if ($row = $user->findOne('email', $_POST['email'])) {
                $row = $row[0];
                if (password_verify($_POST['password'], $row->password)) {
                    Auth::authenticate($row);
                    $this->redirect('/home');
                }
            }

            $errors['email'] = "Wrong email or password";
        }

        $this->view('auth/login', [
            'errors' => $errors,
        ]);
    }
}
