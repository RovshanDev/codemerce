<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkout extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Category_model', 'cat_md');
        $this->load->model('Delivery_methods_model', 'del_md');
        $this->load->model('Payment_methods_model', 'pay_md');
    }


    public function index(){
        $data['title'] = 'Checkout';

        $categories = new Category_model();
        $data['lists'] = $categories->join();
        $data['categories'] = category_tree($data['lists']);

        $del_methods = new Delivery_methods_model();
        $data['del_methods'] = $del_methods->select_all();

        $pay_methods = new Payment_methods_model();
        $data['pay_methods'] = $pay_methods->select_all();

        $this->load->frontend('checkout', $data);


    }

}




