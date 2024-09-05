<?php

/**
 * School Model
 * This model handles the operations for the schools table such as validation, insertion, and retrieval of school records.
 */
class School extends Model
{

    protected $allowedColumns = [
        'school', // Allowed fields for insert and update queries
        'date',
    ];

    protected $beforeInsert = [
        'make_school_id', // Function to generate school ID before insert
        'make_user_id', // Function to associate the user ID before insert
    ];

    protected $afterSelect = [
        'get_user', // Function to fetch user details after selecting school records
    ];

    // Function to validate form data
    public function validate($DATA)
    {
        $this->errors = [];

        //check for school name, allowing letters and spaces
        if (empty($DATA['school']) || !preg_match('/^[a-zA-Z\s]+$/', $DATA['school'])) {
            $this->errors['school'] = "Only letters and spaces are allowed in school name";
        }

        // If no errors, return true
        if (count($this->errors) == 0) {
            return true;
        }

        return false;
    }

    // Function to set the user ID before inserting data
    public function make_user_id($data)
    {
        if (isset($_SESSION['USER']->user_id)) {
            $data['user_id'] = $_SESSION['USER']->user_id;
        }
        return $data;
    }

    // Function to generate a unique school ID before inserting data
    public function make_school_id($data)
    {
        $data['school_id'] = random_string(60); // Generates a random string of 60 characters
        return $data;
    }

    // Function to retrieve the user associated with the school
    public function get_user($data)
    {
        $user = new User(); // Creating a User object to fetch user data
        foreach ($data as $key => $row) {
            $result = $user->findOne('user_id', $row->user_id); // Finding user based on user ID
            $data[$key]->user = is_array($result) ? $result[0] : false; // Assigning user details to the school record
        }

        return $data;
    }
}
