<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 后台首页
 */
class Index extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('common/header');
        $this->load->view('common/menu');
        $this->load->view('index/index');
        $this->load->view('common/footer');
    }

}