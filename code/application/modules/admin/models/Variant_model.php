<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Variant_model extends CI_Model {
    // Table names
    private $tbl_variants = 'tbl_product_variants';
    private $tbl_variant_sizes = 'tbl_variant_sizes';
    private $tbl_variant_images = 'tbl_variant_images';
    private $tbl_colors = 'tbl_colors';
    private $tbl_sizes = 'tbl_sizes';
    private $tbl_prices = 'tbl_prices';
    
    public function add_variant($data) {
        $this->db->insert($this->tbl_variants, $data);
        return $this->db->insert_id();
    }

    public function update_variant($variant_id, $data) {
        $this->db->where('id', $variant_id);
        return $this->db->update($this->tbl_variants, $data);
    }

    public function delete_variant($variant_id) {
        // First delete related records
        $this->delete_variant_sizes($variant_id);
        $this->delete_variant_images($variant_id);
        
        // Then delete the variant
        $this->db->where('id', $variant_id);
        return $this->db->delete($this->tbl_variants);
    }

    public function add_variant_size($data) {
    //   echo "<pre>";print_r($data);echo "</pre>";exit;
        $this->db->insert($this->tbl_variant_sizes, $data);
        return $this->db->insert_id();
    }

    public function delete_variant_sizes($variant_id) {
        $this->db->where('variant_id', $variant_id);
        return $this->db->delete($this->tbl_variant_sizes);
    }

    public function get_variant_sizes($variant_id) {
        $this->db->where('variant_id', $variant_id);
        $query = $this->db->get($this->tbl_variant_sizes);
        return $query->result_array();
    }

    public function add_variant_image($variant_id, $data) {
        $this->db->insert($this->tbl_variant_images, $data);
        return $this->db->insert_id();
    }

    public function delete_variant_images($variant_id) {
        $this->db->where('variant_id', $variant_id);
        return $this->db->delete($this->tbl_variant_images);
    }

    public function delete_variant_image($image_id) {
        $this->db->where('id', $image_id);
        return $this->db->delete($this->tbl_variant_images);
    }

    public function get_variant_with_details($variant_id) {
        // Get variant basic info
        $this->db->select('v.*, c.name as color_name');
        $this->db->from($this->tbl_variants . ' v');
        $this->db->join($this->tbl_colors . ' c', 'c.id = v.color_id', 'left');
        $this->db->where('v.id', $variant_id);
        $variant = $this->db->get()->row_array();

        if($variant) {
            // Get variant sizes
            $this->db->select('vs.*, s.name as size_name, p.name as price_name');
            $this->db->from($this->tbl_variant_sizes . ' vs');
            $this->db->join($this->tbl_sizes . ' s', 's.id = vs.size_id', 'left');
            $this->db->join($this->tbl_prices . ' p', 'p.id = vs.price_id', 'left');
            $this->db->where('vs.variant_id', $variant_id);
            $variant['sizes'] = $this->db->get()->result_array();

            // Get variant images
            $this->db->where('variant_id', $variant_id);
            $variant['images'] = $this->db->get($this->tbl_variant_images)->result_array();
        }

        return $variant;
    }

    public function get_product_variants($product_id) {
        // Select main variant fields and color name
        $this->db->select('v.*, c.name as color_name');
        $this->db->select('GROUP_CONCAT(DISTINCT vi.image) as images', false);
        $this->db->select('GROUP_CONCAT(DISTINCT s.section_id) as section_ids', false);
        $this->db->select('GROUP_CONCAT(DISTINCT sec.name) as section_names', false);
        $this->db->select('GROUP_CONCAT(DISTINCT vs.size_id) as size_ids', false);
        $this->db->select('GROUP_CONCAT(DISTINCT CONCAT(vs.size_id, ":", vs.price_id, ":", vs.status)) as size_data', false);
        $this->db->from($this->tbl_variants . ' v');
        $this->db->join($this->tbl_colors . ' c', 'c.id = v.color_id', 'left');
        $this->db->join($this->tbl_variant_images . ' vi', 'vi.variant_id = v.id', 'left');
        $this->db->join('tbl_variant_sections s', 's.variant_id = v.id', 'left');
        $this->db->join('tbl_sections sec', 'sec.id = s.section_id', 'left');
        $this->db->join($this->tbl_variant_sizes . ' vs', 'vs.variant_id = v.id', 'left');
        $this->db->where('v.product_id', $product_id);
        $this->db->group_by('v.id');
        $variants = $this->db->get()->result_array();
        foreach($variants as &$variant) {
            $variant['images'] = $variant['images'] ? explode(',', $variant['images']) : array();
            $variant['section_ids'] = $variant['section_ids'] ? explode(',', $variant['section_ids']) : array();
            $variant['sections'] = array();
            if($variant['section_names']) {
                $section_names = explode(',', $variant['section_names']);
                foreach($section_names as $i => $name) {
                    if(isset($variant['section_ids'][$i])) {
                        $variant['sections'][] = array(
                            'id' => $variant['section_ids'][$i],
                            'name' => $name
                        );
                    }
                }
            }
            unset($variant['section_names']);
            $variant['sizes'] = array();
            if($variant['size_data']) {
                $size_entries = explode(',', $variant['size_data']);
                foreach($size_entries as $entry) {
                    list($size_id, $price_id, $status) = explode(':', $entry);
                    $variant['sizes'][$size_id] = array(
                        'size_id' => $size_id,
                        'price_id' => $price_id,
                        'status' => $status
                    );
                }
            }
            unset($variant['size_data']);
            unset($variant['size_ids']);
        }
        return $variants;
    }

    public function get_variant($variant_id) {
        $this->db->where('id', $variant_id);
        return $this->db->get($this->tbl_variants)->row_array();
    }

    public function get_variant_images($variant_id) {
        $this->db->where('variant_id', $variant_id);
        return $this->db->get($this->tbl_variant_images)->result_array();
    }

    public function save_variant_size($variant_id, $size_id, $data) {
        $this->db->where('variant_id', $variant_id);
        $this->db->where('size_id', $size_id);
        $exists = $this->db->get($this->tbl_variant_sizes)->row();
        if($exists) {
            $this->db->where('variant_id', $variant_id);
            $this->db->where('size_id', $size_id);
            return $this->db->update($this->tbl_variant_sizes, $data);
        } else {
            return $this->db->insert($this->tbl_variant_sizes, $data);
        }
    }

    public function get_variant_sections($variant_id) {
        $this->db->select('section_id');
        $this->db->where('variant_id', $variant_id);
        $result = $this->db->get('tbl_variant_sections')->result_array();
        return array_column($result, 'section_id');
    }

    public function save_variant_sections($variant_id, $sections, $product_id = null) {
        // Get product_id from variant if not provided
        if (!$product_id) {
            $variant = $this->get_variant($variant_id);
            $product_id = $variant ? $variant['product_id'] : 0;
        }
        
        $this->db->where('variant_id', $variant_id);
        $this->db->delete('tbl_variant_sections');
        if($sections) {
            $data = array();
            foreach($sections as $section_id) {
                $data[] = array(
                    'variant_id' => $variant_id,
                    'section_id' => $section_id,
                    'product_id' => $product_id,
                    'status' => 1,
                    'created_date_time' => date('Y-m-d H:i:s'),
                    'updated_date_time' => date('Y-m-d H:i:s')
                );
            }
            return $this->db->insert_batch('tbl_variant_sections', $data);
        }
        return true;
    }
    
    public function fix_variant_sections_product_id() {
        // Get all variant sections with product_id = 0
        $this->db->select('vs.id, vs.variant_id, v.product_id');
        $this->db->from('tbl_variant_sections vs');
        $this->db->join('tbl_product_variants v', 'v.id = vs.variant_id');
        $this->db->where('vs.product_id', 0);
        $sections_to_fix = $this->db->get()->result_array();
        
        $updated_count = 0;
        foreach($sections_to_fix as $section) {
            $this->db->where('id', $section['id']);
            $this->db->update('tbl_variant_sections', [
                'product_id' => $section['product_id'],
                'status' => 1,
                'updated_date_time' => date('Y-m-d H:i:s')
            ]);
            $updated_count++;
        }
        
        return $updated_count;
    }
}
