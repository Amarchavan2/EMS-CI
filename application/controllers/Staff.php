<?php
// Prevent direct access to this file
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {
// Constructor to initialize the controller
    function __construct()
    {
        parent::__construct();
         // Check if the user is logged in; if not, redirect to login page

        if ( ! $this->session->userdata('logged_in'))
        { 
            redirect(base_url().'login');
        }
    }
 // Display the form for adding new staff

    public function index()
    {
        // Load departments and countries data for the add-staff form

        $data['department']=$this->Department_model->select_departments();
        $data['country']=$this->Home_model->select_countries();
         // Load necessary views

        $this->load->view('admin/header');
        $this->load->view('admin/add-staff',$data);
        $this->load->view('admin/footer');
    }
 // Display the list of staff for management
 public function manage()
    {
         // Load staff data for management

        $data['content']=$this->Staff_model->select_staff();
        // Load necessary views
        $this->load->view('admin/header');
        $this->load->view('admin/manage-staff',$data);
        $this->load->view('admin/footer');
    }
// Insert a new staff into the database
    public function insert()
    {
        // Validation rules for inserting new staff
        $this->form_validation->set_rules('txtname', 'Full Name', 'required');
        $this->form_validation->set_rules('slcgender', 'Gender', 'required');
        $this->form_validation->set_rules('slcdepartment', 'Department', 'required');
        $this->form_validation->set_rules('txtemail', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('txtmobile', 'Mobile Number ', 'required|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('txtdob', 'Date of Birth', 'required');
        $this->form_validation->set_rules('txtdoj', 'Date of Joining', 'required');
        $this->form_validation->set_rules('txtcity', 'City', 'required');
        $this->form_validation->set_rules('txtstate', 'State', 'required');
        $this->form_validation->set_rules('slccountry', 'Country', 'required');
         
// Get input data from POST
        $name=$this->input->post('txtname');
        $gender=$this->input->post('slcgender');
        $department=$this->input->post('slcdepartment');
        $email=$this->input->post('txtemail');
        $mobile=$this->input->post('txtmobile');
        $dob=$this->input->post('txtdob');
        $doj=$this->input->post('txtdoj');
        $city=$this->input->post('txtcity');
        $state=$this->input->post('txtstate');
        $country=$this->input->post('slccountry');
        $address=$this->input->post('txtaddress');
        $added=$this->session->userdata('userid');

        if($this->form_validation->run() !== false)
        {
            // Handle file upload and image processing

            $this->load->library('image_lib');
            $config['upload_path']= 'uploads/profile-pic/';
            $config['allowed_types'] ='gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('filephoto'))
            {
                $image='default-pic.jpg';
            }
            else
            {
                $image_data =   $this->upload->data();

                $configer =  array(
                  'image_library'   => 'gd2',
                  'source_image'    =>  $image_data['full_path'],
                  'maintain_ratio'  =>  TRUE,
                  'width'           =>  150,
                  'height'          =>  150,
                  'quality'         =>  50
                );
                $this->image_lib->clear();
                $this->image_lib->initialize($configer);
                $this->image_lib->resize();
                
                $image=$image_data['file_name'];
            }
            // Insert new staff into the database
            $login=$this->Home_model->insert_login(array('username'=>$email,'password'=>$mobile,'usertype'=>2));

            if($login>0)
            {
               
                $data=$this->Staff_model->insert_staff(array('id'=>$login,'staff_name'=>$name,'gender'=>$gender,'email'=>$email,'mobile'=>$mobile,'dob'=>$dob,'doj'=>$doj,'address'=>$address,'city'=>$city,'state'=>$state,'country'=>$country,'department_id'=>$department,'pic'=>$image,'added_by'=>$added));
            }
            
            if($data==true)
            {
                 // Set flash message for successful insertion
                $this->session->set_flashdata('success', "New Staff Added Succesfully"); 
            }else{
                // Set flash message for failed insertion

                $this->session->set_flashdata('error', "Sorry, New Staff Adding Failed.");
            }
             // Redirect to the previous page
            redirect($_SERVER['HTTP_REFERER']);
        }
        else{
             // If validation fails, reload the index page
            $this->index();
            return false;

        } 
    }

    // Update an existing staff record in the database

    public function update()
    {
        // Validation rules for updating staff
        $this->load->helper('form');
        $this->form_validation->set_rules('txtname', 'Full Name', 'required');
        $this->form_validation->set_rules('slcgender', 'Gender', 'required');
        $this->form_validation->set_rules('slcdepartment', 'Department', 'required');
        $this->form_validation->set_rules('txtemail', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('txtmobile', 'Mobile Number ', 'required|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('txtdob', 'Date of Birth', 'required');
        $this->form_validation->set_rules('txtdoj', 'Date of Joining', 'required');
        $this->form_validation->set_rules('txtcity', 'City', 'required');
        $this->form_validation->set_rules('txtstate', 'State', 'required');
        $this->form_validation->set_rules('slccountry', 'Country', 'required');
        
        // Get input data from POST

        $id=$this->input->post('txtid');
        $name=$this->input->post('txtname');
        $gender=$this->input->post('slcgender');
        $department=$this->input->post('slcdepartment');
        $email=$this->input->post('txtemail');
        $mobile=$this->input->post('txtmobile');
        $dob=$this->input->post('txtdob');
        $doj=$this->input->post('txtdoj');
        $city=$this->input->post('txtcity');
        $state=$this->input->post('txtstate');
        $country=$this->input->post('slccountry');
        $address=$this->input->post('txtaddress');

        if($this->form_validation->run() !== false)
        {
            // Handle file upload and image processing for update
            $this->load->library('image_lib');
            $config['upload_path']= 'uploads/profile-pic/';
            $config['allowed_types'] ='gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('filephoto'))
            {
                // Update staff data in the database
                $data=$this->Staff_model->update_staff(array('staff_name'=>$name,'gender'=>$gender,'email'=>$email,'mobile'=>$mobile,'dob'=>$dob,'doj'=>$doj,'address'=>$address,'city'=>$city,'state'=>$state,'country'=>$country,'department_id'=>$department),$id);
            }
            else
            {
                $image_data =   $this->upload->data();

                $configer =  array(
                  'image_library'   => 'gd2',
                  'source_image'    =>  $image_data['full_path'],
                  'maintain_ratio'  =>  TRUE,
                  'width'           =>  150,
                  'height'          =>  150,
                  'quality'         =>  50
                );
                $this->image_lib->clear();
                $this->image_lib->initialize($configer);
                $this->image_lib->resize();

                $data=$this->Staff_model->update_staff(array('staff_name'=>$name,'gender'=>$gender,'email'=>$email,'mobile'=>$mobile,'dob'=>$dob,'doj'=>$doj,'address'=>$address,'city'=>$city,'state'=>$state,'country'=>$country,'department_id'=>$department,'pic'=>$image_data['file_name'],'added_by'=>$added),$id);
            }
            
            if($this->db->affected_rows() > 0)
            {
                // Set flash message for successful update

                $this->session->set_flashdata('success', "Staff Updated Succesfully"); 
            }else{
                // Set flash message for failed update

                $this->session->set_flashdata('error', "Sorry, Staff Updated Failed.");
            }
             // Redirect to manage staff page

            redirect(base_url()."manage-staff");
        }
        else{
            $this->index();
            return false;

        } 
    }

      // Display the form for editing a staff record

    function edit($id)
    {
        // Load departments, countries, and staff data for editing

        $data['department']=$this->Department_model->select_departments();
        $data['country']=$this->Home_model->select_countries();
        $data['content']=$this->Staff_model->select_staff_byID($id);
         // Load necessary views

        $this->load->view('admin/header');
        $this->load->view('admin/edit-staff',$data);
        $this->load->view('admin/footer');
    }

// Delete a staff record from the database
function delete($id)
    {
        // Delete login credentials associated with the staff

        $this->Home_model->delete_login_byID($id);
        // Delete staff record

        $data=$this->Staff_model->delete_staff($id);
        if($this->db->affected_rows() > 0)
        {
            // Set flash message for successful deletion

            $this->session->set_flashdata('success', "Staff Deleted Succesfully"); 
        }else{
            // Set flash message for failed deletion
            $this->session->set_flashdata('error', "Sorry, Staff Delete Failed.");
        }
        // Redirect to the previous page

        redirect($_SERVER['HTTP_REFERER']);
    }
}