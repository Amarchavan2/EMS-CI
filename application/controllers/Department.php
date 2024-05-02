<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        // Check if user is logged in
        if ( ! $this->session->userdata('logged_in'))
        { 
            // Redirect to login page if not logged in
            redirect(base_url().'login');
        }
    }

    // Display add department form
    public function index()
    {
        $this->load->view('admin/header');
        $this->load->view('admin/add-department');
        $this->load->view('admin/footer');
    }

    // Display list of departments
    public function manage_department()
    {
        $data['content']=$this->Department_model->select_departments();
        $this->load->view('admin/header');
        $this->load->view('admin/manage-department',$data);
        $this->load->view('admin/footer');
    }

    // Insert new department
    public function insert()
    {
        $department=$this->input->post('txtdepartment');
        $data=$this->Department_model->insert_department(array('department_name'=>$department));
        if($data==true)
        {
            $this->session->set_flashdata('success', "New Department Added Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, New Department Adding Failed.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // Update department
    public function update()
    {
        $id=$this->input->post('txtid');
        $department=$this->input->post('txtdepartment');
        $data=$this->Department_model->update_department(array('department_name'=>$department),$id);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Department Updated Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Department Update Failed.");
        }
        redirect(base_url()."department/manage_department");
    }

    // Display edit department form
    function edit($id)
    {
        $data['content']=$this->Department_model->select_department_byID($id);
        $this->load->view('admin/header');
        $this->load->view('admin/edit-department',$data);
        $this->load->view('admin/footer');
    }

    // Delete department
    function delete($id)
    {
        $data=$this->Department_model->delete_department($id);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Department Deleted Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Department Delete Failed.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

}
