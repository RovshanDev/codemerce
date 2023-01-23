<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Category_model', 'cat_md');
        $this->load->model('Products_model', 'product_md');
    }


    public function index(){
        $data['title'] = 'Cart';

        $categories = new Category_model();

        $data['lists'] = $categories->join();

        $data['categories'] = category_tree($data['lists']);

        $this->load->frontend('cart', $data);
    }

    public function add_to_cart(){
        if($this->input->is_ajax_request()){
            $id = $this->security->xss_clean($this->input->post('id'));
            $quantity = $this->security->xss_clean($this->input->post('quantity'));

            $product = $this->product_md->selectDataById($id);
            if(!empty($product)){
                if(!empty(get_cookie('cart_products'))){
                    $cart_products = explode(',',get_cookie('cart_products'));
                    array_push($cart_products,$id);
                    $cart_product = implode(',',$cart_products);
                    set_cookie('cart_products',$cart_product,86400);
                }else{
                    $cart_products[] = $id;
                    $cart_product = implode(',',$cart_products);
                    set_cookie('cart_products',$cart_product,86400);
                }

                echo json_encode(['process' => true]);
            }
        }

    }



}



