<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    
    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['admin'] = 'Admin';
        $data['user'] = $this->db->get_where('user', ['email' => 
        $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();


        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if($this->form_validation->run() == false ){

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('template/footer', $data);
        }else{
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" alert-dismissible fade show role="alert">Your menu added!</div>');
            redirect('menu');
        }
        
    }

    public function submenu(){
        
        $data['title'] = 'Submenu Management';
        $data['admin'] = 'Admin';
        $data['user'] = $this->db->get_where('user', ['email' => 
        $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_model', 'menu');

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'icon', 'required');


        if($this->form_validation->run() == false ){

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('template/footer', $data);
            
        }else{
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];

            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" alert-dismissible fade show role="alert">Your submenu added!</div>');
            redirect('menu/submenu');

        }


    }

    public function delete_menu($id){
            $tableMenu = ['user_menu'];
            $this->db->where('id', $id);
            $this->db->delete($tableMenu);

            $this->session->set_flashdata('message', '<div class="alert alert-success" alert-dismissible fade show role="alert">Your menu has been deleted</div>');
        
        redirect('menu');
    }

    public function delete_submenu($id){
        $tableSubMenu = ['user_sub_menu'];
        $this->db->where('id', $id);
        $this->db->delete($tableSubMenu);

        $this->session->set_flashdata('message', '<div class="alert alert-success" alert-dismissible fade show role="alert">Your submenu has been deleted</div>');
        
        redirect('menu/submenu');

    }


}