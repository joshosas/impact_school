<?php

/**
 * Schools Controller
 * Handles requests for listing, adding, editing, and deleting schools.
 */
class Schools extends Controller
{
    // Displays a list of all schools
    public function index()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login'); // Ensure user is logged in
        }

        $school = new School();
        $data = $school->findAll(); // Fetch all schools

        $crumbs[] = ['Dashboard', '']; // Breadcrumb navigation
        $crumbs[] = ['Schools', 'schools'];

        $this->view('schools/school', [
            'crumbs' => $crumbs,
            'rows' => $data // Pass school data to the view
        ]);
    }

    // Handles adding a new school
    public function add()
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $errors = [];
        if (count($_POST) > 0) { // Check if form data is submitted

            $school = new School();
            if ($school->validate($_POST)) { // Validate school data
                $_POST['date'] = date("Y-m-d H:i:s"); // Add timestamp
                $school->insert($_POST); // Insert into database
                $this->redirect('schools'); // Redirect to the list of schools
            } else {
                $errors = $school->errors; // Capture validation errors
            }
        }

        // Breadcrumb navigation for adding a school
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Schools', 'schools'];
        $crumbs[] = ['Add', 'schools/add'];

        // Render the add school view
        $this->view('schools/add_school', [
            'errors' => $errors,
            'crumbs' => $crumbs,
        ]);
    }

    // Handles editing an existing school
    public function edit($id = null)
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $school = new School();
        $errors = [];

        if (count($_POST) > 0) {
            if ($school->validate($_POST)) {
                $school->update($id, $_POST); // Update school data
                $this->redirect('schools');
            } else {
                $errors = $school->errors; // Capture validation errors
            }
        }

        $row = $school->findOne('id', $id); // Fetch the school record

        // Breadcrumb navigation for editing a school
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Schools', 'schools'];
        $crumbs[] = ['Edit', 'schools/edit'];

        // Render the edit school view
        $this->view('schools/edit_school', [
            'row' => $row,
            'errors' => $errors,
            'crumbs' => $crumbs,
        ]);
    }

    // Handles deleting a school
    public function delete($id = null)
    {
        if (!Auth::logged_in()) {
            $this->redirect('login');
        }

        $school = new School();
        $errors = [];

        if (count($_POST) > 0) {
            $school->delete($id); // Delete school record
            $this->redirect('schools');
        }

        $row = $school->findOne('id', $id); // Fetch the school record

        // Breadcrumb navigation for deleting a school
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Schools', 'schools'];
        $crumbs[] = ['Delete', 'schools/delete'];

        // Render the delete school view
        $this->view('schools/delete_school', [
            'row' => $row,
            'crumbs' => $crumbs,
        ]);
    }
}
