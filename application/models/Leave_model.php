<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_model extends CI_Model {

    // Function to insert a new leave request into the database
    function insert_leave($data)
    {
        $this->db->insert("leave_tbl",$data);
        // Return the insert ID of the new leave request
        return $this->db->insert_id();
    }

    // Function to retrieve all leave requests with staff and department details
    function select_leave()
    {
        $this->db->order_by('leave_tbl.id','DESC');
        $this->db->select("leave_tbl.*, staff_tbl.pic, staff_tbl.staff_name, staff_tbl.city, staff_tbl.state, staff_tbl.country, staff_tbl.mobile, staff_tbl.email, department_tbl.department_name");
        $this->db->from("leave_tbl");
        $this->db->join("staff_tbl", 'staff_tbl.id=leave_tbl.staff_id');
        $this->db->join("department_tbl", 'department_tbl.id=staff_tbl.department_id');
        $qry = $this->db->get();
        if($qry->num_rows() > 0)
        {
            // Return leave requests data as an array
            $result = $qry->result_array();
            return $result;
        }
    }

    // Function to select a specific department by its ID
    function select_department_byID($id)
    {
        $this->db->where('id', $id);
        $qry = $this->db->get('department_tbl');
        if($qry->num_rows() > 0)
        {
            // Return department data as an array
            $result = $qry->result_array();
            return $result;
        }
    }

    // Function to retrieve all leave requests for a specific staff member
    function select_leave_byStaffID($staffid)
    {
        $this->db->order_by('leave_tbl.id','DESC');
        $this->db->where('leave_tbl.staff_id', $staffid);
        $this->db->select("leave_tbl.*, staff_tbl.staff_name, staff_tbl.city, staff_tbl.state, staff_tbl.country, staff_tbl.mobile, staff_tbl.email, department_tbl.department_name");
        $this->db->from("leave_tbl");
        $this->db->join("staff_tbl", 'staff_tbl.id=leave_tbl.staff_id');
        $this->db->join("department_tbl", 'department_tbl.id=staff_tbl.department_id');
        $qry = $this->db->get();
        if($qry->num_rows() > 0)
        {
            // Return leave requests data as an array
            $result = $qry->result_array();
            return $result;
        }
    }

    // Function to retrieve all leave requests pending for approval
    function select_leave_forApprove()
    {
        $this->db->where('leave_tbl.status', 0);
        $this->db->select("leave_tbl.*, staff_tbl.pic, staff_tbl.staff_name, staff_tbl.city, staff_tbl.state, staff_tbl.country, staff_tbl.mobile, staff_tbl.email, department_tbl.department_name");
        $this->db->from("leave_tbl");
        $this->db->join("staff_tbl", 'staff_tbl.id=leave_tbl.staff_id');
        $this->db->join("department_tbl", 'department_tbl.id=staff_tbl.department_id');
        $qry = $this->db->get();
        if($qry->num_rows() > 0)
        {
            // Return leave requests data as an array
            $result = $qry->result_array();
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

    // Function to update leave request status based on its ID
    function update_leave($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('leave_tbl', $data);
        // Return the number of affected rows after update
        return $this->db->affected_rows();
    }
}
