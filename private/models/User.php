<?php

/**
 * User Model
 */
class User extends Model
{

    protected $allowedColumns = [
        'firstname',
        'lastname',
        'email',
        'password',
        'gender',
        'rank',
        'date',
    ];

    protected $beforeInsert = [
        'make_user_id',
        'make_school_id',
        'hash_password'
    ];


    public function validate($DATA)
    {
        $this->errors = [];

        //check for first name
        if (empty($DATA['firstname']) || !preg_match('/^[a-zA-Z]+$/', $DATA['firstname'])) {
            $this->errors['firstname'] = "Only letters allowed in first name";
        }

        //check for last name
        if (empty($DATA['lastname']) || !preg_match('/^[a-zA-Z]+$/', $DATA['lastname'])) {
            $this->errors['lastname'] = "Only letters allowed in last name";
        }

        //check for email
        if (empty($DATA['email']) || !filter_var($DATA['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email is not valid";
        }

        //check if email exists
        if ($this->findOne('email', $DATA['email'])) {
            $this->errors['email'] = "That email is already in use";
        }


        //check for gender
        $genders = ['female', 'male'];
        if (empty($DATA['gender']) || !in_array($DATA['gender'], $genders)) {
            $this->errors['gender'] = "Gender is not valid";
        }

        //check for rank
        $ranks = ['student', 'reception', 'lecturer', 'admin', 'super_admin'];
        if (empty($DATA['rank']) || !in_array($DATA['rank'], $ranks)) {
            $this->errors['rank'] = "Rank is not valid";
        }

        // Check for password strength (at least 8 characters, 1 letter, 1 number)
        if (empty($DATA['password']) || strlen($DATA['password']) < 8) {
            $this->errors['password'] = "Password must be at least 8 characters long";
        } elseif (!preg_match('/[a-zA-Z]/', $DATA['password'])) {
            $this->errors['password'] = "Password must contain at least one letter";
        } elseif (!preg_match('/[0-9]/', $DATA['password'])) {
            $this->errors['password'] = "Password must contain at least one number";
        }

        //check for password
        if (empty($DATA['password']) || $DATA['password'] !== $DATA['password2']) {
            $this->errors['password'] = "Passwords do not match";
        }


        if (count($this->errors) == 0) {
            return true;
        }

        return false;
    }


    /**
     * Generate a unique user ID before inserting a new user
     * @param array $data - The user data to be inserted
     * @return array - Modified data with the generated user_id
     */
    public function make_user_id($data)
    {
        $data['user_id'] = random_string(60); // Generates a random string of 60 characters
        return $data;
    }

    /**
     * Assign the school ID to the user before inserting
     * @param array $data - The user data to be inserted
     * @return array - Modified data with the school_id from the session
     */
    public function make_school_id($data)
    {
        if (isset($_SESSION['USER']->school_id)) {
            $data['school_id'] = $_SESSION['USER']->school_id; // Retrieve the school ID from the session
        }
        return $data;
    }

    /**
     * Hash the user's password before inserting into the database
     * @param array $data - The user data to be inserted
     * @return array - Modified data with the hashed password
     */
    public function hash_password($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT); // Hash the password using bcrypt
        return $data;
    }
}
