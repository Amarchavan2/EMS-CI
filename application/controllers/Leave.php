<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        // Check if the user is logged in; if not, redirect to the login page
        if ( ! $this->session->userdata('logged_in'))
        { 
            redirect(base_url().'login');
        }
    }

    public function index()
    {
        // Load header, apply-leave view, and footer for staff
        $this->load->view('staff/header');
        $this->load->view('staff/apply-leave');
        $this->load->view('staff/footer');
    }

    public function approve()
    {
        // Get user ID from session
        $staff=$this->session->userdata('userid');
        // Fetch leave data for approval from the Leave_model
        $data['content']=$this->Leave_model->select_leave_forApprove();
        // Load header, approve-leave view with data, and footer for admin
        $this->load->view('admin/header');
        $this->load->view('admin/approve-leave',$data);
        $this->load->view('admin/footer');
    }

    public function manage()
    {
        // Fetch all leave data from the Leave_model
        $data['content']=$this->Leave_model->select_leave();
        // Load header, manage-leave view with data, and footer for admin
        $this->load->view('admin/header');
        $this->load->view('admin/manage-leave',$data);
        $this->load->view('admin/footer');
    }

    public function view()
    {
        // Get user ID from session
        $staff=$this->session->userdata('userid');
        // Fetch leave data for the current user from the Leave_model
        $data['content']=$this->Leave_model->select_leave_byStaffID($staff);
        // Load header, view-leave view with data, and footer for staff
        $this->load->view('staff/header');
        $this->load->view('staff/view-leave',$data);
        $this->load->view('staff/footer');
    }

    public function insert_approve($id)
    {
        // Update leave status to approve in Leave_model
        $data=$this->Leave_model->update_leave(array('status'=>1),$id);
        // Check if the update was successful and set flash message accordingly
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Leave Approved Successfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Leave Approval Failed.");
        }
        // Redirect back to the previous page
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function insert_reject($id)
    {
        // Update leave status to reject in Leave_model
        $data=$this->Leave_model->update_leave(array('status'=>2),$id);
        // Check if the update was successful and set flash message accordingly
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Leave Rejected Successfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Leave Rejection Failed.");
        }
        // Redirect back to the previous page
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function insert()
    {
        // Validate form data
        $this->form_validation->set_rules('txtreason', 'Reason', 'required');
        $this->form_validation->set_rules('txtleavefrom', 'Leave From', 'required');
        $this->form_validation->set_rules('txtleaveto', 'Leave To', 'required');

        // Get user ID from session and form inputs
        $staff=$this->session->userdata('userid');
        $reason=$this->input->post('txtreason');
        $lfrom=$this->input->post('txtleavefrom');
        $lto=$this->input->post('txtleaveto');
        $desc=$this->input->post('txtdescription');
        // Insert new leave data into Leave_model
        $data=$this->Leave_model->insert_leave(array('staff_id'=>$staff,'leave_reason'=>$reason,'leave_from'=>$lfrom,'leave_to'=>$lto,'description'=>$desc,'applied_on'=>date('Y-m-d')));
        // Check if insertion was successful and set flash message accordingly
        if($data==true)
        {
            $this->session->set_flashdata('success', "New Leave Applied Successfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, New Leave Application Failed.");
        }
        // Redirect back to the previous page
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update()
    {
        // Get form inputs
        $id=$this->input->post('txtid');
        $department=$this->input->post('txtdepartment');
        // Update department data in Department_model
        $data=$this->Department_model->update_department(array('department_name'=>$department),$id);
        // Check if update was successful and set flash message accordingly
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Department Updated Successfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Department Update Failed.");
        }
        // Redirect to the department management page
        redirect(base_url()."department/manage_department");
    }

    function edit($id)
    {
        // Fetch department data by ID from Department_model
        $data['content']=$this->Department_model->select_department_byID($id);
        // Load header, edit-department view with data, and footer for admin
        $this->load->view('admin/header');
        $this->load->view('admin/edit-department',$data);
        $this->load->view('admin/footer');
    }

    function delete($id)
    {
        // Delete department data by ID in Department_model
        $data=$this->Department_model->delete_department($id);
        // Check if deletion was successful and set flash message accordingly
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Department Deleted Successfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Department Deletion Failed.");
        }
        // Redirect back to the previous page
        redirect($_SERVER['HTTP_REFERER']);
    }
}
