<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

  public function __construct()
  {
      parent::__construct();
      $this->load->library('form_validation');
  }

  public function index()
   { 
      // cek jiga sudah login tidak bisa kembali ke halaman login
      if($this->session->userdata('email')){
        redirect('user');
      }
      
      $this->load->library('session');
      $this->form_validation->set_rules('email' ,'Email', 'trim|required|valid_email');
      $this->form_validation->set_rules('password' ,'Password', 'trim|required');
      if($this->form_validation->run() == false){

        // data title login page
        $data['title'] = 'Login Page';
        
        // template header
        $this->load->view('template/auth_header', $data);
        
        // halaman login page
        $this->load->view('auth/login');
        
        // template footer
        $this->load->view('template/auth_footer');

      }else{
        // validasinya sukses
        $this->_login();
      }
   }

    private function _login()
   {
    $this->load->library('session');
    $this->load->helper('url');
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    $user = $this->db->get_where('user', ['email' => $email])->row_array();
    
    // usernya ada
    if($user){

      if($user){
        // jika user aktif
        if($user['is_active'] == 1){
          // cek password
          if(password_verify($password, $user['password'])){
            $data = [
              'email' => $user['email'],
              'role_id' => $user['role_id']
            ];
            $this->session->set_userdata($data);
            if($user['role_id'] == 1){
              redirect('admin');
            }else{
              
              redirect('user');
            }

          }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" alert-dismissible fade show role="alert">Wrong Password!</div>');
            redirect('auth');
          }

        }else{
          $this->session->set_flashdata('message', '<div class="alert alert-danger" alert-dismissible fade show role="alert">Email has not been activated!</div>');
          redirect('auth');
        }
      }

    }else{

      $this->session->set_flashdata('message', '<div class="alert alert-danger" alert-dismissible fade show role="alert">Email is not registered!</div>');
      redirect('auth');
    }

   }
  
  public function registration()
    {

      // cek jiga sudah login tidak bisa kembali ke halaman login
      if($this->session->userdata('email')){
        redirect('user');
      }
      // form validation
      $this->form_validation->set_rules('name','Name', 'required|trim');
      $this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[user.email]',[
        'is_unique' => 'This email has already registered'
      ]);
      $this->form_validation->set_rules('password1','Password','required|trim|min_length[3]|matches[password2]', [
        'matches' => 'Password dont match!',
        'min_length' => 'Password too short!'
      ]
      );
      $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

      // pengkondisian registrasi
      if($this->form_validation->run() == false)
      
      {
        // data title user registration
        $data['title'] = 'WRN User Registration';
        
        // template header
        $this->load->view('template/auth_header', $data);

        // halaman registration
        $this->load->view('auth/registration');

        // template footer
        $this->load->view('template/auth_footer');

      }else{
        // input data user registrasi
        $data = [
          'name' => htmlspecialchars($this->input->post('name', true)),
          'email' => htmlspecialchars($this->input->post('email', true)),
          'image' => 'default.jpg',
          'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
          'role_id' => 2,
          'is_active' => 1,
          'date_created' => date(DATE_ATOM, time())
        ];

       // insert registrasi ke database
        $this->db->insert('user', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" alert-dismissible fade show role="alert">Your account has been created</div>');
        redirect('auth');
      }
      
    }
    
    public function logout(){
      $this->load->library('session');

      $this->session->unset_userdata('email');
      $this->session->unset_userdata('role_id');

      $this->session->set_flashdata('message', '<div class="alert alert-success" alert-dismissible fade show role="alert">Your logged out is success</div>');
      redirect('auth');

    }

    public function blocked(){

      $data = [
        'title' => 'WRN Blocked'
      ];

      $this->load->view('auth/blocked', $data);
    }

}