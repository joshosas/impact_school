<?php

/**
 * Profile controller
 */
class Profile extends Controller
{

    function index($id = '')
    {
        // code...
        $user = new User();
        $row = $user->first('user_id', $id);

        $crumbs[] = ['Dashboard', '']; // Breadcrumb navigation
        $crumbs[] = ['Staff', 'users'];
        if ($row) {
            $crumbs[] = [$row->firstname, 'profile'];
        }

        $this->view('auth/profile', [
            'row' => $row,
            'crumbs' => $crumbs
        ]);
    }
}
