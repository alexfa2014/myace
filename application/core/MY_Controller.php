<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 登录后公用操作
 */
class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->checkAuth();
    }

    private function checkAuth()
    {
        if(!$_SESSION['userid'] > 0)
        {
            redirect('/common/auth/loginout', 'location');
        }
    }
}