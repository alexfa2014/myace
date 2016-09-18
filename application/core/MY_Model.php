<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 模型公共类
 */
class MY_Model extends CI_Model {

    public function __construct($table)
    {
        parent::__construct();
        $this->table = $table;
    }

    /**
     * （根据条件）获取结果集
     */
    public function get_info($where = FALSE)
    {
        if ($where === FALSE)
        {
            $query = $this->db->get($this->table);
            return $query->result_array();
        }

        $query = $this->db->get_where($this->table, $where);
        return $query->result_array();
    }

    /**
     * 插入一条数据
     */
    public function insert_one($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * 更新数据
     */
    public function update($data, $where)
    {
        $this->db->where($where);
        return $this->db->update($this->table, $data);
    }

    /**
     * 删除一条数据
     */
    public function delete_one($where)
    {
        $this->db->where($where);
        return $this->db->delete($this->table);
    }

    /**
     * 批量删除
     */
    public function delete_in($field, $ids_arr)
    {
        $this->db->where_in($field, $ids_arr);
        return $this->db->delete($this->table);
    }

    /**
     * join查询
     * @param $left_table
     * @param $right_table
     * @param $field
     * @param $on
     * @param $join_type
     * @param bool|false $where
     */
    public function join_query($left_table, $right_table, $field, $on, $join_type, $where = false)
    {
        $this->db->select($field);
        $this->db->from($left_table);
        $this->db->join($right_table, $on, $join_type);

        if($where !== false)
        {
            $this->db->where($where);
        }

        return $this->db->get()->result_array();
    }

}