<?php error_reporting(0);
class ControllerModuleCategory extends Controller {
	public function index() {
		$this->load->language('module/category');

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
		} else {
			$data['category_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');
        $this->load->model('tool/image');
        
        $this->load->model('design/banner');
        
		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);
        
        $this->load->model('setting/setting');
        $tmpsett=$this->model_setting_setting->getSetting('category_link_banner');
        
        
        
        
		foreach ($categories as $category) {
			$children_data = array();
                
            $parrent_id=isset($category['parrent_id'])?$category['parrent_id']:0;
            
			if ($category['category_id'] == $data['category_id'] || $parrent_id == 0) {
				$children = $this->model_catalog_category->getCategories($category['category_id']);
$banner_child = array();
				foreach($children as $child) 
                {
                                if ($child['image']) 
                                {
                                    $image = $this->model_tool_image->resize($child['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                                }else 
                                {
                                    $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                                }
                    
         
                           if( $tmpsett["category_link_banner_setting"][$child['category_id']])
                           {



                                $results = $this->model_design_banner->getBanner($tmpsett["category_link_banner_setting"][$child['category_id']]);

                                    foreach ($results as $result) 
                                    {
                                        if (is_file(DIR_IMAGE . $result['image'])) 
                                        {
                                            $data['banners'][] = array
                                            (
                                                'name' =>$result['name'],
                                                'title' => $result['title'],
                                                'link'  => $result['link'],
                                                'image' => $this->model_tool_image->resize($result['image'], 23, 23),
                                                'category_child' => $child['category_id']
                                            );
                                        }
                                    }


                           } else 
                           { 
                               $results= array( 'image'=>"Нету картинки", 'title'=>"Нету описания" ); 
                           } 
               

                    
					$filter_data = array('filter_category_id' => $child['category_id'], 'filter_sub_category' => true);

					$children_data[] = array
                        (
						'category_id' => $child['category_id'],
						'name' => $child['name'] ,
						'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']),
                        'image'=> $image
                        );
				
             }
                }
			}

			$filter_data = array(
				'filter_category_id'  => $category['category_id'],
				'filter_sub_category' => true
			);

            
            
			$data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'],
				'children'    => $children_data,
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
                
              
			);
		
$data['g']=$data;
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/category.tpl', $data);
		} else {
			return $this->load->view('default/template/module/category.tpl', $data);
		}
	}
}