<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if(login_admin()){redirect();}
        $this->load->model('dbs');
    }

    function index()
    {
        $data['jquery'] = site_url('aset/js/jquery.js');
		$data['css'] 	= site_url('aset/css/arjunane.css?' . rand());
        $data['js']		= site_url('aset/js/arjunane.js?' . rand());
        $view['form']   = form_open('login/');
        $data['view']	= view('login',$view, TRUE);
        $data['title']  = "Menu Login";
        set_rules('username', 'Username', 'required');
        set_rules('password', 'Password', 'required');
        if(valid_run())
        {
            $check = $this->dbs->row_array('username', posts('username'), 'admin');
            if($check && _decrypt($check['password']) == posts('password'))
            {
                set_userdata('admin', $check['id']);
                redirect();
            }
            else
            {
                set_flashdata('error', info_error('Username atau Password Salah'));
                redirect('login/');
            }
        }
		view('main', $data);
    }
    
    function mahasiswa()
    {
        set_rules("nim",        'NIM',      'required');
        set_rules("password",   'Password', 'required');
        $json['info'] = false;
        $json['user'] = [];
        if(valid_run())
        {
            $check = $this->dbs->row_array("nim", posts('nim'), 'user');
            if($check && posts('password') == _decrypt($check['password']))
            {
                $json['info']   = true;
                $kelas          = $this->dbs->row_array('id', $check['id_kelas'], 'kelas');
                $check_nilai    = $this->dbs->row_array("id_mahasiswa", $check['id'], 'nilai');
                $json['user'] = [
                    'id'            => $check['id'],
                    'nim'           => $check['nim'],
                    'nama'          => $check['name'],
                    'id_kelas'      => $check['id_kelas'],
                    'kelas'         => $kelas['name'],
                    'nilai_bab_1'   => $check_nilai ? $check_nilai['nilai_bab_1'] : 0,
                    'nilai_bab_2'   => $check_nilai ? $check_nilai['nilai_bab_2'] : 0,
                    'nilai_bab_3'   => $check_nilai ? $check_nilai['nilai_bab_3'] : 0,
                    'nilai_bab_4'   => $check_nilai ? $check_nilai['nilai_bab_4'] : 0,
                ];
            }
        }
        echo json_encode($json);
    }
}