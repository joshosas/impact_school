<?php

/**
 * Users controller
 */
class Users extends Controller
{
    function index()
    {
        // Ensure the user is logged in before allowing access to the users list
        if (!Auth::logged_in()) {
            $this->redirect('login'); // Redirect to the login page if not authenticated
        }

        $user = new User();
        $school_id = Auth::getSchool_id(); // Get the current user's school ID
        $data = $user->query("SELECT * FROM users WHERE school_id = :school_id", ['school_id' => $school_id]);

        // Render the view, passing the list of users as 'rows' data
        $this->view('auth/users', ['rows' => $data]);
    }
}
