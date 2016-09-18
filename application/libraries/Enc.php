<?php

class Enc {
    private $CI;
    private $salt;

    public function __construct()
    {
        $this->CI = & get_instance();
        $this->salt = $this->CI->config->item('salt');
    }

    public function encPassword($password)
    {
        if(empty($password))
        {
            return '';
        }

        return $this->salt.md5(crypt($password,substr($password,0,2)));
    }
}