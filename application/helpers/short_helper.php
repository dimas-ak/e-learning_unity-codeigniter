<?php
defined('BASEPATH') or exit('rika mau ngapa kang? :/');

if(!function_exists('photo_materi')){
    function photo_materi($src){
        $x =& get_instance();
        return $x->config->base_url('aset/photo/materi/'. $src);
    }
}

if(!function_exists('video_materi')){
    function video_materi($src){
        $x =& get_instance();
        return $x->config->base_url('aset/video/'. $src);
    }
}

if(!function_exists('photo_soal')){
    function photo_soal($src){
        $x =& get_instance();
        return $x->config->base_url('aset/photo/soal/'. $src);
    }
}

if(!function_exists('photo_main')){
    function photo_main($src){
        $x =& get_instance();
        return $x->config->base_url('aset/photo/main/'. $src);
    }
}

if(!function_exists('photo_pembahasan')){
    function photo_pembahasan($src){
        $x =& get_instance();
        return $x->config->base_url('aset/photo/pembahasan/'. $src);
    }
}

if(!function_exists('photo_galeri')){
    function photo_galeri($src){
        $x =& get_instance();
        return $x->config->base_url('aset/photo/galeri/'. $src);
    }
}

if(!function_exists('file_pendaftaran')){
    function file_pendaftaran($src){
        $x =& get_instance();
        return file_get_contents($x->config->base_url('aset/file/pendaftaran/'. $src));
    }
}

if(!function_exists('photo_user')){
    function photo_user($src){
        $x =& get_instance();
        return $x->config->base_url('aset/photo/user/'. $src);
    }
}

if(!function_exists('login_admin')){
    function login_admin(){
        $x =& get_instance();
        return $x->session->userdata('admin') ? TRUE : FALSE;
    }
}

if(!function_exists('userdata')){
    function userdata($name){
        $x =& get_instance();
        return $x->session->userdata($name) ? $x->session->userdata($name) : FALSE;
    }
}

if(!function_exists('set_userdata')){
    function set_userdata($name, $data){
        $x =& get_instance();
        return $x->session->set_userdata($name,$data);
    }
}

if(!function_exists('unset_userdata')){
    function unset_userdata($name){
        $x =& get_instance();
        return $x->session->unset_userdata($name);
    }
}

if(!function_exists('visitors')){
    function visitors($dir, $name = null){
        $x =& get_instance();
		$ip = $x->input->ip_address();
		$date = date('Y-m-d H:i:s');
		$array = ['visitors' =>
			['ip_address' => $ip, 'date' => $date]
		];

		$file = $dir . $name . '.txt';

		// serialize input ke array
		$serializedData = serialize($array);
		if (!in_array($ip, $file)) {
			$ip_all[] = $ip_cur;
			file_put_contents("ip.txt", implode($ip_all));
		}
		
		// simpan file menjadi ektensi txt
		return file_put_contents($file, $serializedData);
    }
}

if(!function_exists('check_value')){
    function check_value($data, $set_value){
        $x =& get_instance();
		$get = ($data != $set_value && strlen($set_value) == 0) ? $data : $set_value;
		return $get;
    }
}

if(!function_exists('insert_video'))
{
	function insert_video($name, $dir, $replace = null)
	{
		$ci =& get_instance();
		$ci->load->library('upload');
		$name_file;
		$config['upload_path'] 		= $dir; //path folder
		$config['allowed_types'] 	= 'mp4|flv|mpg|mpeg|avi'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] 	= TRUE; //Enkripsi nama yang terupload
		if(!empty($_FILES[$name]['name']))
		{
			$type = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
			$config['file_name'] = round(microtime(true)) . uniqid() . '.' . $type;
			$ci->upload->initialize($config);
			if ($ci->upload->do_upload($name))
			{
				$gbr = $ci->upload->data();
				$file_unlink = $dir . $replace;
				$name_file = $gbr['file_name'];
				$replace != null ? unlink("$file_unlink") : false;
			}        
		}
		return $name_file;
	}
}

if(!function_exists('insert_photo'))
{
	function insert_photo($name, $dir, $replace = null, $multiple = false)
	{
		$ci =& get_instance();
		$ci->load->library('upload');
		$name_file;
		$config['upload_path'] = $dir; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
		$config['encrypt_name'] = TRUE; //Enkripsi nama yang terupload
		if($multiple === TRUE)
		{
			$images = [];
			$files = $_FILES;
			$count = count($_FILES[$name]['name']);
			for ($i = 0; $i < $count; $i++) {
				$_FILES[$name]['name'] 		= $files[$name]['name'][$i];
			    $_FILES[$name]['type'] 		= $files[$name]['type'][$i];
			    $_FILES[$name]['tmp_name']  = $files[$name]['tmp_name'][$i];
			    $_FILES[$name]['error'] 	= $files[$name]['error'][$i];
				$_FILES[$name]['size'] 		= $files[$name]['size'][$i];
				
				$type = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
				$config['file_name'] = round(microtime(true)) . uniqid() . '.' . $type;

				$ci->upload->initialize($config);

				if ($ci->upload->do_upload($name)) {
					$gbr = $ci->upload->data();
					$file_unlink = $dir . $replace;
					$file_upload = $dir . $gbr['file_name'];
					list($src_width, $src_height) = getimagesize($file_upload);
					$height = (600 / $src_width) * $src_height;
					//Compress Image
					$image_library['image_library']='gd2';
					$image_library['source_image']= $file_upload;
					$image_library['create_thumb']= TRUE;
					$image_library['maintain_ratio']= TRUE;
					$image_library['quality']= '50%';
					$image_library['width']= 600;
					$image_library['height']= $height;
					$image_library['new_image']= $file_upload;
					$ci->load->library('image_lib', $image_library);
					$ci->image_lib->resize();
					$images[] = $gbr['file_name'];
				}
			}

			if($replace != null)
			{
				foreach(explode(',', $replace) as $unlink)
				{
					if($unlink != null)
					{
						unlink($dir . $unlink);
					}
				}
			}

			$name_file = implode(',', $images);

		}
		else
		{
			if(!empty($_FILES[$name]['name']))
			{
				$type = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
				$config['file_name'] = round(microtime(true)) . uniqid() . '.' . $type;
				$ci->upload->initialize($config);
				if ($ci->upload->do_upload($name))
				{
					$gbr = $ci->upload->data();
					$file_unlink = $dir . $replace;
					$file_upload = $dir . $gbr['file_name'];
					list($src_width, $src_height) = getimagesize($file_upload);
					$height = $src_height * (600 / $src_width);
					//Compress Image
					$image_library['image_library']		='gd2';
					$image_library['source_image']		= $file_upload;
					$image_library['create_thumb']		= FALSE;
					$image_library['maintain_ratio']	= FALSE;
					$image_library['quality']			= '30%';
					$image_library['width']				= 600;
					$image_library['height']			= $height;
					$image_library['new_image']			= $file_upload;
					$ci->load->library('image_lib', $image_library);
					$ci->image_lib->resize();
					$name_file = $gbr['file_name'];
					$replace != null ? unlink("$file_unlink") : false;
				}        
			}
		}
		return $name_file;
	}
}
	 function _files($nama, $type = null) {
	return ($type == null) ? $_FILES[$nama] : $_FILES[$nama][$type];
    }

     function _mb($angka) {
	return $angka * 1000000;
	}
if(!function_exists('uri_segment')){
	function uri_segment($segment){
		$ci =& get_instance();
		return $ci->uri->segment($segment);
	}
}

if(!function_exists('uri_string')){
	function uri_string(){
		$ci =& get_instance();
		return $ci->uri->uri_string();
	}
}
if(!function_exists('check_files_empty')){
	function check_files_empty($name){
		$i=1;
		foreach($_FILES[$name]['name'] as $file){
			if(empty($file))
			{
				echo "file $i empty";
				$i++;
			}
		}
	}
}

if (!function_exists('compress_gambar')) {

    function compress_gambar($new_name, $file, $dir, $width) {
		//direktori gambar
		$vdir_upload = $dir;
		$vfile_upload = $vdir_upload . $_FILES['' . $file . '']["name"];

		//Simpan gambar dalam ukuran sebenarnya
		move_uploaded_file($_FILES['' . $file . '']["tmp_name"], $dir . $_FILES['' . $file . '']["name"]);

		//identitas file asli
		$im_src = imagecreatefromjpeg($vfile_upload);
		$src_width = imageSX($im_src);
		$src_height = imageSY($im_src);

		//Set ukuran gambar hasil perubahan
		$dst_width = $width;
		$dst_height = ($dst_width / $src_width) * $src_height;

		//proses perubahan ukuran
		$im = imagecreatetruecolor($dst_width, $dst_height);
		imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

		//Simpan gambar
		imagejpeg($im, $vdir_upload . $new_name, 100);

		//Hapus gambar di memori komputer
		imagedestroy($im_src);
		imagedestroy($im);
		unlink("$vfile_upload");
    }

}

if(!function_exists('format_tanggal')){
    function format_tanggal($tgl){
        //$date_format = 'l, j F Y | H:i';
        $date_format = 'l, j F Y';
	    //$suffix = 'WIB';
	    $suffix = '';
	    if (trim($tgl) == '') {
		    $tgl = time();
	    } elseif (!ctype_digit($tgl)) {
		    $tgl = strtotime($tgl);
	    }
	    # remove S (st,nd,rd,th) there are no such things in indonesia :p
	    $date_format = preg_replace("/S/", "", $date_format);
	    $pattern = array(
		 '/Mon[^day]/', '/Tue[^sday]/', '/Wed[^nesday]/', '/Thu[^rsday]/',
		 '/Fri[^day]/', '/Sat[^urday]/', '/Sun[^day]/', '/Monday/', '/Tuesday/',
		 '/Wednesday/', '/Thursday/', '/Friday/', '/Saturday/', '/Sunday/',
		 '/Jan[^uary]/', '/Feb[^ruary]/', '/Mar[^ch]/', '/Apr[^il]/', '/May/',
		 '/Jun[^e]/', '/Jul[^y]/', '/Aug[^ust]/', '/Sep[^tember]/', '/Oct[^ober]/',
		 '/Nov[^ember]/', '/Dec[^ember]/', '/January/', '/February/', '/March/',
		 '/April/', '/June/', '/July/', '/August/', '/September/', '/October/',
		 '/November/', '/December/',
	    );
	    $replace = array('Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min',
		 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu',
		 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des',
		 'Januari', 'Februari', 'Maret', 'April', 'Juni', 'Juli', 'Agustus', 'September',
		 'Oktober', 'November', 'Desember',
	    );
	    $date = date($date_format, $tgl);
	    $date = preg_replace($pattern, $replace, $date);
	    $date = "{$date} {$suffix}";
        return $date;
    }
}

if (!function_exists('view')) {

    function view($path, $data = NULL, $return = FALSE) {
	$CI = & get_instance();
	return $CI->load->view($path, $data, $return);
    }

}

if (!function_exists('parse')) {

    function parse($path, $data = NULL, $return = false) {
	$CI = & get_instance();
	return $CI->parser->parse($path, $data, $return);
    }

}


if (!function_exists('info_error')) {

    function info_error($teks) {
	return '<div class="flashdata error"><span>' . $teks . '</span></div>';
    }

}

if (!function_exists('info_success')) {

    function info_success($teks) {
	return '<div class="flashdata success"><span>' . $teks . '</span></div>';
    }

}

if (!function_exists('selected')) {

    function selected($val_first, $val_last) {
	return ($val_first == $val_last) ? 'selected=""' : "";
    }

}

if (!function_exists('checked')) {

    function checked($val_first, $val_last) {
	return ($val_first == $val_last) ? 'checked="checked"' : "";
    }

}

if (!function_exists('set_flashdata')) {

    function set_flashdata($name_session, $data) {
	$CI = & get_instance();
	return $CI->session->set_flashdata($name_session, $data);
    }

}

if (!function_exists('flashdata')) {

    function flashdata($name_session) {
	$CI = & get_instance();
	return $CI->session->flashdata($name_session);
    }

}


if (!function_exists('posts')) {

    function posts($name, $ssx = FALSE) {
	$CI = & get_instance();
	return $CI->input->post($name, $ssx);
    }

}
if (!function_exists('set_rules')) {

    function set_rules($name, $string, $validation) {
	$CI = & get_instance();
	return $CI->form_validation->set_rules($name, $string, $validation);
    }

}
if (!function_exists('set_error_delimiters')) {

    function set_error_delimiters($teks, $teks_2) {
	$CI = & get_instance();
	return $CI->form_validation->set_error_delimiters($teks, $teks_2);
    }

}
if (!function_exists('valid_run')) {

    function valid_run() {
	$CI = & get_instance();
	return $CI->form_validation->run();
    }

}
if (!function_exists('set_message')) {

    function set_message($validation, $text) {
	$CI = & get_instance();
	return $CI->form_validation->set_message($validation, $text);
    }

}
if (!function_exists('lihat_selengkapnya')) {

    function lihat_selengkapnya($teks, $batas, $link = null) {
	$kalimat = strlen($teks);
	if ($kalimat > $batas) {
	    $potong = substr($teks, 0, $batas);
	    if ($link != null) {
		$kalimat = strip_tags(substr($potong, 0, strrpos($potong, ' '))) . ' [... <a href="' . $link . '">Lihat Selengkapnya</a> ...]';
	    } else {
		$kalimat = strip_tags(substr($potong, 0, strrpos($potong, ' '))) . ' [...]';
	    }
	} else {
	    if ($link != null) {
		$kalimat = strip_tags($teks) . ' [... <a href="' . $link . '">Lihat Selengkapnya</a> ...]';
	    } else {
		$kalimat = strip_tags($teks);
	    }
	}
	return $kalimat;
    }

}
if (!function_exists('acak_string')) {

    function acak_string($panjang = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $panjang; $i++) {
	    $randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
    }

}

if (!function_exists('safe_encrypt')) 
{
	function safe_encrypt($string, $url_safe=TRUE)
	{
		$CI =& get_instance();
		$ret = $CI->encryption->encrypt($string);

		if ($url_safe)
		{
			$ret = strtr(
					$ret,
					array(
						'+' => '.',
						'=' => '-',
						'/' => '~'
					)
				);
		}

		return $ret;
	}
}


if (!function_exists('_decrypt')) 
{
	function _decrypt($string)
	{
		$CI =& get_instance();
		return $CI->encryption->decrypt($string);
	}
}

if (!function_exists('_encrypt')) 
{
	function _encrypt($string)
	{
		$CI =& get_instance();
		return $CI->encryption->encrypt($string);
	}
}

if (!function_exists('safe_decrypt')) 
{
	function safe_decrypt($string)
	{
		$CI =& get_instance();
		$string = strtr(
				$string,
				array(
					'.' => '+',
					'-' => '=',
					'~' => '/'
				)
			);

		return $CI->encryption->decrypt($string);
	}
}