<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

    public function __construct(){
        parent::__construct();

        $this->load->model('Blog_model','bg_md');

    }

    public function index()
    {
        $data['title'] = 'Blog List';

        $blog = new Blog_model();

        $data['lists'] = $blog->select_all();

        $this->load->admin('blog/index',$data);
    }

    public function create(){

        if($this->input->post()){

            $request_data = [
                'title' => $this->security->xss_clean($this->input->post('title')),
                'description' => $this->security->xss_clean($this->input->post('description')),
                'content' => $this->security->xss_clean($this->input->post('content')),
                'image' => $this->security->xss_clean($this->input->file('image')),
                'video' => $this->security->xss_clean($this->input->file('video')),
                'is_monset' => $this->security->xss_clean($this->input->post('is_menu')),
                'status' => $this->security->xss_clean($this->input->post('status')),
                'created_at' => date("Y-m-d H:i:s")
            ];
            $insert_id = $this->bg_md->insert($request_data);

            if($insert_id > 0){
                $this->session->set_flashdata('success_message','Məlumat uğurla əlavə edildi');

                redirect('backend/blog');
            }

        }

        $data['title'] = 'Blog List';

        $this->load->admin('blog/create',$data);

    }

    public function edit($id){

        if($this->input->post()){
            $id = $this->security->xss_clean($id);

            $request_data = [
                'title' => $this->security->xss_clean($this->input->post('title')),
                'description' => $this->security->xss_clean($this->input->post('description')),
                'content' => $this->security->xss_clean($this->input->post('content')),
                'image' => $this->security->xss_clean($this->input->file('image')),
                'video' => $this->security->xss_clean($this->input->file('video')),
                'is_monset' => $this->security->xss_clean($this->input->post('is_menu')),
                'status' => $this->security->xss_clean($this->input->post('status')),
            ];

            $affected_rows = $this->bg_md->update($id,$request_data);
            redirect('backend/blog');
            if($affected_rows > 0){
                $this->session->set_flashdata('success_message','Məlumat uğurla dəyişdirildi');

                redirect('backend/blog/edit/'.$id);
            }

        }

        $item = $this->bg_md->selectDataById($id);

        if(empty($item)){
            $this->session->set_flashdata('error_message','Bu məlumat tapılmadı');

            redirect('backend/blog');
        }

        $data['item'] = $item;

        $data['title'] = 'Blog Edit';

        $this->load->admin('blog/edit',$data);


    }
    public function delete($id) {
//        $this->load->model('Admins_model');
        $this->bg_md->delete($id);
        redirect('backend/blog');
    }

}


