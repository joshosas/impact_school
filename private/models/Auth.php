<?php

/**
 * Authentication class
 */
class Auth
{

    public static function authenticate($row)
    {
        // code...
        $_SESSION['USER'] = $row;
    }

    public static function logout()
    {
        // code...
        if (isset($_SESSION['USER'])) {
            unset($_SESSION['USER']);
        }
    }

    public static function logged_in()
    {
        // code...
        if (isset($_SESSION['USER'])) {
            return true;
        }

        return false;
    }

    public static function user()
    {
        // Check if the 'USER' session is set
        if (isset($_SESSION['USER'])) {
            // Return the 'firstname' property from the 'USER' session object
            return $_SESSION['USER']->firstname;
        }

        // Return false if the 'USER' session is not set
        return false;
    }


    public static function __callStatic($method, $params)
    {
        $prop = strtolower(str_replace("get", "", $method));

        if (isset($_SESSION['USER']->$prop)) {
            return $_SESSION['USER']->$prop;
        }

        return 'Unknown';
    }

    public static function switch_school($id)
    {
        if (isset($_SESSION['USER']) && $_SESSION['USER']->rank == 'super_admin') {
            $user = new User();
            $school = new School();

            if ($row = $school->findOne('id', $id)) {
                $row = $row[0];
                $arr['school_id'] = $row->school_id;

                $user->update($_SESSION['USER']->id, $arr);
                $_SESSION['USER']->school_id = $row->school_id;
                $_SESSION['USER']->school_name = $row->school;
            }

            return true;
        }

        return false;
    }
}
