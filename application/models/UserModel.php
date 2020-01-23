<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
    class UserModel extends CI_Model {
        
        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        public function login($email,$password)
        {
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
                return json_encode(array('status'=>1,'data'=>$query->result()));
            }
            else
            {
                return json_encode(array('status'=>2));
            }
        }

        public function productStore() // add product in database
        {
            $publishStatus = 0;
            $shopifyStatus = 0;

            if($_POST['publish'] == "on")
            {
                $publishStatus = 1;
            }

            if($_POST['shopify'] == "on")
            {
                $shopifyStatus = 1;
            }

            $productDetails     = array(

                'title'         => $_POST['product_name'],
                'product_type'  => $_POST['product_type'],
                'vendor'        => $_POST['vendor'],
                'created_at'    => date('Y-m-d H:i:s'),
                'tags'          => $_POST['tags'],
                'published'     => $publishStatus,
                'shopify'       => $shopifyStatus,
                'price'         => $_POST['price'],
                'variants'      => $_POST['variant']
            );

            if(!empty($_FILES))
            {
                $new=time().".".strtolower(pathinfo($_FILES['productImage']['name'],PATHINFO_EXTENSION));

                $config['upload_path'] = './assests/productImageShopify/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['file_name'] = $new;
                $config['max_size'] = 2048;

                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                if($this->upload->do_upload('productImage'))
                {
                    $uploadData = $this->upload->data();
                    $productDetails['images'] = $new;
                }
                else
                {
                    return json_encode(array('status'=>0,'message'=>$this->upload->display_errors()));
                    exit();
                }
            }

            $query = $this->db->insert('product',$productDetails);
            
            if($query)
            {
                $product_id = $this->db->insert_id();
                if($_POST['shopify'] == "on")
                {
                    unset($productDetails['created_at']);
                    unset($productDetails['shopify']);
                    unset($productDetails['images']);
                    $productDetails['published'] == "on" ? true :false;
                    $productDetails['body_html'] = "Good snowboard";

                    $productDetails['images'] = [array("images"=>base_url('assests/productImageShopify/').$uploadData['file_name'])];
                    
                    $data = array("product"=>$productDetails);

                    $response = json_decode($this->addProductToShopify($data));

                    $this->db->set('shopify_id',$response->product->id)->where('id',$product_id); 
                    $this->db->update('product');
                }
                return json_encode(array('status'=>1));
            }
            else
            {
                return json_encode(array('status'=>0));
            }
        }

        public function addProductToShopify($productDetails) // product store in shopify using curl
        {
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

        public function synchWithShopify() // synch all product in shopify
        {
            $response = json_decode($this->getShopifyProductDetailList());
            $counter  = 0;
            foreach ($response->products as $key => $value)
            {
                $query = $this->db->select('*')->from('product')->where('product.shopify_id', $value->id)->get();
        
                $productDetails     =  array(
                    'shopify_id'    => $value->id,
                    'title'         => $value->title,
                    'product_type'  => $value->product_type,
                    'vendor'        => $value->vendor,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'tags'          => $value->tags,
                    'published'     => !empty($value->published_at) ? 1:0,
                    'shopify'       => 1,
                    'price'         => $value->variants[0]->price
                );

                if($query->num_rows() > 0)
                {
                    $this->db->set($productDetails)->where('shopify_id', $query->row()->id); 
                    $this->db->update('product');
                }
                else
                {
                    $query = $this->db->insert('product',$productDetails);
                }
            }
            return json_encode(array('status'=>1,'data'=>$response));
        }

        public function getShopifyProductDetailList()
        {
            $url = "https://".$this->config->item('SHOPIFY_API_KEY').":".$this->config->item('SHOPIFY_PASSWORD')."@".$this->config->item('SHOPIFY_SHOP')."/admin/products.json";

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_VERBOSE,0);
            curl_setopt($curl, CURLOPT_HEADER,false);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            //curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($productDetails));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
            if (curl_errno($curl)) 
            {
                return 'Error:' . curl_error($curl);
            }   
            curl_close ($curl);

            return $response;
        }

        public function deleteProduct($productId)
        {
            if($productId!="")
            {
                $where = "";
                $where = "shopify_id ='".$productId."'";

                $productData= $this->tableData('product',$where);
                $productImage = $productData[0]['images']; // imageName for unlink

                if($productImage !="") // remove image from folder
                {
                    unlink("./assests/productImageShopify/".$productImage);
                }

                $this->db->where('shopify_id',$productId);

                if($this->db->delete('product'))
                {
                    return json_encode(array('status'=>1));
                }
                else
                {
                    return json_encode(array('status'=>2));
                }
            }
            else
            {
                return json_encode(array('status'=>3));
            }
        }

        public function getProductDataById($productId) // get product data
        {
            $query = $this->db->select('*')->from('product')->where('shopify_id', $productId)->get();
              
            if($query->num_rows() > 0)
            {
                return json_encode(array('status'=>1,'data'=>$query->result()[0]));
            }
            else
            {
                return json_encode(array('status'=>0));
            }
        }

        public function updateProduct()
        {
            $publishStatus = 0;
            $shopifyStatus = 0;

            if($_POST['publish'] == "on")
            {
                $publishStatus = 1;
            }

            if($_POST['shopify'] == "on")
            {
                $shopifyStatus = 1;
            }

            // flag = 0 // if image not uploaded
            // flag = 1 // if image is uploaded so remove old image from folder

            $flag = 0;

            $productDetails =  array( 
                                'title'         => $_POST['product_name'],
                                'product_type'  => $_POST['product_type'],
                                'vendor'        => $_POST['vendor'],
                                'created_at'    => date('Y-m-d H:i:s'),
                                'tags'          => $_POST['tags'],
                                'published'     => $publishStatus,
                                'shopify'       => $shopifyStatus,
                                'price'         => $_POST['price'],
                                'variants'      => $_POST['variant']
                            );
           
            if ($_FILES['productImage']['name'] != "") // if image is uploaded
            {
                $new=time().".".strtolower(pathinfo($_FILES['productImage']['name'],PATHINFO_EXTENSION));

                $config['upload_path'] = './assests/productImageShopify/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['file_name'] = $new;
                $config['max_size'] = 2048;

                $this->load->library('upload',$config);
                $this->upload->initialize($config);

                if($this->upload->do_upload('productImage'))
                {
                    $uploadData = $this->upload->data();
                    $productDetails['images'] = $new;
                    $flag = 1;
                }
                else
                {
                    return json_encode(array('status'=>0,'message'=>$this->upload->display_errors()));
                    exit();
                }
            }
            else
            {
                $productDetails['images'] = $_POST['old_image'];
                $flag = 0;
            }
            
            $this->db->set($productDetails)->where('shopify_id', $_POST['productId']); 
            
            if($this->db->update('product'))
            {
                if($flag == 1 && $_POST['old_image'] !="") // remove image from folder
                {
                    unlink("./assests/productImageShopify/".$_POST['old_image']);
                }
                return json_encode(array('status'=>1));
            }
            else
            {
                return json_encode(array('status'=>0));
            }
        }
    }