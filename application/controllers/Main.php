<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!login_admin()){redirect('login/');}
		$this->load->model("dbs");
	}

	protected function _menu($view = null, $title = null)
	{
		$data['jquery'] 		= site_url('aset/js/jquery.js');
		$data['css'] 			= site_url('aset/css/arjunane.css?' . rand());
		$data['js']				= site_url('aset/js/arjunane.js?' . rand());
		$data['js_table']		= site_url('aset/js/table.js?' . rand());
		$data['css_table']		= site_url('aset/css/table.css?' . rand());
		$data['tinymce']		= site_url("aset/tinymce/js/tinymce/tinymce.js");

		$dt_header['link']		= [ 
			[ 'BERANDA', 	site_url(), null ], 
			[ 'MATERI',  	site_url('main/materi'), "materi" ], 
			[ 'EVALUASI',  	site_url('main/evaluasi'), "evaluasi" ],
			[ 'KELOLA AKUN',  site_url('main/mahasiswa'), 'mahasiswa' ],
			[ 'UBAH PASSWORD',site_url('main/akun'), 'akun' ],
			[ 'NILAI',  	site_url('main/nilai'), 'nilai' ],
			[ 'LOGOUT',  	site_url('main/logout'), 'logout' ], 
		];

		$_dt_view['header']		= view('admin/_header', $dt_header, TRUE);
		$_dt_view['footer']		= view('admin/_footer','', TRUE);
		$_dt_view['section']	= $view;
		$data['view']			= view('admin/main', $_dt_view, TRUE);
		$data['title']			= $title;
		set_userdata('link', uri_string());
		view('main', $data);
	}

	public function index()
	{
		$data['url'] = site_url('mahasiswa/evaluasi/');
		$this->_menu( view('admin/home', $data, TRUE), "Menu Utama");
	}

	function materi($id = null)
	{
		if($id == null)
		{
			$data['materi'] = $this->dbs->result('materi');
			//$data['__materi'] = TRUE; jika di suruh ditambahkan materi
			$data['url']	= site_url('main/materi/');
			$this->_menu( view('admin/materi', $data, TRUE), "Menu Materi");
		}
		else
		{
			$data['materi']	= $this->dbs->row_array('id', $id, 'materi');
			$data['form']	= form_open_multipart('main/materi/' . $data['materi']['id']);
			$data['hapus_photo'] = site_url('main/hapus-photo/materi/');
			$data['hapus_video'] = site_url('main/hapus-video/');
			set_rules('judul',    'Judul',  'required');
			set_rules('materi',   'Materi', 'required');
			set_rules('duration', 'Durasi', 'required');
			if(valid_run())
			{
				$photo = ($_FILES['photo']['size'] != 0) ?  
							insert_photo('photo','aset/photo/materi/', $data['materi']['photo_materi']) :
							$data['materi']['photo_materi'];
				
				$update = 
				[
					'name' 			=> posts('judul'),
					'text' 			=> posts('materi'),
					'duration' 		=> posts('duration'),
					'photo_materi' 	=> $photo,
					'video_materi' 	=> posts('video'),
				];
				$this->dbs->update('id', $data['materi']['id'], $update, 'materi');
				set_flashdata('success', info_success('Data Materi berhasil di simpan.'));
				redirect('main/materi/'. $data['materi']['id']);
			}
			$data['back']	= site_url('main/materi/');
			$this->_menu( view("admin/form-materi", $data, TRUE), "FORM MATERI");
		}
	}

	function data_evaluasi()
	{
		$data = $this->dbs->evaluasi();
		$json = [];

		foreach($data as $dt)
		{
			$jawaban = $dt->type_jawaban == 1 ? "ABC" : "Essay";
			$json[] = 
			[
				$dt->id,
				$dt->id_materi,
				$dt->soal,
				$jawaban
			];
		}
		
		echo json_encode($json);
	}

	function data_mahasiswa()
	{
		$data = $this->dbs->mahasiswa();
		$json = [];
		foreach($data as $dt)
		{
			$json[] = 
			[
				$dt->id_user,
				$dt->nama_kelas,
				$dt->name,
				$dt->nim
			];
		}
		echo json_encode($json);
	}

	function data_nilai($id_kelas = NULL)
	{
		$data = $id_kelas == NULL ? $this->dbs->nilai() : $this->dbs->nilai($id_kelas);
		$json = [];
		foreach($data as $dt)
		{
			$json[] = 
			[
				$dt->id,
				$dt->name,
				$dt->nim,
				$dt->nama_kelas,
				$dt->nilai_bab_1,
				$dt->nilai_bab_2,
				$dt->nilai_bab_3,
				$dt->nilai_bab_4,
			];
		}
		echo json_encode($json);
	}

	function evaluasi($kategori = null, $id = null)
	{
		if(($kategori != null && $id != null) || ($kategori != null && $id == null))
		{
			// mendapatkan data berdasarkan id jika parameters $kategori == edit
			if($kategori == 'edit') $data['evaluasi'] = $this->dbs->row_array('id', $id, 'evaluasi');

			$data['form'] = $kategori == "add" ? form_open_multipart('main/evaluasi/add', 'id="form-evaluasi"') : form_open_multipart('main/evaluasi/edit/' . $data['evaluasi']['id'], 'id="form-evaluasi"');

			#value input
			$data['soal'] 	      = $kategori == 'add' ? set_value("soal", "", TRUE)    : check_value($data['evaluasi']['soal'], posts('soal'));
			// jawaban abc yang benar
			$data['jawaban_abc']  = $kategori == 'add' ? set_value("jawaban_abc", "", TRUE) : check_value($data['evaluasi']['jawaban_abc'], posts('jawaban_abc'));

			$data['pembahasan']   = $kategori == 'add' ? set_value("pembahasan", "", TRUE) : check_value($data['evaluasi']['pembahasan'], posts('pembahasan'));
			$data['val_materi']   = $kategori == 'add' ? set_value("materi", "", TRUE) : check_value($data['evaluasi']['id_materi'], posts('materi'));
			$data['type_jawaban'] = $kategori == 'add' ? set_value("type_jawaban", "", TRUE) : check_value($data['evaluasi']['type_jawaban'], posts('type_jawaban'));

			// keseluruhan jawaban abc
			$data['opsi_a'] 	 = $kategori == 'add' ? set_value("opsi_a", "", TRUE) : check_value($data['evaluasi']['opsi_a'], posts('opsi_a'));
			$data['opsi_b'] 	 = $kategori == 'add' ? set_value("opsi_b", "", TRUE) : check_value($data['evaluasi']['opsi_b'], posts('opsi_b'));
			$data['opsi_c'] 	 = $kategori == 'add' ? set_value("opsi_c", "", TRUE) : check_value($data['evaluasi']['opsi_c'], posts('opsi_c'));
			$data['opsi_d'] 	 = $kategori == 'add' ? set_value("opsi_d", "", TRUE) : check_value($data['evaluasi']['opsi_d'], posts('opsi_d'));


			$data['essay'] 	 = $kategori == 'add' ? set_value("essay", "", TRUE) : check_value(posts('essay'), $data['evaluasi']['essay']);

			$data['photo_pembahasan'] = $kategori == 'edit' ? $data['evaluasi']['photo_pembahasan'] : NULL;
			$data['photo_soal'] 	  = $kategori == 'edit' ? $data['evaluasi']['photo_soal'] 		: NULL;
			#/value input

			$data['hapus_photo_soal'] 		= site_url('main/hapus-photo/soal/');
			$data['hapus_photo_pembahasan'] = site_url('main/hapus-photo/pembahasan/');
			$data['back'] 	= site_url('main/evaluasi/');
			$data['materi']	= $this->dbs->result('materi');

			// validasi
			set_rules('soal', 			'Soal', 		'required');
			set_rules('materi', 		'Materi', 		'required');
			set_rules('type_jawaban', 	'Tipe Jawaban', 'required');
			set_rules('pembahasan', 	'Pembahasan', 	'required');
			set_message('required', '%s harap di isi.');
			set_error_delimiters('<div class="form-error"><span>','</span></div>');

			if(valid_run())
			{
				$essay = NULL;

				if(posts('type_jawaban') == "2")
				{
					$essay = posts("essay");
				}

				$dt['soal'] 			= $data['soal'];
				$dt['id_materi'] 		= $data['val_materi'];
				$dt['type_jawaban'] 	= $data['type_jawaban'];
				$dt['jawaban_abc'] 		= posts('jawaban_abc');
				$dt['essay'] 			= trim($data['essay']);
				$dt['opsi_a'] 			= trim($data['opsi_a']);
				$dt['opsi_b'] 			= trim($data['opsi_b']);
				$dt['opsi_c'] 			= trim($data['opsi_c']);
				$dt['opsi_d'] 			= trim($data['opsi_d']);
				$dt['pembahasan'] 		= $data['pembahasan'];

				/// jika user upload gambar soal
				if($_FILES['photo_soal']['size'] != 0)
				{
					$dt['photo_soal'] = $kategori == 'edit' ? 
						insert_photo('photo_soal', 'aset/photo/soal/', $data['evaluasi']['photo_soal']) : 
						insert_photo('photo_soal', 'aset/photo/soal/') ;
					
				}
				// jika user upload gambar pembahasan
				if($_FILES['photo_pembahasan']['size'] != 0)
				{
					$dt['photo_pembahasan'] = $kategori == 'edit' ? 
						insert_photo('photo_pembahasan', 'aset/photo/pembahasan/', $data['evaluasi']['photo_pembahasan']) : 
						insert_photo('photo_pembahasan', 'aset/photo/pembahasan/');
				}

				// menyimpan data
				$database = $kategori == 'edit' ? 
				$this->dbs->update('id', $data['evaluasi']['id'], $dt, 'evaluasi') : 
				$this->dbs->insert($dt, 'evaluasi');

				// jika terjadi kesalahan di dalam menyimpan data.
				$database ? set_flashdata('success', info_success('Data berhasil di simpan')) :  set_flashdata('error', 'Terjadi kesalahan, data tidak dapat di simpan.');
				$redirect = $kategori == 'add' ? 'main/evaluasi/' : 'main/evaluasi/edit/' . $data['evaluasi']['id'];
				redirect($redirect);
			}
			
			$this->_menu( view('admin/form-evaluasi', $data,  TRUE), "Form Evaluasi");
		}
		else
		{
			$data['url']	= site_url('main/data-evaluasi/');
			$data['edit']	= site_url('main/evaluasi/edit/');
			$data['add']	= site_url('main/evaluasi/add/');
			$data['delete']	= site_url('main/delete/evaluasi/');
			$this->_menu( view('admin/evaluasi', $data, TRUE), "Menu Evaluasi");
		}
	}

	function kelas()
	{
		set_rules('nama', "Nama Kelas", 'required');
		set_message('required', '%s harap di isi.');
		set_error_delimiters('<div class="form-error"><span>','</span></div>');
		if(valid_run())
		{
			$insert['name'] = posts('nama');
			$this->dbs->insert($insert, 'kelas');
			set_flashdata('success', info_success('Data Kelas berhasil di simpan.'));
			redirect('main/mahasiswa/');
		}
		$this->mahasiswa();
	}

	function mahasiswa($kate = null, $id = null)
	{
		$data['kelas'] = $this->dbs->result('kelas');
		if( ($kate != NULL && $id == NULL) || ($kate != NULL && $id != NULL))
		{
			if($kate == 'edit') $mahasiswa = $this->dbs->row_array('id', $id, 'user');
			$data['form'] 	 = form_open( ($kate == 'add') ? 'main/mahasiswa/add/' : 'main/mahasiswa/edit/' . $mahasiswa['id'] );

			$data['name'] 	 = ($kate == 'add')  ? set_value("name", "", TRUE) 		: check_value($mahasiswa['name'], posts('name'));
			$data['nim']  	 = ($kate == 'add')  ? set_value("nim", "", TRUE) 		: check_value($mahasiswa['nim'], posts('nim'));
			$data['id_kelas']= ($kate == 'add')  ? set_value("id_kelas", "", TRUE) 	: check_value($mahasiswa['id_kelas'], posts('id_kelas'));
			$data['kel']  	 = ($kate == 'add')  ? set_value("id_kelas", "", TRUE) 	: check_value($mahasiswa['id_kelas'], posts('id_kelas'));
			$data['password']= ($kate == 'add')  ? set_value("password", "", TRUE) 	: check_value(_decrypt($mahasiswa['password']), posts('password'));

			$data['back']	 = site_url('main/mahasiswa/');

			set_rules('name', 		'Nama Mahasiswa', 	"required");
			set_rules('nim', 		'NIM Mahasiswa', 	"required");
			set_rules('id_kelas', 	'Kelas Mahasiswa', 	"required");
			set_rules('password', 	'Password', 		"required");
			set_message('required', '%s harap di isi.');
			set_error_delimiters('<div class="form-error"><span>','</span></div>');
			if(valid_run())
			{
				$dt['name'] 		= posts("name");
				$dt['nim']  		= posts("nim");
				$dt['id_kelas']  	= posts("id_kelas");
				$dt['password']  	= _encrypt(posts("password"));

				if($kate == 'add' && $this->dbs->row_array('nim', posts('nim'), 'user') ) 
				{
					set_flashdata('success', info_error('Ops, NIM Sudah ada, harap periksa kembali.'));
					redirect('main/mahasiswa/add/');
				} 
				else if($kate == 'edit' && posts('nim') != $data['nim'] && $this->dbs->row_array('nim', posts('nim'), 'user') )
				{
					set_flashdata('success', info_error('Ops, NIM Sudah ada, harap periksa kembali.'));
					redirect('main/mahasiswa/add/');
				}
				($kate == 'add') ? $this->dbs->insert( $dt, 'user' ) : $this->dbs->update('id', $mahasiswa['id'], $dt, 'user');

				if($kate == 'add')
				{
					$dt_nilai['id_mahasiswa'] = $this->db->insert_id();
					$dt_nilai['id_kelas']	  = posts('id_kelas');
					$this->dbs->insert($dt_nilai, 'nilai');
				}

				set_flashdata('success', info_success('Data Mahasiswa berhasil di simpan.'));
				redirect(($kate == 'add') ? "main/mahasiswa/add/" : 'main/mahasiswa/edit/' . $mahasiswa['id']);
			}
			$this->_menu( view('admin/form-mahasiswa', $data, TRUE), "Form Mahasiswa" );
		}
		else
		{
			$json_kelas = [];
			$i			= 1;
			foreach($data['kelas'] as $kelas)
			{
				$json_kelas[] = [$i => $kelas->name];
			}
			$data['url']		= site_url('main/data-mahasiswa/');
			$data['add']		= site_url('main/mahasiswa/add/');
			$data['edit']		= site_url('main/mahasiswa/edit/');
			$data['delete']		= site_url('main/delete/user/');
			$data['hapus_kelas']= site_url('main/delete/kelas/');
			$data['json_kelas'] = json_encode($json_kelas);
			$data['mahasiswa'] 	= $this->dbs->mahasiswa();
			$data['form']		= form_open('main/kelas/');
			$this->_menu( view('admin/mahasiswa', $data, TRUE), "Form Mahasiswa");
		}
	}

	function hapus_video($id = NULL)
	{
		$data 		= $this->dbs->row_array('id', $id, 'materi');

		unlink('aset/video/'. $data['video_materi']);

		$update['video_materi'] = NULL;

		$this->dbs->update('id', $data['id'], $update, 'materi');

		$json = ['success' => true];

		echo json_encode($json);
	}

	function hapus_photo($table, $id)
	{
		$dt_table 	= ($table == "pembahasan" || $table == 'soal') ? "evaluasi" : $table;
		$data 		= $this->dbs->row_array('id', $id, $dt_table);
		$update;
		if($table == "pembahasan")
		{
			$update = [ 'photo_pembahasan' => NULL];
		}
		else if($table == 'materi')
		{
			$update = ['photo_materi' => NULL];
		}
		else
		{
			$update = ['photo_soal' => NULL];
		}
		$this->dbs->update('id', $data['id'], $update, $dt_table);

		$json = ['success' => true];

		echo json_encode($json);
	}

	function nilai($id_mahasiswa = NULL)
	{
		if($id_mahasiswa != NULL)
		{
			$data['mahasiswa']  = $this->dbs->nilai_mahasiswa($id_mahasiswa);
			$data['back']		= site_url('main/nilai/');
			$data['form']		= form_open('main/nilai/' . $data['mahasiswa']['id']);
			set_rules('nilai_bab_1', "Nilai BAB 1", 'required');
			set_rules('nilai_bab_2', "Nilai BAB 2", 'required');
			set_rules('nilai_bab_3', "Nilai BAB 3", 'required');
			set_rules('nilai_bab_4', "Nilai BAB 4", 'required');

			if(valid_run())
			{
				$update['nilai_bab_1'] = posts('nilai_bab_1');
				$update['nilai_bab_2'] = posts('nilai_bab_2');
				$update['nilai_bab_3'] = posts('nilai_bab_3');
				$update['nilai_bab_4'] = posts('nilai_bab_4');
				$this->dbs->update('id', $data['mahasiswa']['id'], $update, 'nilai');
				set_flashdata('success', info_success("Data Nilai berhasil di simpan"));
				redirect('main/nilai/' . $data['mahasiswa']['id']);
			}

			$this->_menu( view("admin/detail-nilai", $data, TRUE), "Nilai Mahasiswa");
		}
		else
		{
			$data['id_kelas'] = $this->input->get("kelas") == 0 ? "" : $this->input->get("kelas");
			$data['form']	= form_open('main/nilai/', 'method="get"');
			$data['url'] 	= site_url('main/data-nilai/' . $data['id_kelas']);
			$data['kelas']  = $this->dbs->result('kelas');
			$data['detail'] = site_url('main/nilai/');
			$this->_menu( view("admin/nilai", $data, TRUE), "Nilai Mahasiswa");
		}
	}

	function akun()
	{	
		if(!userdata('akun'))
		{
			set_rules("username_lama", 'Username Lama', 'required');
			set_rules("password_lama", 'Password Lama', 'required');
		}
		else
		{
			set_rules("username_baru",   "Username Baru", 	 'required');
			set_rules("password_baru", 	 "Password Baru", 	 'required');
			set_rules("repassword_baru", "Re-Password Baru", 'required|matched[password_baru]');
		}
		if(valid_run())
		{
			if(!userdata("akun"))
			{
				$check = $this->dbs->row_array("username", posts('username_lama'), 'admin');
				if($check && posts('password_lama') == _decrypt($check['password_lama']))
				{
					set_userdata('akun', $check['id']);
					redirect('main/akun/');
					//redirect('main/mahasiswa/');
				}
				else
				{
					set_flashdata('error', info_error("Username atau Password Salah!"));
					redirect('main/akun/');
					//redirect('main/mahasiswa/');
				}
			}
			else
			{
				$update['username'] = posts('username_baru');
				$update['password'] = _encrypt(posts('password_baru'));
				$this->dbs->update('id', userdata('akun'), $update, 'admin');
				unset_userdata("akun");
				set_flashdata('success', info_success('Akun berhasil di update'));
				redirect('main/akun/');
			}
		}
		$data['form'] = form_open('main/akun/');
		//$this->mahasiswa();
		$this->_menu( view("admin/akun", $data, TRUE) , "Menu Akun");
	}

	function delete($table, $id)
	{
		$this->dbs->delete('id', $id, $table);
		if($table == 'user') $this->dbs->delete('id_mahasiswa', $id, 'nilai');
		redirect(userdata('link'));
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('login/');
	}

}
