<?php
class ControllerInformationInformation extends Controller {
	public function index() {
		$this->load->language('information/information');

		$this->load->model('catalog/information');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$information_info = $this->model_catalog_information->getInformation($information_id);
		$data['send_mail1']=-1;
		if ($information_id == 14) {
			$this->load->model('tool/savemail');
		
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
				
				$this->model_tool_savemail->save($this->request->post['email']);
				
				$this->response->redirect(explode('?', $_SERVER['REQUEST_URI'], 2)[0]."?mail=ok");		
				
			}
			
			$data['action'] = $_SERVER['REQUEST_URI'];
			$data['send_mail'] = true;
		}else{
			$data['send_mail'] = false;
		}

		if ($information_info) {
			$this->document->setTitle($information_info['meta_title']);
			$this->document->setDescription($information_info['meta_description']);
			$this->document->setKeywords($information_info['meta_keyword']);

			$data['breadcrumbs'][] = array(
				'text' => $information_info['title'],
				'href' => $this->url->link('information/information', 'information_id=' .  $information_id)
			);

			$data['heading_title'] = $information_info['title'];

			$data['button_continue'] = $this->language->get('button_continue');

			$data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

			$data['continue'] = $this->url->link('common/home');
			
			$data['informations'] = array();
			
		$informations = $this->model_catalog_information->getInformations();
		
		$data['read_more'] = $this->language->get('read_more'); 
		
		$data['all_products'] = $this->language->get('all_products');
		

		foreach ($informations as $information_id) {
		
			//$information_info = $this->model_catalog_information->getInformation($information_id);
			
			if (!$information_id['top'] && !$information_id['bottom'] && !$information_id['neytral']) {
			
				$data['informations'][] = array(
					'information_id' => $information_id['information_id'],
					'title' => $information_id['title'],
					'description' => html_entity_decode($information_id['description'], ENT_QUOTES, 'UTF-8'),
					'short_description' => mb_substr(strip_tags(html_entity_decode($information_id['description'], ENT_QUOTES, 'UTF-8')), 0, 500) . '...',
					'href' => $this->url->link('information/information', 'information_id=' .  $information_id['information_id'])
				);
				
			}
		}

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/information.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/information.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/information/information.tpl', $data));
			}
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('information/information', 'information_id=' . $information_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');
			
			$data['informations'] = array();
			
		$informations = $this->model_catalog_information->getInformations();
		
		$data['read_more'] = $this->language->get('read_more'); 

		foreach ($informations as $information_id) {
		
			//$information_info = $this->model_catalog_information->getInformation($information_id);
			
			if (!$information_id['top'] && !$information_id['bottom']) {
			
				$data['informations'][] = array(
					'information_id' => $information_id['information_id'],
					'title' => $information_id['title'],
					'description' => html_entity_decode($information_id['description'], ENT_QUOTES, 'UTF-8'),
					'short_description' => mb_substr(strip_tags(html_entity_decode($information_id['description'], ENT_QUOTES, 'UTF-8')), 0, 500) . '...',
					'href' => $this->url->link('information/information', 'information_id=' .  $information_id['information_id'])
				);
				
			}
		}

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}

	public function agree() {
		$this->load->model('catalog/information');

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$output = '';

		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {
			$output .= html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
		}

		$this->response->setOutput($output);
	}
	
	public function validate() {
		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
			$lock = false;
		}else{
			$lock = true;
		}
		
		return $lock;
	}
}