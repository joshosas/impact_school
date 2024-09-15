<?php

/**
 * Profile controller
 */
class Profile extends Controller
{

    function index($id = '')
    {
        // set mode
        $mode = isset($_GET['mode']) ? $_GET['mode'] : '';
        // code...
        $user = new User();
        $row = $user->first('user_id', $id);

        $crumbs[] = ['Dashboard', '']; // Breadcrumb navigation
        $row->rank == 'student' ? $crumbs[] = ['Students', 'students'] : $crumbs[] = ['Staff', 'users'];
        if ($row) {
            $crumbs[] = [$row->firstname, 'profile'];
        }

        $this->view('auth/profile', [
            'row' => $row,
            'crumbs' => $crumbs
        ]);
    }
}
