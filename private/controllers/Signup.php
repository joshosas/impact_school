<?php

/**
 * Signup controller
 */
class Signup extends Controller
{
    // Main function handling the signup process
    public function index()
    {
        // Initialize an empty array to hold any validation errors
        $errors = [];
        $mode = isset($_GET['mode']) ? $_GET['mode'] : '';

        // Check if form data has been submitted (i.e., if there are POST values)
        if (count($_POST) > 0) {

            // Create a new instance of the User model
            $user = new User();

            // Validate the submitted form data
            if ($user->validate($_POST)) {

                // Add the current timestamp to the data
                $_POST['date'] = date("Y-m-d H:i:s");

                // Insert the validated data into the database
                $user->insert($_POST);

                // Redirect to the login students or staff page after successful signup
                $mode == 'students' ? $this->redirect('students') : $this->redirect('users');
            } else {
                // If validation fails, capture the errors
                $errors = $user->errors;
            }
        }

        // Render the signup view and pass any validation errors to the view
        $this->view('auth/signup', [
            'errors' => $errors,
            'mode' => $mode
        ]);
    }
}
