<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
	public function __construct()
	{
	}
	public function index()
	{

		$data = [
			'css' => '../css/stylemasuk.css'
		];
		helper(['form']);


		if ($this->request->getMethod() == 'post') {
			//validation here
			$rules = [
				'email' => 'required|min_length[6]|max_length[50]|valid_email',
				'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
			];

			$errors = [

				'password' => [
					'validateUser' => 'Email or Password dont match'
				]

			];

			if (!$this->validate($rules, $errors)) {
				$data['validation'] = $this->validator;
			} else {
				//store to database
				$model = new UserModel();

				$user = $model->where('email', $this->request->getVar('email'))->first();
				if ($user['aktif'] == 1) {
					$this->setUserSession($user);
					return redirect()->to('/');
				} else {
					$dataKode = ['email' => $user['email']];
					return view('page_verifikasi', $dataKode);
				}
			}
		}

		// echo view('templates/header', $data);
		// echo view('formpage/login');
		// echo view('templates/footer');
		return view('masuk', $data);
	}

	private function setUserSession($user)
	{

		$data = [
			'id' => $user['id'],
			'namaLengkap' => $user['namaLengkap'],
			'email' => $user['email'],
			'isLoggedIn' => true,
		];

		session()->set($data);
		return true;
	}



	public function register()
	{

		$data = [
			'css' => '../css/styledaftar.css'
		];
		helper(['form']);

		if ($this->request->getMethod() == 'post') {
			//validation here
			$rules = [
				'namaLengkap' => 'required',
				'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
				'password' => 'required|min_length[8]|max_length[255]',
				'password_confirm' => 'matches[password]'

			];

			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {
				//store to database
				$model = new UserModel();
				$aktivasiKode = random_int(100000, 999999);
				$newData = [
					'namaLengkap' => $this->request->getVar('namaLengkap'),
					'email' => $this->request->getVar('email'),
					'password' => $this->request->getVar('password'),
					'aktif' => 0,
					'aktivasiKode' => $aktivasiKode
				];
				$datakode = [
					'email' => $this->request->getVar('email')
				];
				$this->sendEmail($this->request->getVar('email'), 'ini kode verifikasi anda', $aktivasiKode);
				$model->save($newData);
				return view('page_verifikasi', $datakode);
			}
		}

		// echo view('templates/header', $data);
		// echo view('formpage/register');
		// echo view('templates/footer');
		return view('daftar', $data);
	}


	public function profile()
	{
		$data = [];
		helper(['form']);
		$model = new UserModel();
		$session = session();

		if ($this->request->getMethod() == 'post') {
			//validation here
			$rules = [
				'firstName' => 'required|min_length[5]|max_length[20]',
				'lastName' => 'required|min_length[5]|max_length[20]',
			];

			if ($this->request->getPost('password') != '') {
				$rules['password'] = 'required|min_length[5]|max_length[20]';
				$rules['password_confirm'] = 'matches[password]';
			}

			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {
				//store to database


				$newData = [
					'id' => session()->get('id'),
					'firstName' => $this->request->getPost('firstName'),
					'lastName' => $this->request->getPost('lastName'),
					// 'password' => $this->request->getVar('password'),
				];
				if ($this->request->getPost('password') != '') {
					$newData['password'] = $this->request->getPost('password');
				}

				$model->save($newData);
				$session->setFlashdata('success', 'Successful Update');
				return redirect()->to('/profile');
			}
		}

		$data['user'] = $model->where('id', session()->get('id'))->first();

		// echo view('templates/header', $data);
		// echo view('pages/profile');
		// echo view('templates/footer');
		return view('pages/profile', $data);
	}

	public function logout()
	{
		session()->destroy();
		return redirect()->to('/');
	}

	public function verifikasi()
	{

		$data = [];
		helper(['form']);


		if ($this->request->getMethod() == 'post') {
			//validation here
			$rules = [
				'email' => 'required|min_length[6]|max_length[50]|valid_email',
				'aktivasiKode' => 'required|verifikasiData[email,aktivasiKode]',
			];

			$errors = [

				'aktivasiKode' => [
					'verifikasiData' => 'Kode salah'
				]

			];

			if (!$this->validate($rules, $errors)) {
				$data['validation'] = $this->validator;
			} else {
				//store to database
				$model = new UserModel();
				$user = $model->where('email', $this->request->getVar('email'))->first();
				$newData = [
					'id' => $user['id'],
					'aktif' => 1,
				];
				$model->save($newData);

				return redirect()->to('/');
			}
			$data['email'] = $this->request->getVar('email');
		}
		// echo view('templates/header', $data);
		// echo view('formpage/login');
		// echo view('templates/footer');
		return view('page_verifikasi', $data);
	}

	private function sendEmail($to, $title, $message)
	{
		$email = service('email');
		$email->setFrom('yutolol100@gmail.com', 'yutolol100');
		$email->setTo($to);
		$email->setSubject($title);
		$email->setMessage($message);

		if ($email->send()) {
			echo "email berhasil dikirim";
		} else {
			$data = $email->printDebugger(['Headers']);
			print_r($data);
		}
	}
}
