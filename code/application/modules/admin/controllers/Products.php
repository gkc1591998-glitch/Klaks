<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
class Products extends CI_Controller
{
  public $headerPage = 'admin_header';
  public $addPage    = 'products-add';
  public $editPage   = 'products-edit';
  public $listPage   = 'products';
  public $listPage_redirect = '/admin/Products';
  public $addPage_redirect  = '/admin/Products/add/';
  public $editPage_redirect = '/admin/Products/edit/';

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Products_model', 'my_model');
    $this->load->model('Variant_model', 'variant_model');
    $this->load->model('Section_model', 'section_model');
    $this->load->model('Price_model', 'price_model');
    $this->load->model('Size_model', 'size_model');
    $this->load->model('Color_model', 'color_model');
    $this->load->model('Coupon_model', 'coupon_model');
    $this->load->model('Category_model', 'category_model');
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    error_reporting(-1);
    ini_set('display_errors', 'on');
  }
  public function index()
  {
    $data['record'] = $this->my_model->get_all_records();
    // echo '<pre>'; print_r($data['record']); exit; 
    $this->load->view($this->headerPage);
    $this->load->view($this->listPage, $data);
  }
  public function add()
  {
    $data['sections'] = $this->section_model->get_all();
    $data['prices'] = $this->price_model->get_all();
    $data['sizes'] = $this->size_model->get_all();
    $data['colors'] = $this->color_model->get_all();
    $data['coupons'] = $this->coupon_model->get_all();
    $data['maincat'] = $this->category_model->get_all_records();
    $data['msg'] = '';

    if ($this->input->post('submit') != '') {
      // Handle file uploads for images[] (attributes[image][]) structure
      $uploadedImages = [];
      if (isset($_FILES['attributes']['name']['image']) && is_array($_FILES['attributes']['name']['image'])) {
        $imageCount = count($_FILES['attributes']['name']['image']);
        for ($idx = 0; $idx < $imageCount; $idx++) {
          if (!empty($_FILES['attributes']['name']['image'][$idx])) {
            $_FILES['single_image']['name'] = $_FILES['attributes']['name']['image'][$idx];
            $_FILES['single_image']['type'] = $_FILES['attributes']['type']['image'][$idx];
            $_FILES['single_image']['tmp_name'] = $_FILES['attributes']['tmp_name']['image'][$idx];
            $_FILES['single_image']['error'] = $_FILES['attributes']['error']['image'][$idx];
            $_FILES['single_image']['size'] = $_FILES['attributes']['size']['image'][$idx];

            $config['upload_path'] = './images/products/';
            $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
            $config['max_size']  = '0';
            $config['max_width']  = '0';
            $config['max_height']  = '0';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('single_image')) {
              $uploadedImages[$idx] = '';
            } else {
              $fileData = $this->upload->data();
              // $config_image = array(
              //     'image_library' => 'gd2',
              //     'source_image' => './images/products/'.$fileData['file_name'],
              //     'new_image' => './images/products/'.$fileData['file_name'],
              //     'width' => 800,
              //     'height' => 800,
              //     'maintain_ratio' => FALSE,
              //     'rotate_by_exif' => TRUE,
              //     'strip_exif' => TRUE,
              //     'master_dim'=>'auto',
              // );
              // $this->load->library('image_lib', $config_image);
              // $this->image_lib->initialize($config_image);
              // $this->image_lib->resize();
              // $this->image_lib->clear();
              $uploadedImages[$idx] = $fileData['file_name'];
            }
          }
        }
      }
      // Prepare attributes array for model
      $attributes_post = $this->input->post('attributes');
      $sections = $attributes_post['section_id'] ?? [];
      $prices = $attributes_post['price_id'] ?? [];
      $sizes = $attributes_post['size_id'] ?? [];
      $colors = $attributes_post['color_id'] ?? [];
      $coupons = $attributes_post['coupon_id'] ?? [];
      $attributes = [];
      $attrCount = is_array($sections) ? count($sections) : 0;
      for ($i = 0; $i < $attrCount; $i++) {
        $attributes[] = [
          'section_id' => isset($sections[$i]) ? $sections[$i] : null,
          'price_id'   => isset($prices[$i]) ? $prices[$i] : null,
          'size_id'    => isset($sizes[$i]) ? $sizes[$i] : null,
          'color_id'   => isset($colors[$i]) ? $colors[$i] : null,
          'coupon_id'  => isset($coupons[$i]) ? $coupons[$i] : null,
          'image'      => isset($uploadedImages[$i]) ? $uploadedImages[$i] : ''
        ];
      }
      // Pass attributes array directly to model
      $result = $this->my_model->add_record($attributes);
      if ($result) {
        $this->session->set_flashdata('msg_succ', 'Added Successfully...');
        redirect($this->listPage_redirect);
      } else {
        $this->session->set_flashdata('msg_succ', 'Please Try Again...');
        redirect($this->listPage_redirect);
      }
    }
    $this->load->view($this->headerPage);
    $this->load->view($this->addPage, $data);
  }

  public function edit($id)
  {
    $data['sections'] = $this->section_model->get_all();
    $data['prices'] = $this->price_model->get_all();
    $data['sizes'] = $this->size_model->get_all();
    $data['colors'] = $this->color_model->get_all();
    $data['coupons'] = $this->coupon_model->get_all();
    $data['maincat'] = $this->category_model->get_all_records();
    $data['record'] = $this->my_model->get_single_record($id);
    $data['quantityprice'] = $this->my_model->get_groups_data($id);
    $data['product_attributes'] = $this->my_model->get_product_attributes($id);
    $data['msg'] = '';
    if ($this->input->post('submit') != '') {
      // Handle file uploads for images[] (attributes[image][]) structure
      $uploadedImages = [];
      if (isset($_FILES['attributes']['name']['image']) && is_array($_FILES['attributes']['name']['image'])) {
        $imageCount = count($_FILES['attributes']['name']['image']);
        for ($idx = 0; $idx < $imageCount; $idx++) {
          if (!empty($_FILES['attributes']['name']['image'][$idx])) {
            $_FILES['single_image']['name'] = $_FILES['attributes']['name']['image'][$idx];
            $_FILES['single_image']['type'] = $_FILES['attributes']['type']['image'][$idx];
            $_FILES['single_image']['tmp_name'] = $_FILES['attributes']['tmp_name']['image'][$idx];
            $_FILES['single_image']['error'] = $_FILES['attributes']['error']['image'][$idx];
            $_FILES['single_image']['size'] = $_FILES['attributes']['size']['image'][$idx];

            $config['upload_path'] = './images/products/';
            $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
            $config['max_size']  = '0';
            $config['max_width']  = '0';
            $config['max_height']  = '0';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('single_image')) {
              $uploadedImages[$idx] = '';
            } else {
              $fileData = $this->upload->data();
              // $config_image = array(
              //     'image_library' => 'gd2',
              //     'source_image' => './images/products/'.$fileData['file_name'],
              //     'new_image' => './images/products/'.$fileData['file_name'],
              //     'width' => 800,
              //     'height' => 800,
              //     'maintain_ratio' => FALSE,
              //     'rotate_by_exif' => TRUE,
              //     'strip_exif' => TRUE,
              //     'master_dim'=>'auto',
              // );
              // $this->load->library('image_lib', $config_image);
              // $this->image_lib->initialize($config_image);
              // $this->image_lib->resize();
              // $this->image_lib->clear();
              // Only delete old image after successful upload
              if (!empty($data['record']['image']) && file_exists(FCPATH . 'images/products/' . $data['record']['image'])) {
                @unlink(FCPATH . 'images/products/' . $data['record']['image']);
              }
              $uploadedImages[$idx] = $fileData['file_name'];
            }
          } else {
            // If not uploaded, keep the old image if exists
            $uploadedImages[$idx] = isset($data['product_attributes'][$idx]['image']) ? $data['product_attributes'][$idx]['image'] : '';
          }
        }
      }
      // Prepare attributes array for model
      $attributes_post = $this->input->post('attributes');
      $sections = $attributes_post['section_id'] ?? [];
      $prices = $attributes_post['price_id'] ?? [];
      $sizes = $attributes_post['size_id'] ?? [];
      $colors = $attributes_post['color_id'] ?? [];
      $coupons = $attributes_post['coupon_id'] ?? [];
      $attributes = [];
      $attrCount = is_array($sections) ? count($sections) : 0;
      for ($i = 0; $i < $attrCount; $i++) {
        $attributes[] = [
          'section_id' => isset($sections[$i]) ? $sections[$i] : null,
          'price_id'   => isset($prices[$i]) ? $prices[$i] : null,
          'size_id'    => isset($sizes[$i]) ? $sizes[$i] : null,
          'color_id'   => isset($colors[$i]) ? $colors[$i] : null,
          'coupon_id'  => isset($coupons[$i]) ? $coupons[$i] : null,
          'image'      => isset($uploadedImages[$i]) ? $uploadedImages[$i] : ''
        ];
      }
      // Pass attributes array directly to model
      $result = $this->my_model->update_record(
        $id,
        $attributes
      );
      if ($result) {
        $this->session->set_flashdata('msg_succ', 'Updated Successfully...');
        redirect($this->listPage_redirect);
      } else {
        $this->session->set_flashdata('msg_succ', 'Please Try Again...');
        redirect($this->listPage_redirect);
      }
    }
    $data['maincat'] = $this->my_model->get_cat();
    $data['discounts'] = $this->my_model->get_discounts();
    $data['subcat'] = $this->my_model->get_all_cities_ajax($data['record']['cat_id']);
    $data['childcat'] = $this->my_model->get_all_areas_ajax($data['record']['subcat_id']);
    $data['brands'] = $this->my_model->get_brands();
    $this->load->view($this->headerPage);
    $this->load->view($this->editPage, $data);
  }
  public function delete($id)
  {
    $data['msg'] = '';
    if ($id) {
      $result = $this->my_model->delete_record($id);
      if ($result) {
        $this->session->set_flashdata('msg_succ', 'Deleted Successfully...');
        redirect($this->listPage_redirect);
      } else {
        $data['msg'] = "Not Deleted...";
      }
    }
  }
  public function getcities()
  {
    $city_id =  $this->input->post('valu');
    $cities = $this->my_model->get_all_cities_ajax($city_id);
    $selBox = '<option value="">---Select Subcategory---</option>';
    foreach ($cities as $key => $value) {

      $selBox .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
    }

    echo $selBox;
  }
  public function getareas()
  {
    $area_id =  $this->input->post('valu');
    $areas = $this->my_model->get_all_areas_ajax($area_id);
    //echo "<pre>";print_r($areas);exit;	
    $selBox = '<option value="">---Select Child category---</option>';
    foreach ($areas as $key => $value) {
      $selBox .= '<option value="' . $value['id'] . '">' . $value['child_category_name'] . '</option>';
    }
    echo $selBox;
  }
  public function delete_selected()
  {
    $data['msg'] = '';
    if ($this->input->post('selected_ids') != '') {
      $delete_ids = $this->input->post('selected_ids');
      for ($i = 0; $i < count($delete_ids); $i++) {
        $result = $this->my_model->delete_record($delete_ids[$i]);
      }
      if ($result) {
        $this->session->set_flashdata('msg_succ', 'Deleted Successfully...');
        redirect($this->listPage_redirect);
      } else {
        $this->session->set_flashdata('msg_succ', 'Not Deleted...');
        redirect($this->listPage_redirect);
      }
    } else {
      $this->session->set_flashdata('msg_succ', 'Select any Check Box...');
      redirect($this->listPage_redirect);
    }
  }

  public function hstatus($id, $status)
  {
    $statu = ($status == 1 ? 'Deactive' : 'Active');
    if ($id) {
      $result = $this->my_model->hstatus_record($id, $status);
      if ($result) {
        $this->session->set_flashdata('msg_succ', $statu . ' Successfully...');
        redirect(site_url() . "admin/products");
      } else {
        $this->session->set_flashdata('msg_fail', 'Try again...');
        redirect(site_url() . "admin/products");
      }
    }
  }

  public function updateSellingCategory($id, $status)
  {
    if ($id && $status) {

      $newValue = str_replace('_', ',', $status);
      // echo $id ." ". $status;
      $result = $this->my_model->updateSellingCategory($id, $newValue);
      if ($result) {
        echo "success";
        // $this->session->set_flashdata('msg_succ', $statu.' Successfully...');
        // redirect(site_url()."admin/products");
      } else {
        echo "fail";
        // $this->session->set_flashdata('msg_fail', 'Try again...');
        // redirect(site_url()."admin/products");
      }
    }
  }
  public function status($id, $status)
  {

    $statu = ($status == 1 ? 'Deactive' : 'Active');
    if ($id) {
      $result = $this->my_model->status_record($id, $status);
      if ($result) {
        $this->session->set_flashdata('msg_succ', $statu . ' Successfully...');
        redirect(site_url() . "admin/products");
      } else {
        $this->session->set_flashdata('msg_fail', 'Try again...');
        redirect(site_url() . "admin/products");
      }
    }
  }

  public function lux_status($id, $status)
  {

    $statu = ($status == 1 ? 'Deactive' : 'Active');
    if ($id) {
      $result = $this->my_model->lux_status_record($id, $status);
      if ($result) {
        $this->session->set_flashdata('msg_succ', $statu . ' Successfully...');
        redirect(site_url() . "admin/products");
      } else {
        $this->session->set_flashdata('msg_fail', 'Try again...');
        redirect(site_url() . "admin/products");
      }
    }
  }

  public function manage_video($product_id)
  {
    // if (!$this->session->userdata('admin_logged_in')) {
    //   redirect('admin/login');
    // }

    // $this->load->model('products_model');
    $product = $this->my_model->get_product_video($product_id);
    // echo "<pre>";print_r($product);exit;

    // if (!$product) {
    //   $this->session->set_flashdata('error', 'Product not found');
    //   redirect('admin/products');
    // }

    $data['product_id'] = $product_id;
    $data['product_video'] = $product;
    $this->load->view('product_video', $data);
  }

  public function upload_video($product_id)
  {
    // if (!$this->session->userdata('admin_logged_in')) {
    //   redirect('admin/login');
    // }

    $config['upload_path'] = './videos/products/';
    $config['allowed_types'] = 'mp4|avi|mov|wmv|flv|webm|mkv';
    $config['max_size'] = 102400; // 100MB
    $config['file_name'] = 'product_' . $product_id . '_' . time();

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('product_video')) {
      $this->session->set_flashdata('error', $this->upload->display_errors());
    } else {
      $upload_data = $this->upload->data();

      // Delete old video if exists
      // $this->load->model('products_model');
      $old_video = $this->my_model->get_product_video($product_id);
      if ($old_video && file_exists('./videos/products/' . $old_video)) {
        unlink('./videos/products/' . $old_video);
      }

      // Update database
      $this->my_model->update_product_video($product_id, $upload_data['file_name']);
      $this->session->set_flashdata('success', 'Video uploaded successfully');
    }

    redirect('admin/products/manage_video/' . $product_id);
  }

  public function delete_video($product_id)
  {
    // if (!$this->session->userdata('admin_logged_in')) {
    //   redirect('admin/login');
    // }

    // $this->load->model('products_model');
    $video = $this->my_model->get_product_video($product_id);

    if ($video && file_exists('./videos/products/' . $video)) {
      unlink('./videos/products/' . $video);
    }

    $this->my_model->update_product_video($product_id, null);
    $this->session->set_flashdata('success', 'Video deleted successfully');

    redirect('admin/products/manage_video/' . $product_id);
  }

  // Product Variants Methods
  public function variants($product_id) {
    $data['product_id'] = $product_id;
    $data['variants'] = $this->variant_model->get_product_variants($product_id);
    $data['sizes'] = $this->size_model->get_all();
    $data['colors'] = $this->color_model->get_all();
    $data['prices'] = $this->price_model->get_all();
    $data['sections'] = $this->section_model->get_all();

    if($this->input->get('action') == 'edit') {
      $variant_id = $this->input->get('id');
      $variant_data = $this->variant_model->get_variant_with_details($variant_id);
      if ($variant_data) {
        $data['variant'] = $variant_data;
        $data['variant_images'] = isset($variant_data['images']) ? $variant_data['images'] : array();
        $data['variant_sections'] = $this->variant_model->get_variant_sections($variant_id);

        // Organize variant sizes into a more usable format
        $variant_sizes = array();
        if (isset($variant_data['sizes']) && is_array($variant_data['sizes'])) {
          foreach($variant_data['sizes'] as $size) {
            $variant_sizes[$size['size_id']] = array(
              'price_id' => $size['price_id'],
              'status' => $size['status']
            );
          }
        }
        $data['variant_sizes'] = $variant_sizes;
      }
    }

    // Load the views
    $this->load->view($this->headerPage);
    $this->load->view('product_variants', $data);
  }

  public function save_variant() {

    // echo "<pre>";print_r($_POST);echo "</pre>";exit;
    $product_id = $this->input->post('product_id');
    $variant_id = $this->input->post('variant_id');
    
    // Variant main data
    $variant_data = array(
      'product_id' => $product_id,
      'color_id' => $this->input->post('color_id'),
      'tags' => $this->input->post('tags'),
      'info' => $this->input->post('info'),
      'coupon_id' => $this->input->post('coupon_id'),
      'show_in_lux' => $this->input->post('show_in_lux') ? 1 : 0,
      'status' => 1
    );

    if(!$variant_id) {
      $variant_data['created_date_time'] = date('Y-m-d H:i:s');
    }
    $variant_data['updated_date_time'] = date('Y-m-d H:i:s');

    if($variant_id) {
      $this->variant_model->update_variant($variant_id, $variant_data);
    } else {
      $variant_id = $this->variant_model->add_variant($variant_data);
    }

    // Handle variant sizes from form arrays
    $size_ids = $this->input->post('size_ids');
    $price_ids = $this->input->post('price_ids');
    $size_statuses = $this->input->post('size_status');

    if($size_ids && is_array($size_ids)) {
      // First delete existing sizes for this variant if updating
      if($variant_id) {
        $this->variant_model->delete_variant_sizes($variant_id);
      }

      // Add new sizes
      foreach($size_ids as $size_id) {
        if(!empty($size_id) && !empty($price_ids[$size_id])) {
          $size_insert = array(
            'variant_id' => $variant_id,
            'product_id' => $product_id,
            'size_id' => $size_id,
            'price_id' => $price_ids[$size_id],
            'status' => isset($size_statuses[$size_id]) ? 1 : 0,
            'created_date_time' => date('Y-m-d H:i:s'),
            'updated_date_time' => date('Y-m-d H:i:s')
          );
          $this->variant_model->add_variant_size($size_insert);
        }
      }
    }

    // Handle image uploads
    if(!empty($_FILES['variant_images']['name'][0])) {
      $config['upload_path'] = './images/products/';
      $config['allowed_types'] = 'jpg|jpeg|png|gif';
      $config['max_size'] = 5000;
      $this->load->library('upload', $config);
      
      $files = $_FILES['variant_images'];
      $file_count = count($files['name']);
      
      for($i = 0; $i < $file_count; $i++) {
        $_FILES['single_file']['name'] = $files['name'][$i];
        $_FILES['single_file']['type'] = $files['type'][$i];
        $_FILES['single_file']['tmp_name'] = $files['tmp_name'][$i];
        $_FILES['single_file']['error'] = $files['error'][$i];
        $_FILES['single_file']['size'] = $files['size'][$i];
        
        $config['file_name'] = 'variant_'.$variant_id.'_'.time().'_'.$i;
        $this->upload->initialize($config);
        
        if($this->upload->do_upload('single_file')) {
          $upload_data = $this->upload->data();
          $variant_image_data = array(
            'variant_id' => $variant_id,
            'image' => $upload_data['file_name'],
            'product_id' => $product_id,
            'status' => 1,
            'created_date_time' => date('Y-m-d H:i:s'),
            'updated_date_time' => date('Y-m-d H:i:s')
          );
          $this->variant_model->add_variant_image($variant_id, $variant_image_data);
        }
      }
    }

    // Handle sections
    $sections = $this->input->post('sections');
    // Note: $selected_sections is built for reference but not used - the model handles the actual insert
    $selected_sections = array();
    if($sections) {
      foreach($sections as $section_id) {
        $selected_sections[] = array(
          'variant_id' => $variant_id,
          'section_id' => $section_id,
          'product_id' => $product_id,
          'status' => 1,
          'created_date_time' => date('Y-m-d H:i:s'),
          'updated_date_time' => date('Y-m-d H:i:s')
        );
      }
    }
  $this->variant_model->save_variant_sections($variant_id, $sections, $product_id);

    $this->session->set_flashdata('msg_succ', 'Variant saved successfully');
    redirect(base_url('admin/products/variants/'.$product_id));
  // }
}

  public function delete_variant($variant_id) {
  $variant = $this->variant_model->get_variant($variant_id);
    
    if($variant) {
  $this->variant_model->delete_variant($variant_id);
      $this->session->set_flashdata('msg_succ', 'Variant deleted successfully');
      redirect(base_url('admin/products/variants/'.$variant['product_id']));
    } else {
      $this->session->set_flashdata('msg_succ', 'Variant not found');
      redirect(base_url('admin/products'));
    }
  }

  public function delete_variant_image() {
    $image_id = $this->input->post('image_id');
  $success = $this->variant_model->delete_variant_image($image_id);
    
    header('Content-Type: application/json');
    echo json_encode(['success' => $success]);
  }
  
  public function fix_variant_sections_product_id() {
    $updated_count = $this->variant_model->fix_variant_sections_product_id();
    $this->session->set_flashdata('msg_succ', "Fixed $updated_count variant section records with missing product_id");
    redirect(base_url('admin/products'));
  }
}
