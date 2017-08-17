<?php  
class ControllerModuleEasyBlog extends Controller {
	public function index() {

		$this->load->model('blog/article');
        $this->load->language('blog/blog');
		

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
			$limit = $this->config->get('easy_blog_article_limit');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);



			//$this->document->setTitle($this->config->get('easy_blog_meta_title'));
			$this->document->setDescription($this->config->get('easy_blog_meta_description'));
			$this->document->setKeywords($this->config->get('easy_blog_meta_keyword'));
			$this->document->addLink($this->url->link('blog/blog'),'');

			$data['heading_title'] = $this->config->get('easy_blog_meta_title');

			// Set the last category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => $this->config->get('easy_blog_meta_title'),
				'href' => $this->url->link('blog/blog')
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

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['articles'] = array();

			$filter_data = array(
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);

			$article_total = $this->model_blog_article->getTotalArticles($filter_data);

			$results = $this->model_blog_article->getArticles($filter_data);

			$this->load->model('tool/image');
			
			foreach ($results as $result) {
				$data['articles'][] = array(
					'article_id'  => $result['article_id'],
					'name'        => $result['name'],
					'author'	  => $result['author'],
					'image'		  => $this->model_tool_image->resize($result['image'],269,207),
                    'date_added'  => date("d M", strtotime($result['date_added'])),
					'day_added' => date("d", strtotime($result['date_added'])),
					'month_added' => date("M", strtotime($result['date_added'])),
                    'intro_text' => html_entity_decode($result['intro_text'], ENT_QUOTES, 'UTF-8'),
					'href'        => $this->url->link('blog/article', 'article_id=' . $result['article_id'] . $url)
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['sorts'] = array();

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('blog/blog', '&sort=p.sort_order&order=ASC' . $url)
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

			$data['limits'] = array();

			$limits = array_unique(array($this->config->get('easy_blog_article_limit'), 50, 75, 100));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('blog/blog', $url . '&limit=' . $value)
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

			$pagination = new Pagination();
			$pagination->total = $article_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('blog/blog', $url . '&page={page}');

			$data['pagination'] = $pagination->render();
            $data['button_read_more'] = $this->language->get('button_read_more');
            $data['text_empty'] = $this->language->get('text_empty');
			$data['text_headingtitle'] = $this->language->get('text_headingtitle');
			$data['results'] = sprintf($this->language->get('text_pagination'), ($article_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($article_total - $limit)) ? $article_total : ((($page - 1) * $limit) + $limit), $article_total, ceil($article_total / $limit));

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;
			

	

		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/cmsblock.tpl')) {
			//return $this->load->view('default/template/blog/blog_home.tpl', $data);
			return $this->load->view($this->config->get('config_template') . '/template/blog/blog_home.tpl', $data);
		} else {
			return $this->load->view('default/template/blog/blog_home.tpl', $data);
		}

    }
}
?>