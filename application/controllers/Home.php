<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

    // Default method for the home page
    public function index()
    {
        // Check if the user is logged in
        if ( ! $this->session->userdata('logged_in'))
        { 
            // If not logged in, redirect to the login page
            redirect(base_url('login'));
        }
        else
        {
            // If logged in, check user type
            if($this->session->userdata('usertype')==1)
            {
                // Load necessary models and fetch data for admin dashboard
                $data['department']=$this->Department_model->select_departments();
                $data['staff']=$this->Staff_model->select_staff();
                $data['leave']=$this->Leave_model->select_leave_forApprove();
                $data['salary']=$this->Salary_model->sum_salary();
                
                // Load admin dashboard view
                $this->load->view('admin/header');
                $this->load->view('admin/dashboard',$data);
                $this->load->view('admin/footer');
            }
            else{
                // For other user types (staff), load data for staff dashboard
                $staff=$this->session->userdata('userid');
                $data['leave']=$this->Leave_model->select_leave_byStaffID($staff);
                $this->load->view('staff/header');
                $this->load->view('staff/dashboard',$data);
                $this->load->view('staff/footer');
            }
            
        }
    }

    // Method to load the login page
    public function login_page()
    {
        $this->load->view('login');
    }

    // Method to load the error page
    public function error_page()
    {
        // Load error page view
        $this->load->view('admin/header');
        $this->load->view('admin/error_page');
        $this->load->view('admin/footer');
    }

    // Method to handle user login
    function login()
    {
        $un=$this->input->post('txtusername');
        $pw=$this->input->post('txtpassword');
        $this->load->model('Home_model');
        
        // Validate user credentials
        $check_login=$this->Home_model->logindata($un,$pw);
        
        if($check_login<>'')
        {
            // Check if the user account is active
            if($check_login[0]['status']==1){
                // Check user type and set session data accordingly
                if($check_login[0]['usertype']==1 || $check_login[0]['usertype']==2){
                    $data = array(
                        'logged_in'  =>  TRUE,
                        'username' => $check_login[0]['username'],
                        'usertype' => $check_login[0]['usertype'],
                        'userid' => $check_login[0]['id']
                    );
                    $this->session->set_userdata($data);
                    redirect('/');
                }
                else{
                    // Handle other user types
                    $this->session->set_flashdata('login_error', 'Sorry, you cant login right now.', 300);
                    redirect(base_url().'login');
                }
                
            }
            else{
                // Handle blocked accounts
                $this->session->set_flashdata('login_error', 'Sorry, your account is blocked.', 300);
                redirect(base_url().'login');
            }
            
        }
        else{
            // Handle invalid credentials
            $this->session->set_flashdata('login_error', 'Please check your username or password and try again.', 300);
            redirect(base_url().'login');
        }
    }

    // Method to handle user logout
    public function logout()
    {
        // Destroy session and redirect to login page
        $this->session->sess_destroy();
        redirect(base_url().'login');
    }

}
