<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
    class UserModel extends CI_Model {
        
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

        public function login($email,$password){
            $this->db->select('*');
            $this->db->from('admin_users');
            $this->db->where('email',$email);
            $this->db->where('password',$password);
            $this->db->where('isDeleted',1); //1= acitve; 0=inactive
            return $this->db->get()->result_array();
        }

        public function tableData($tableName,$where=NULL)
        {
            $this->db->select('*');
            $this->db->from($tableName);

            if($where!="") //return specific where data otherwise return table's all data
            {
                $this->db->where($where);
            }

            return $this->db->get()->result_array();
        }

        public function insertData($tableName,$data)
        {
            return $this->db->insert($tableName,$data);
        }

        public function updateData($tableName,$data)
        {
            return $this->db->update($tableName,$data);
        }

        // shopify product list
        public function getProductListWithDetail()
        {   
            $query = $this->db->select('*')->from('product')->order_by('product.id','DESC')->get();         
            if($query->num_rows() > 0)
            {
                return json_encode(array('status'=>1,'message'=>'success','data'=>$query->result()));
            }
            else
            {
                return json_encode(array('status'=>2,'message'=>'No record Found'));
            }
        }
    
        // Add produt in shopify
        public function productStore(){

                $productDetails     =   array(

                    'title'         =>$_REQUEST['product_name'],
                    'product_type'  =>$_REQUEST['product_type'],
                    'vendor'        =>$_REQUEST['vendor'],
                    'created_at'    =>date('Y-m-d H:i:s'),
                    'tags'          =>$_REQUEST['tags'],
                    'published'     =>$_REQUEST['publish'],
                    'shopify'       =>$_REQUEST['shopify'],
                    'price'         =>$_REQUEST['price'],
                    'variants'      =>$_REQUEST['variant']
                );           

                /*if(!empty($_FILES)){
                    $uploadData                     = array();
                    $config['upload_path']          = './assets/img/product_img/';
                    $config['allowed_types']        = 'gif|jpg|png|svg';
                    $config['max_size']             = 5120;
                    $config['max_width']            = 1900;
                    $config['max_height']           = 1900;
                    $config['encrypt_name']         = true;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('file'))
                    {                   
                        return  json_encode(array('status'=>0,'message'=>$this->upload->display_errors()));
                    }
                    else
                    {
                        $uploadData = $this->upload->data();
                        $flag       = true;
                        $productDetails['image'] = !empty($uploadData)?$uploadData['file_name']:'';
                    }
                }*/

                $query = $this->db->insert('product',$productDetails);
                
                if($query){

                    $product_id = $this->db->insert_id();
                    if($_REQUEST['shopify']==1){
                        unset($productDetails['created_at']);
                        unset($productDetails['shopify']);
                        unset($productDetails['images']);
                        $productDetails['published'] == 1 ? true :false;
                        $productDetails['body_html'] = "Good snowboard";

                        $productDetails['images'] = [array("images"=>base_url('assets/img/product_img/').$uploadData['file_name'])];

                        
                        $data = array("product"=>$productDetails);

                        $response = json_decode($this->addProductToShopify($data));

                        $this->db->set('shopify_id',$response->product->id)->where('id',$product_id);   
                        $this->db->update('product');
                    }

                    return  json_encode(array('status'=>1,'message'=>'Product Insert Successfully'));
                    
                }else{
                    return  json_encode(array('status'=>0,'message'=>'product Insert Failed'));
                }       
              
        }

        public function addProductToShopify($productDetails){
    
            $url = "https://".$this->config->item('SHOPIFY_API_KEY').":".$this->config->item('SHOPIFY_PASSWORD')."@".$this->config->item('SHOPIFY_SHOP')."/admin/products.json";
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_VERBOSE,0);
            curl_setopt($curl, CURLOPT_HEADER,false);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($productDetails));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
            if (curl_errno($curl)) {
                return 'Error:' . curl_error($curl);
            }   
            curl_close ($curl);
        
            return $response;
        }
    }