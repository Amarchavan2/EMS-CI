<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_model extends CI_Model {

    // Function to insert a new department into the database
    function insert_department($data)
    {
        $this->db->insert("department_tbl",$data);
        // Return the insert ID of the newly inserted department
        return $this->db->insert_id();
    }

    // Function to retrieve all departments from the database
    function select_departments()
    {
        $qry=$this->db->get('department_tbl');
        if($qry->num_rows()>0)
        {
            // Return an array of all departments
            $result=$qry->result_array();
            return $result;
        }
    }

    // Function to select a specific department by its ID
    function select_department_byID($id)
    {
        $this->db->where('id',$id);
        $qry=$this->db->get('department_tbl');
        if($qry->num_rows()>0)
        {
            // Return the data of the selected department
            $result=$qry->result_array();
            return $result;
        }
    }

    // Function to delete a department based on its ID
    function delete_department($id)
    {
        $this->db->where('id', $id);
        $this->db->delete("department_tbl");
        // Return the number of affected rows after deletion
        return $this->db->affected_rows();
    }

    // Function to update department data based on its ID
    function update_department($data,$id)
    {
        $this->db->where('id', $id);
        $this->db->update('department_tbl',$data);
        // Return the number of affected rows after update
        return $this->db->affected_rows();
    }
}
