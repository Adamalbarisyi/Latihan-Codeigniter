<?php
defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH .'/libraries/JWT.php';
use \Firebase\JWT\JWT;

class UserController extends CI_Controller {

	private $secret = 'this is key secret';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user');


		//======== ALLOWING CORS
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers:  Content-Type, Content-Range, Content-Disposition, Content-Description');
	
	}

public function response($data)
{
	$this->output
		 ->set_content_type('application/json')
		 ->set_status_header(200)
		 ->set_output(json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE| JSON_UNESCAPED_SLASHES))
		 ->_display();
		
		
		exit;		
}


	public function register()
	{
	   return $this->response($this->user->save());
	}


	public function get_all()
	{
		return $this->response($this->user->get());
	}


	public function get($id)
	{
		return $this->response($this->user->get('id',$id));
	}

	public function login()
	{
		 $date = new DateTime();


		if(!$this->user->is_valid()){
			return $this->response([
				'success' => false,
				'message' => 'email atau password salah'
			]);
		}

		$user = $this->user->get('email',$this->input->post('email'));
		//lanjutkan endcode datanya
		$payload['id']    =  $user->id;
		// $payload['email'] =  $user->email;
		$payload['iat']   =  $date->getTimestamp();
		$payload['exp']   =  $date->getTimestamp() + 60*60*2;

		$output['id_token'] = JWT::encode($payload,$this->secret);
		$this->response($output);
	}

	public function check_token()
	{
		$jwt = $this->input->get_request_header('Authorization');

		try {
			$decoded = JWT::decode($jwt, $this->secret, array('HS256'));
			return $decoded->id;
		} catch (\Exception $e) {
			return $this->response([
				'success' => false,
				'message' => 'Gagal,Error token'
			]);

		}
	}




	public function delete($id)
	{
		if ($this->protected_method($id)) {
			return $this->response($this->user->delete($id));
		}
		
	}

	public function update($id)
	{
		$data = $this->get_input();
		if ($this->protected_method($id)) {
			return  $this->response($this->user->update($id,$data));
		}
	}

	public function protected_method($id)
	{
		//check user login
		if ($id_from_token = $this->check_token()) {
			//orang yang login yang mau hapus
				if ($id_from_token == $id) {
					return true;
				} else {
					return $this->response([
						'success' => false,
						'message' => 'User yang login berbeda'
					]);
				}
			}
	}

	public function get_input()
	{
		return json_decode(file_get_contents('php://input'));
	}
	 
	 
}
