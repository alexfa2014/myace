<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 用户管理
 * @property Auth_model $Auth_model
 * @property User_model $User_model
 */
class User extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('common/Auth_model');
        $this->load->model('system/User_model');
    }

    public function userIndex()
    {
        $where = array('status' => 0);
        $data['info'] = $this->Auth_model->get_info($where);

        $this->load->view('common/header');
        $this->load->view('common/menu');
        $this->load->view('system/user_index',$data);
        $this->load->view('common/footer');
    }

    public function userAdd()
    {
        $this->load->view('system/user_add');
    }

    public function userAddDo()
    {
        $info = array('status' => 0, 'msg' => '添加失败！');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[1]|max_length[20]|is_unique[user.username]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]');

        if ($this->form_validation->run() == FALSE)
        {
            $info['msg'] = validation_errors();
        }
        else
        {
            $data = $this->input->post(NULL, TRUE);
            $this->load->library('enc');
            $data['password'] = $this->enc->encPassword(config_item('default_password'));
            $data['ctime'] = $data['mtime'] = time();

            $insert_id = $this->Auth_model->insert_one($data);

            if($insert_id > 0)
            {
                $data_detail = array();
                $data_detail['userid'] = $insert_id;
                $data_detail['avatar'] = 'default.jpg';
                if($_FILES['avatar']['error'] == 4) //如果没上传图片，则直接提示成功
                {
                    $info['status'] = 1;
                    $info['msg'] = '添加成功！';
                }
                else
                {
                    $upload = $this->uploadAvatar();
                    if($upload['status'] == 1)
                    {
                        $data_detail['avatar'] = $upload['msg']['upload_data']['file_name'];

                        $info['status'] = 1;
                        $info['msg'] = '添加成功！';
                    }
                    else
                    {
                        $info['status'] = 2;
                        $info['msg'] = $upload['msg']['error'];
                    }
                }
                $this->User_model->insert_one($data_detail);
            }
            else
            {
                $info['msg'] = '数据库插入失败！';
            }
        }

        $this->session->set_flashdata('info', $info);
        redirect('/system/user/userIndex', 'location');
    }

    public function userShow()
    {
        $id = $this->input->get('id', TRUE);

        if($id > 0)
        {
            $left_table = 'user';
            $right_table = 'user_detail';
            $field = 'user.username, user.email, user.ctime, user_detail.avatar';
            $on = 'user.id = user_detail.userid';
            $join_type = 'left';
            $where = array('user.id' => $id);
            $result = $this->Auth_model->join_query($left_table, $right_table, $field, $on, $join_type, $where);
            $data['info'] = $result[0];
            $this->load->view('system/user_show', $data);
        }
        else
        {
            show_404();
        }
    }

    public function userEdit()
    {
        $id = $this->input->get('id', TRUE);

        if($id > 0)
        {
            $left_table = 'user';
            $right_table = 'user_detail';
            $field = 'user.id, user.username, user.email, user.ctime, user_detail.avatar';
            $on = 'user.id = user_detail.userid';
            $join_type = 'left';
            $where = array('user.id' => $id);
            $result = $this->Auth_model->join_query($left_table, $right_table, $field, $on, $join_type, $where);
            $data['info'] = $result[0];
            $this->load->view('system/user_edit', $data);
        }
        else
        {
            show_404();
        }
    }

    public function userEditDo()
    {
        $info = array('status' => 0, 'msg' => '编辑失败！');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[1]|max_length[20]|callback_username_check');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');

        if ($this->form_validation->run() == FALSE)
        {
            $info['msg'] = validation_errors();
        }
        else
        {
            $data = $this->input->post(NULL, TRUE);
            $data['mtime'] = time();
            $id = $data['id'];
            $where = array('id' => $id);
            unset($data['id']);
            if($this->Auth_model->update($data, $where))
            {
                if($_FILES['avatar']['error'] == 4) //如果没上传图片，则直接提示成功
                {
                    $info['status'] = 1;
                    $info['msg'] = '更新成功！';
                }
                else
                {
                    $upload = $this->uploadAvatar();
                    if($upload['status'] == 1)
                    {
                        $data_detail['avatar'] = $upload['msg']['upload_data']['file_name'];
                        $where_detail = array('userid' => $id);
                        $this->User_model->update($data_detail, $where_detail);

                        $info['status'] = 1;
                        $info['msg'] = '更新成功！';
                    }
                    else
                    {
                        $info['status'] = 2;
                        $info['msg'] = $upload['msg']['error'];
                    }
                }
            }
            else
            {
                $info['msg'] = '数据库更新失败！';
            }
        }
        $this->session->set_flashdata('info', $info);
        redirect('/system/user/userIndex', 'location');
    }

    public function username_check($username)
    {
        $id = $this->input->post('id');
        $where = array('id !=' => $id, 'username' => $username);
        $result = $this->Auth_model->get_info($where);
        if(empty($result))
        {
            return true;
        }
        else
        {
            $this->form_validation->set_message('username_check', '已经存在'.$username.'的账号');
            return false;
        }
    }

    public function email_check($email)
    {
        $id = $this->input->post('id');
        $where = array('id !=' => $id, 'email' => $email);
        $result = $this->Auth_model->get_info($where);
        if(empty($result))
        {
            return true;
        }
        else
        {
            $this->form_validation->set_message('email_check', '已经存在'.$email.'的邮箱');
            return false;
        }
    }

    public function userDeleteDo()
    {
        $id = $this->input->post('userid');
        $ids_arr = explode(",", $id);
        $info = array('status' => 0, 'msg' => '删除失败！');
        if(!in_array(1, $ids_arr))
        {
            if($this->Auth_model->delete_in('id', $ids_arr))
            {
                $this->User_model->delete_in('userid', $ids_arr);
                $info['status'] = 1;
                $info['msg'] = '删除成功！';
            }
            else
            {
                $info['msg'] = '删除数据失败！';
            }
        }
        else
        {
            $info['msg'] = '不能删除超级管理员！';
        }

        $this->session->set_flashdata('info', $info);
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($info));
    }

    /**
     * @return array status: 0 上传失败 1上传成功
     */
    private function uploadAvatar()
    {
        $result = array('status' => 0, 'msg' => array());

        $config['upload_path'] = './static/uploads/avatar/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 100;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('avatar'))
        {
            $error = array('error' => $this->upload->display_errors());

            $result['msg'] = $error;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $result['status'] = 1;
            $result['msg'] = $data;
        }
        return $result;
    }

}