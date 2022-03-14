<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Services extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(2)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->model('services_model', 'services');
        $this->load->model('batches_model', 'batches');
        $this->load->model('categories_model');
        $this->load->model('products_model', 'products');
        $this->load->library("Custom");
        $this->li_a = 'stock';

    }

    public function index()
    {
        $head['title'] = "Services";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('services/services');
        $this->load->view('fixed/footer');
    }

    public function batch()
    {
        $head['title'] = "Batches";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('services/batch');
        $this->load->view('fixed/footer');
    }

    public function service_list()
    {
        //ini_set('display_errors', 1);
        $catid = $this->input->get('id');
        $sub = $this->input->get('sub');
        // echo $catid; 
        if ($catid > 0) {
            $list = $this->services->get_datatables($catid, '', $sub);
        } else {
            $list = $this->services->get_datatables();
        }
        // echo print_r($list);
        // echo json_encode($list);
        // exit();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $no;
            $pid = $prd->pid;
            $row[] = '<a href="#" data-object-id="' . $pid . '" class="view-object"><span class="avatar-lg align-baseline"><img src="' . base_url() . 'userfiles/product/thumbnail/' . $prd->image . '" ></span>&nbsp;' . $prd->service_name . '</a>';
            $row[] = $prd->service_code;
            $row[] = $prd->c_title;
            // $row[] = $prd->title;
            $row[] = amountExchange($prd->service_price, 0, $this->aauth->get_user()->loc);
            // <a href="#" data-object-id="' . $pid . '" class="btn btn-success  btn-sm  view-object"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> 
            $row[] = '
<div class="btn-group">
                                    <button type="button" class="btn btn btn-primary dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i>  </button>
                                    <div class="dropdown-menu">
&nbsp;<a href="' . base_url() . 'services/edit?id=' . $pid . '"  class="btn btn-purple btn-sm"><span class="fa fa-edit"></span>' . $this->lang->line('Edit') . '</a><div class="dropdown-divider"></div>&nbsp;<a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span>' . $this->lang->line('Delete') . '</a>
                                    </div>
                                </div>';
                                // <button type="button" class="btn btn-indigo dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i>  ' . $this->lang->line('Print') . '</button>
                                // <div class="dropdown-menu">
                                //     <a class="dropdown-item" href="' . base_url() . 'services/barcode?id=' . $pid . '" target="_blank"> ' . $this->lang->line('BarCode') . '</a><div class="dropdown-divider"></div> <a class="dropdown-item" href="' . base_url() . 'services/posbarcode?id=' . $pid . '" target="_blank"> ' . $this->lang->line('BarCode') . ' - Compact</a> <div class="dropdown-divider"></div>
                                //          <a class="dropdown-item" href="' . base_url() . 'services/label?id=' . $pid . '" target="_blank"> ' . $this->lang->line('Service') . ' Label</a><div class="dropdown-divider"></div>
                                //      <a class="dropdown-item" href="' . base_url() . 'services/poslabel?id=' . $pid . '" target="_blank"> Label - Compact</a></div></div> <div class="btn-group">            
                                $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->services->count_all($catid, '', $sub),
            "recordsFiltered" => $this->services->count_filtered($catid, '', $sub),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function batch_list()
    {
        // ini_set('display_errors', 1);
        $catid = $this->input->get('id');
        $sub = $this->input->get('sub');
        $list = $this->batches->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            // Total
            // Dead
            // Current(get from product)
            // Sold = total - (Dead - current)

            $no++;
            $row = array();
            $row[] = $no;
            $pid = $prd->id;
            $row[] = '<a href="#" data-object-id="' . $pid . '" class="view-object">&nbsp;' . $prd->name . '</a>';
            $row[] = amountExchange($prd->price, 0, $this->aauth->get_user()->loc);
            $row[] = $prd->qty;
            $row[] = $prd->dead_items;
            $row[] = $prd->qty - ( $prd->dead_items + $prd->prod_qty );

            $row[] = '
<div class="btn-group">
                                    <button type="button" class="btn btn btn-primary dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i>  </button>
                                    <div class="dropdown-menu">
&nbsp;<a href="' . base_url() . 'services/edit_batch?id=' . $pid . '"  class="btn btn-purple btn-sm"><span class="fa fa-edit"></span>' . $this->lang->line('Edit') . '</a><div class="dropdown-divider"></div>&nbsp;<a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span>' . $this->lang->line('Delete') . '</a>
                                    </div>
                                </div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->batches->count_all($catid, '', $sub),
            "recordsFiltered" => $this->batches->count_filtered($catid, '', $sub),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function add()
    {
        $head['title'] = "Services";
        $data['cat'] = $this->categories_model->service_category_list();
        // $data['units'] = $this->services->units();
        $data['warehouse'] = $this->categories_model->warehouse_list();
        // $data['custom_fields'] = $this->custom->add_fields(4);
        $this->load->model('units_model', 'units');
        $data['variables'] = $this->units->variables_list();
        $head['title'] = "Add Service";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('services/service-add', $data);
        $this->load->view('fixed/footer');
    }

    public function add_batch()
    {
        $data['cat'] = "";
        $head['title'] = "Batches";
        $head['title'] = "Add Batch";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('services/batch-add', $data);
        $this->load->view('fixed/footer');
    }

    public function edit_batch()
    {
        $head['title'] = "Batches";
        $head['title'] = "Edit Batch";
        $head['usernm'] = $this->aauth->get_user()->username;
        $id = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('geopos_batches');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $data['batch'] = $query->row_array();

        $this->load->view('fixed/header', $head);
        $this->load->view('services/batch-edit', $data);
        $this->load->view('fixed/footer');

    }

    // 
    public function addBatch()
    {
        $product_name = $this->input->post('product_name', true);
        $catid = 10;//$this->input->post('product_cat');
        $warehouse = 1;//$this->input->post('product_warehouse');
        $product_code = $this->input->post('product_code');
        $product_price = numberClean($this->input->post('product_price'));
        $factoryprice = numberClean($this->input->post('fproduct_price'));
        $taxrate = 0;//numberClean($this->input->post('product_tax', true));
        $disrate = 0;//numberClean($this->input->post('product_disc', true));
        $product_qty = numberClean($this->input->post('qty', true));
        $product_qty_alert = numberClean($this->input->post('product_qty_alert'));
        $product_desc = "";//$this->input->post('product_desc', true);
        $image = "default.png";//$this->input->post('image');
        $unit = "";//$this->input->post('unit', true);
        $barcode = "";//$this->input->post('barcode');
        $v_type = "";//$this->input->post('v_type');
        $v_stock = "";//$this->input->post('v_stock');
        $v_alert = "";//$this->input->post('v_alert');
        $w_type = "";//$this->input->post('w_type');
        $w_stock = "";//$this->input->post('w_stock');
        $w_alert = "";//$this->input->post('w_alert');
        $wdate = "";//datefordatabase($this->input->post('wdate'));
        $code_type = "";//$this->input->post('code_type');
        $sub_cat = $this->input->post('sub_cat');
        $brand = "";//$this->input->post('brand');
        $serial = "";//$this->input->post('product_serial');
        $daily_feed = $this->input->post('daily_feed');
        
        $pid = $this->products->addBatchProduct($catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode, $v_type, $v_stock, $v_alert, $wdate, $code_type, $w_type, $w_stock, $w_alert, $sub_cat, $brand, $serial, $daily_feed);
        // var_dump($product_response);
        // $resp = json_decode($product_response);
        // // echo "11111".$resp;
        // var_dump($resp);

        // if($resp->status == "Success"){
        //     $pid = $resp->pid;
        // } else $pid = 0;
        // ini_set('display_error', 1);
        $name = $this->input->post('name', true);
        // $catid = $this->input->post('pcat');
        $warehouse = 0;//$this->input->post('warehouse');
        $code = $this->input->post('code');
        $qty = $this->input->post('qty');
        $price = numberClean($this->input->post('price'));
        // $taxrate = numberClean($this->input->post('tax', true));
        // $disrate = numberClean($this->input->post('disc', true));
        $desc = $this->input->post('des', true);
        $image = $this->input->post('image');
        // $barcode = $this->input->post('barcode');
        $wdate = "";//datefordatabase($this->input->post('wdate'));
        // $code_type = $this->input->post('code_type');
        $sub_cat = 0;//$this->input->post('sub_cat');
        $this->batches->addnew($pid, $name, $code, $price, $qty, $desc);
    }

    public function editBatch()
    {
        // print_r($_POST); exit();
        $pid = $this->input->post('pid', true);
        $id = $this->input->post('id', true);
        // ini_set('display_error', 1);
        $name = $this->input->post('name', true);
        $code = $this->input->post('code');
        $qty = $this->input->post('qty');
        $price = numberClean($this->input->post('price'));
        $dead = numberClean($this->input->post('dead'));
        $dead_item = numberClean($this->input->post('dead_item'));
        $desc = $this->input->post('des', true);
        // $image = $this->input->post('image');
        // $sub_cat = 0;//$this->input->post('sub_cat');
        $product = $this->products->getProduct($pid);
        // print_r($product); exit();
        $new_qty = $product['qty'] - $dead_item;
        $new_price = $price/$new_qty;
        // echo $new_qty . "  ";
        $product = $this->products->updateProductQty($pid, $new_qty, $new_price);
        // $dead = ($dead == "On") ? 1 : 0;
        $this->batches->edit($id, $pid, $name, $code, $price, $qty, $desc, $dead, $dead_item);
    }

    public function deleteBatch()
    {
        if ($this->aauth->premission(11)) {
            $id = $this->input->post('deleteid');
            if ($id) {
                $this->db->delete('geopos_batches', array('id' => $id));
                // $this->db->delete('geopos_services', array('sub' => $id, 'merge' => 1));
                // $this->db->delete('geopos_movers', array('d_type' => 1, 'rid1' => $id));
                // $this->db->set('merge', 0);
                // $this->db->where('sub', $id);
                // $this->db->update('geopos_services');
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }


    public function addservice()
    {
        // ini_set('display_error', 1);
        $service_name = $this->input->post('service_name', true);
        $catid = $this->input->post('pcat');
        $warehouse = 0;//$this->input->post('service_warehouse');
        $service_code = $this->input->post('service_code');
        $service_price = numberClean($this->input->post('service_price'));
        $taxrate = numberClean($this->input->post('service_tax', true));
        $disrate = numberClean($this->input->post('service_disc', true));
        $service_desc = $this->input->post('service_desc', true);
        $image = $this->input->post('image');
        $barcode = $this->input->post('barcode');
        $wdate = "";//datefordatabase($this->input->post('wdate'));
        $code_type = $this->input->post('code_type');
        $sub_cat = 0;//$this->input->post('sub_cat');
        if ($catid) {
            $this->services->addnew($catid, $warehouse, $service_name, $service_code, $service_price, $taxrate, $disrate, $service_desc, $image,  $barcode,  $wdate, $code_type, $sub_cat);
        }
    }


    public function edit()
    {
        $pid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('geopos_services');
        $this->db->where('pid', $pid);
        $query = $this->db->get();
        $data['service'] = $query->row_array();
        // print_r($data);

        // $data['cat_ware'] = $this->categories_model->cat_ware($pid);
        $data['cat_sub'] = $this->categories_model->sub_cat_curr($data['service']['sub_id']);
        $data['cat_sub_list'] = $this->categories_model->sub_cat_list($data['service']['pcat']);
        // $data['warehouse'] = $this->categories_model->warehouse_list();
        $data['cat'] = $this->categories_model->service_category_list();
        $head['title'] = "Edit Service";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->model('units_model', 'units');
        $data['variables'] = $this->units->variables_list();
        $this->load->view('fixed/header', $head);
        $this->load->view('services/service-edit', $data);
        $this->load->view('fixed/footer');

    }

    public function editservice()
    {
        // ini_set('display_error', 1);
        // echo json_encode($_POST);
        $pid = $this->input->post('pid');
        $service_name = $this->input->post('service_name', true);
        $catid = $this->input->post('pcat');
        $warehouse = 0;//$this->input->post('service_warehouse');
        $service_code = $this->input->post('service_code');
        $service_price = numberClean($this->input->post('service_price'));
        $taxrate = numberClean($this->input->post('service_tax', true));
        $disrate = numberClean($this->input->post('service_disc', true));
        $service_desc = $this->input->post('service_desc', true);
        $image = $this->input->post('image');
        $barcode = $this->input->post('barcode');
        $wdate = datefordatabase($this->input->post('wdate'));
        $code_type = $this->input->post('code_type');
        $sub_cat = 0;//$this->input->post('sub_cat');
        $this->services->edit($pid, $catid, $warehouse, $service_name, $service_code, $service_price, $taxrate, $disrate, $service_desc, $image,  $barcode,  $wdate, $code_type, $sub_cat);
 
    }

    public function delete_i()
    {
        if ($this->aauth->premission(11)) {
            $id = $this->input->post('deleteid');
            if ($id) {
                $this->db->delete('geopos_services', array('pid' => $id));
                // $this->db->delete('geopos_services', array('sub' => $id, 'merge' => 1));
                // $this->db->delete('geopos_movers', array('d_type' => 1, 'rid1' => $id));
                // $this->db->set('merge', 0);
                // $this->db->where('sub', $id);
                // $this->db->update('geopos_services');
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }


}