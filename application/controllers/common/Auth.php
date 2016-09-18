<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * @property Auth_model $Auth_model
 * @property User_model $User_model
 */

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common/Auth_model');
        $this->load->model('system/User_model');
    }

    public function login()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $errorArr = array();
            if($this->input->get('error') == 1)
            {
                $errorArr['usernameErr'] = 1;
            }
            $this->load->view('common/login',$errorArr);
        }
        else
        {
            $this->load->library('enc');
            $data = $this->input->post(NULL, TRUE);
            $data['password'] = $this->enc->encPassword($data['password']);
            $info = $this->Auth_model->get_info($data);
            if (!empty($info))
            {
                $data_detail['userid'] = $info[0]['id'];
                $info_detail = $this->User_model->get_info($data_detail);
                $sessionData = array(
                    'userid' => $info[0]['id'],
                    'uesrname' => $info[0]['username'],
                    'email' => $info[0]['email'],
                    'avatar' => $info_detail[0]['avatar']
                );
                $this->session->set_userdata($sessionData);
                redirect('/index/index/index', 'location');
            }
            else
            {
                redirect('/common/auth/login?error=1', 'refresh');
            }
        }
    }

    public function loginout()
    {
        session_destroy();
        redirect('/common/auth/login', 'location');
    }
}