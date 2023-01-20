<?php

class Products_model extends CI_Model {

    public $title;
    public $description;
    public $quantity;
    public $price;
    public $brand_id;
    public $status ;
    public $created_at ;
    public $updated_at;


    protected $table = 'products';

    public function join(){
        $this->db->select('p.*, b.title as brand_title,b.logo as brand_logo,i.path as image_path,i.product_id as img_pr_id');
        $this->db->from('products p');
        $this->db->join('brands b', 'p.brand_id=b.id', 'left');
        $this->db->join('images i', 'i.product_id=p.id', 'left');
        $query = $this->db->get()->result();

        return $query;

    }

    public function insert($data){
        // $data = array(
        //         'fullname' => $this->fullname,
        //         'password' => $this->password,
        //         'email' => $this->email,
        //         'status' => $this->status
        // );

        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }

    public function select_all(){
        $query = $this->db->get($this->table);

        return $query->result();
    }

    public function selectDataById($id){
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);

        return $query->row();
    }



    public function update($id,$data){
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }

    public function delete($id){
        $this -> db -> where('id', $id);
        $this -> db -> delete($this->table);
    }

}

