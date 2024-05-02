<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

    // Function to check login credentials
    function logindata($un, $pw)
    {
        $this->db->where('username', $un);               
        $this->db->where('password', $pw);
        $qry = $this->db->get("login_tbl");
        if($qry->num_rows() > 0)
        {
            // Return login data as an array
            $result = $qry->result_array();
            return $result;
        }
    }

    // Function to insert login data into the database
    function insert_login($data)
    {
        $this->db->insert("login_tbl", $data);
        // Return the insert ID of the new login entry
        return $this->db->insert_id();
    }

    // Function to update room data based on ID
    function update_rooms($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('room_tbl', $data);
    }

    // Function to select reservation data with room and booking details
    function select_reservation()
    {
        $this->db->order_by('reservation_tbl.id', 'DESC');
        $this->db->select("reservation_tbl.*, room_tbl.roomname, booking_tbl.name, booking_tbl.email, booking_tbl.phno");
        $this->db->from("reservation_tbl");
        $this->db->join("room_tbl", 'room_tbl.id = reservation_tbl.room');
        $this->db->join("booking_tbl", 'booking_tbl.id = reservation_tbl.booking_id');
        $qry = $this->db->get();
        if($qry->num_rows() > 0)
        {
            // Return reservation data as an array
            $result = $qry->result_array();
            return $result;
        }
    }

    // Function to select all countries from the database
    function select_countries()
    {
        $qry = $this->db->get('country_tbl');
        if($qry->num_rows() > 0)
        {
            // Return countries data as an array
            $result = $qry->result_array();
            return $result;
        }
    }

    // Function to select a specific room by its ID
    function select_rooms_byID($id)
    {
        $this->db->where('id', $id);
        $qry = $this->db->get('room_tbl');
        if($qry->num_rows() > 0)
        {
            // Return room data as an array
            $result = $qry->result_array();
            return $result;
        }
    }

    // Function to delete login data based on ID
    function delete_login_byID($id)
    {
        $this->db->where('id', $id);
        $this->db->delete("login_tbl");
        // Return the number of affected rows after deletion
        return $this->db->affected_rows();
    }
}
