<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_model extends CI_Model {

    // Function to insert a new staff member into the database
    function insert_staff($data)
    {
        $this->db->insert("staff_tbl", $data);
        // Return the ID of the inserted staff member
        return $this->db->insert_id();
    }

    // Function to retrieve all staff members with their department details
    function select_staff()
    {
        $this->db->order_by('staff_tbl.id', 'DESC');
        $this->db->select("staff_tbl.*, department_tbl.department_name");
        $this->db->from("staff_tbl");
        $this->db->join("department_tbl", 'department_tbl.id=staff_tbl.department_id');
        $qry = $this->db->get();
        if($qry->num_rows() > 0)
        {
            // Return staff members data as an array
            $result = $qry->result_array();
            return $result;
        }
    }

    // Function to select a specific staff member by their ID
    function select_staff_byID($id)
    {
        $this->db->where('staff_tbl.id', $id);
        $this->db->select("staff_tbl.*, department_tbl.department_name");
        $this->db->from("staff_tbl");
        $this->db->join("department_tbl", 'department_tbl.id=staff_tbl.department_id');
        $qry = $this->db->get();
        if($qry->num_rows() > 0)
        {
            // Return staff member data as an array
            $result = $qry->result_array();
            return $result;
        }
    }

    // Function to select a staff member by their email
    function select_staff_byEmail($email)
    {
        $this->db->where('email', $email);
        $qry = $this->db->get('staff_tbl');
        if($qry->num_rows() > 0)
        {
            // Return staff member data as an array
            $result = $qry->result_array();
            return $result;
        }
    }

    // Function to select staff members belonging to a specific department
    function select_staff_byDept($dpt)
    {
        $this->db->where('staff_tbl.department_id', $dpt);
        $this->db->select("staff_tbl.*, department_tbl.department_name");
        $this->db->from("staff_tbl");
        $this->db->join("department_tbl", 'department_tbl.id=staff_tbl.department_id');
        $qry = $this->db->get();
        if($qry->num_rows() > 0)
        {
            // Return staff members data as an array
            $result = $qry->result_array();
            return $result;
        }
    }

    // Function to delete a staff member based on their ID
    function delete_staff($id)
    {
        $this->db->where('id', $id);
        $this->db->delete("staff_tbl");
        // Return the number of affected rows after deletion
        return $this->db->affected_rows();
    }

    // Function to update staff member details based on their ID
    function update_staff($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('staff_tbl', $data);
        // Return the number of affected rows after update
        return $this->db->affected_rows();
    }
}
