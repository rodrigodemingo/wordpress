<?php

class ControllerModuleOclayerednavigation extends Controller
{

    /**
     * Load layered navigation block
     */
    public function index() {
        if (isset($this->request->get['path'])) {
            $parts = explode('_', (string)$this->request->get['path']);
        } else {
            $parts = array();
        }

        $category_id = end($parts);

        $this->load->model('catalog/category');

        $category_info = $this->model_catalog_category->getCategory($category_id);

        if ($category_info) {
            $this->load->language('module/oclayerednavigation');

            $data['heading_title'] = $this->language->get('heading_title');

            $data['button_filter'] = $this->language->get('button_filter');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['action'] = str_replace('&amp;', '&', $this->config->get('config_url') . 'index.php?route=module/oclayerednavigation/category&path=' . $category_id . $url);
            $data['clear_action'] = str_replace('&amp;', '&', $this->config->get('config_url') . 'index.php?route=module/oclayerednavigation/category&path=' . $category_id);

            if (isset($this->request->get['filter'])) {
                $data['filter_category'] = explode(',', $this->request->get['filter']);
            } else {
                $data['filter_category'] = array();
            }

            $this->load->model('catalog/product');

            // Min price and Max price of product collection
            /* Begin */
            $min_price = 10000000;  // Set the large number
            $max_price = 0;         // Set the small number

            $data['products'] = array();

            $filter_data = array(
                'filter_category_id' => $category_id
            );

            $results = $this->model_catalog_product->getProducts($filter_data);

            foreach($results as $result) {
                $price = (float) $result['price'];

                if($price < $min_price) {
                    $min_price = $price;
                }

                if($price > $max_price) {
                    $max_price = $price;
                }
            }
            $data['min_price'] = $min_price;
            $data['max_price'] = $max_price;
            $data['currency_symbol'] = $this->currency->getSymbolLeft($this->session->data['currency']);
            /* End */

            $data['filter_groups'] = array();

            $filter_groups = $this->model_catalog_category->getCategoryFilters($category_id);

            if ($filter_groups) {
                foreach ($filter_groups as $filter_group) {
                    $childen_data = array();

                    foreach ($filter_group['filter'] as $filter) {
                        $filter_data = array(
                            'filter_category_id' => $category_id,
                            'filter_filter'      => $filter['filter_id']
                        );

                        $childen_data[] = array(
                            'filter_id' => $filter['filter_id'],
                            'name'      => $filter['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                            'e_name'    => $filter['name']
                        );
                    }

                    $data['filter_groups'][] = array(
                        'filter_group_id' => $filter_group['filter_group_id'],
                        'name'            => $filter_group['name'],
                        'filter'          => $childen_data
                    );
                }

                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/oclayerednavigation/oclayerednavigation.tpl')) {
                    return $this->load->view($this->config->get('config_template') . '/template/module/oclayerednavigation/oclayerednavigation.tpl', $data);
                } else {
                    return $this->load->view('default/template/module/oclayerednavigation/oclayerednavigation.tpl', $data);
                }
            }
        }
    }

    /**
     * Load Layer after filter
     */
    public function layer() {
        if (isset($this->request->get['path'])) {
            $parts = explode('_', (string)$this->request->get['path']);
        } else {
            $parts = array();
        }

        $category_id = end($parts);

        $this->load->model('catalog/category');

        $category_info = $this->model_catalog_category->getCategory($category_id);

        if ($category_info) {
            $this->load->language('module/oclayerednavigation');

            $data['clear_action'] = str_replace('&amp;', '&', $this->config->get('config_url') . 'index.php?route=module/oclayerednavigation/category&path=' . $category_id);

            if (isset($this->request->get['filter'])) {
                $data['filter_category'] = explode(',', $this->request->get['filter']);
            } else {
                $data['filter_category'] = array();
            }

            $this->load->model('catalog/product');

            // Min price and Max price of product collection
            /* Begin */
            $min_price = 10000000;  // Set the large number
            $max_price = 0;         // Set the small number

            $data['products'] = array();

            $filter_data = array(
                'filter_category_id' => $category_id
            );

            $results = $this->model_catalog_product->getProducts($filter_data);

            foreach($results as $result) {

                $price = (float) $result['price'];

                if($price < $min_price) {
                    $min_price = $price;
                }

                if($price > $max_price) {
                    $max_price = $price;
                }

            }

            $data['min_price'] = $min_price;
            $data['max_price'] = $max_price;

            if  (isset($this->request->get['price'])) {
                $price_data = $this->request->get['price'];
            } else {
                $price_data = '';
            }

            if (isset($this->request->get['price'])) {
                $price_data = explode(',', $price_data);
                $data['current_min_price'] = $price_data[0];
                $data['current_max_price'] = $price_data[1];
            } else {
                $data['current_min_price'] = $data['min_price'];
                $data['current_max_price'] = $data['max_price'];
            }

            $data['currency_symbol'] = $this->currency->getSymbolLeft($this->session->data['currency']);
            /* End */

            $data['filter_groups'] = array();

            $filter_groups = $this->model_catalog_category->getCategoryFilters($category_id);

            if ($filter_groups) {
                foreach ($filter_groups as $filter_group) {
                    $childen_data = array();

                    foreach ($filter_group['filter'] as $filter) {
                        $filter_data = array(
                            'filter_category_id' => $category_id,
                            'filter_filter'      => $filter['filter_id']
                        );

                        $childen_data[] = array(
                            'filter_id' => $filter['filter_id'],
                            'name'      => $filter['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                            'e_name'    => $filter['name']
                        );
                    }

                    $data['filter_groups'][] = array(
                        'filter_group_id' => $filter_group['filter_group_id'],
                        'name'            => $filter_group['name'],
                        'filter'          => $childen_data
                    );
                }

                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/oclayerednavigation/oclayerednavigationfilter.tpl')) {
                    return $this->load->view($this->config->get('config_template') . '/template/module/oclayerednavigation/oclayerednavigationfilter.tpl', $data);
                } else {
                    return $this->load->view('default/template/module/oclayerednavigation/oclayerednavigationfilter.tpl', $data);
                }
            }
        }
    }

    /**
     * Load category view
     */
    public function category() {

        $this->load->language('product/category');

        $this->load->model('catalog/category');

        $this->load->model('catalog/product');

        $this->load->model('tool/image');

        $json = array();

        if  (isset($this->request->get['price'])) {
            $price_data = $this->request->get['price'];
        } else {
            $price_data = '';
        }

        if (isset($this->request->get['filter'])) {
            $filter = $this->request->get['filter'];
        } else {
            $filter = '';
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'p.sort_order';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['limit'])) {
            $limit = $this->request->get['limit'];
        } else {
            $limit = $this->config->get('config_product_limit');
        }

        if (isset($this->request->get['path'])) {
            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            if (isset($this->request->get['price'])) {
                $url .= '&price=' . $this->request->get['price'];
            }

            $path = '';

            $parts = explode('_', (string)$this->request->get['path']);

            $category_id = (int)array_pop($parts);

            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = (int)$path_id;
                } else {
                    $path .= '_' . (int)$path_id;
                }

                $category_info = $this->model_catalog_category->getCategory($path_id);

            }

        } else {
            $category_id = 0;
        }

        $category_info = $this->model_catalog_category->getCategory($category_id);

        if ($category_info) {
            $data['text_refine'] = $this->language->get('text_refine');
            $data['text_empty'] = $this->language->get('text_empty');
            $data['text_quantity'] = $this->language->get('text_quantity');
            $data['text_manufacturer'] = $this->language->get('text_manufacturer');
            $data['text_model'] = $this->language->get('text_model');
            $data['text_price'] = $this->language->get('text_price');
            $data['text_tax'] = $this->language->get('text_tax');
            $data['text_points'] = $this->language->get('text_points');
            $data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
            $data['text_sort'] = $this->language->get('text_sort');
            $data['text_limit'] = $this->language->get('text_limit');

            $data['button_cart'] = $this->language->get('button_cart');
            $data['button_wishlist'] = $this->language->get('button_wishlist');
            $data['button_compare'] = $this->language->get('button_compare');
            $data['button_continue'] = $this->language->get('button_continue');
            $data['button_list'] = $this->language->get('button_list');
            $data['button_grid'] = $this->language->get('button_grid');

            if ($category_info['image']) {
                $data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
            } else {
                $data['thumb'] = '';
            }

            $data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
            $data['compare'] = $this->url->link('product/compare');

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['price'])) {
                $url .= '&price=' . $this->request->get['price'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['categories'] = array();

            $results = $this->model_catalog_category->getCategories($category_id);

            foreach ($results as $result) {
                $filter_data = array(
                    'filter_category_id'  => $result['category_id'],
                    'filter_sub_category' => true
                );

                $data['categories'][] = array(
                    'name'  => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                    'href'  => $this->config->get('config_url') . 'index.php?route=module/oclayerednavigation/category&path=' . $result['category_id'] . $url
                );
            }

            $data['products'] = array();

            // Min and Max Price
            $filter_price = array();
            if (isset($this->request->get['price'])) {
                $price_data = explode(',', $price_data);
                $filter_price['min_price'] = $price_data[0];
                $filter_price['max_price'] = $price_data[1];
            }

            $filter_data = array(
                'filter_category_id' => $category_id,
                'filter_filter'      => $filter,
                'filter_price'       => $filter_price,
                'sort'               => $sort,
                'order'              => $order,
                'start'              => ($page - 1) * $limit,
                'limit'              => $limit
            );

            $product_total = $this->model_catalog_product->getTotalProducts($filter_data);

            $results = $this->model_catalog_product->getProducts($filter_data);

            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                }

                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $price = false;
                }

                if ((float)$result['special']) {
                    $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $special = false;
                }

                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
                } else {
                    $tax = false;
                }

                if ($this->config->get('config_review_status')) {
                    $rating = (int)$result['rating'];
                } else {
                    $rating = false;
                }

				/// Product Rotator /
                $product_rotator_status = (int) $this->config->get('ocproductrotator_status');
                if($product_rotator_status == 1) {
                 $this->load->model('catalog/ocproductrotator');
                 $this->load->model('tool/image');
             
                 $product_id = $result['product_id'];
                 $product_rotator_image = $this->model_catalog_ocproductrotator->getProductRotatorImage($product_id);
             
                 if($product_rotator_image) {
                  $rotator_image_width = (int) $this->config->get('ocproductrotator_width');
                  $rotator_image_height = (int) $this->config->get('ocproductrotator_height');
      $rotator_image = $this->model_tool_image->resize($product_rotator_image, $rotator_image_width,$rotator_image_height); 
                 } else {
                  $rotator_image = false;
                 } 
                } else {
                 $rotator_image = false;    
                }
                /// End Product Rotator /
				$filter_data = array(
				 'sort'  => 'p.date_added',
				 'order' => 'DESC',
				 'start' => 0,
				 'limit' => 10
				);
			  
				$new_results = $this->model_catalog_product->getProducts($filter_data);
				 $is_new = false;
				  if ($new_results) { 
				   foreach($new_results as $new_r) {
					if($result['product_id'] == $new_r['product_id']) {
					 $is_new = true;
					}
				   }
				  }
                $data['products'][] = array(
                    'product_id'  => $result['product_id'],
					'rotator_image' => $rotator_image,
                    'thumb'       => $image,
					'is_new' 	  => $is_new,
                    'name'        => $result['name'],
                    'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
                    'price'       => $price,
                    'special'     => $special,
                    'tax'         => $tax,
                    'rating'      => $result['rating'],
                    'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url)
                );
            }

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            if (isset($this->request->get['price'])) {
                $url .= '&price=' . $this->request->get['price'];
            }

            $data['sorts'] = array();

            $data['sorts'][] = array(
                'text'  => $this->language->get('text_default'),
                'value' => 'p.sort_order-ASC',
                'href'  => $this->config->get('config_url') . 'index.php?route=module/oclayerednavigation/category&path=' . $category_id . '&sort=p.sort_order&order=ASC' . $url
            );

            $data['sorts'][] = array(
                'text'  => $this->language->get('text_name_asc'),
                'value' => 'pd.name-ASC',
                'href'  => $this->config->get('config_url') . 'index.php?route=module/oclayerednavigation/category&path=' . $category_id . '&sort=pd.name&order=ASC' . $url
            );

            $data['sorts'][] = array(
                'text'  => $this->language->get('text_name_desc'),
                'value' => 'pd.name-DESC',
                'href'  => $this->config->get('config_url') . 'index.php?route=module/oclayerednavigation/category&path=' . $category_id . '&sort=pd.name&order=DESC' . $url
            );

            $data['sorts'][] = array(
                'text'  => $this->language->get('text_price_asc'),
                'value' => 'p.price-ASC',
                'href'  => $this->config->get('config_url') . 'index.php?route=module/oclayerednavigation/category&path=' . $category_id . '&sort=p.price&order=ASC' . $url
            );

            $data['sorts'][] = array(
                'text'  => $this->language->get('text_price_desc'),
                'value' => 'p.price-DESC',
                'href'  => $this->config->get('config_url') . 'index.php?route=module/oclayerednavigation/category&path=' . $category_id . '&sort=p.price&order=DESC' . $url
            );

            if ($this->config->get('config_review_status')) {
                $data['sorts'][] = array(
                    'text'  => $this->language->get('text_rating_desc'),
                    'value' => 'rating-DESC',
                    'href'  => $this->config->get('config_url') . 'index.php?route=module/oclayerednavigation/category&path=' . $category_id . '&sort=rating&order=DESC' . $url
                );

                $data['sorts'][] = array(
                    'text'  => $this->language->get('text_rating_asc'),
                    'value' => 'rating-ASC',
                    'href'  => $this->config->get('config_url') . 'index.php?route=module/oclayerednavigation/category&path=' . $category_id . '&sort=rating&order=ASC' . $url
                );
            }

            $data['sorts'][] = array(
                'text'  => $this->language->get('text_model_asc'),
                'value' => 'p.model-ASC',
                'href'  => $this->config->get('config_url') . 'index.php?route=module/oclayerednavigation/category&path=' . $category_id . '&sort=p.model&order=ASC' . $url
            );

            $data['sorts'][] = array(
                'text'  => $this->language->get('text_model_desc'),
                'value' => 'p.model-DESC',
                'href'  => $this->config->get('config_url') . 'index.php?route=module/oclayerednavigation/category&path=' . $category_id . '&sort=p.model&order=DESC' . $url
            );

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['price'])) {
                $url .= '&price=' . $this->request->get['price'];
            }

            $data['limits'] = array();

            $limits = array_unique(array($this->config->get('config_product_limit'), 25, 50, 75, 100));

            sort($limits);

            foreach($limits as $value) {
                $data['limits'][] = array(
                    'text'  => $value,
                    'value' => $value,
                    'href'  => $this->config->get('config_url') . 'index.php?route=module/oclayerednavigation/category&path=' . $category_id . $url . '&limit=' . $value
                );
            }

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            if (isset($this->request->get['price'])) {
                $url .= '&price=' . $this->request->get['price'];
            }

            $pagination = new Pagination();
            $pagination->total = $product_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->url = $this->config->get('config_url') . 'index.php?route=product/category&path=' . $category_id . $url . '&page={page}';

            $data['pagination'] = $pagination->render();

            $data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

            $data['sort'] = $sort;
            $data['order'] = $order;
            $data['limit'] = $limit;

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/oclayerednavigation/occategoryfilter.tpl')) {
                $json['result_html'] = $this->load->view($this->config->get('config_template') . '/template/module/oclayerednavigation/occategoryfilter.tpl', $data);
            } else {
                $json['result_html'] = $this->load->view('default/template/module/oclayerednavigation/occategoryfilter.tpl', $data);
            }

            $url = '';

            if (isset($this->request->get['price'])) {
                $url .= '&price=' . $this->request->get['price'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $json['filter_action'] =  str_replace('&amp;', '&', $this->config->get('config_url') . 'index.php?route=module/oclayerednavigation/category&path=' . $category_id . $url);

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $json['price_action'] =  str_replace('&amp;', '&', $this->config->get('config_url') . 'index.php?route=module/oclayerednavigation/category&path=' . $category_id . $url);

            $json['layered_html'] = $this->layer();

        } else {

            $json['result_html'] = "No No No";

        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));

    }

}