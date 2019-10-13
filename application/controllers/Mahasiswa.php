<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');
class Mahasiswa extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('dbs');
    }
    function materi()
    {
        $data   = $this->dbs->result("materi");
        $json   = [];

        foreach($data as $dt)
        {
            $json[] = 
            [
                'judul'      => $dt->name,
                'photo'      => $dt->photo_materi == NULL ? photo_main("error-image.png") : photo_materi($dt->photo_materi),
                'keterangan' => $dt->text,
                'duration'   => $dt->duration * 60
            ];
        }

        echo json_encode($json);
    }

    function evaluasi()
    {
        $materi = $this->dbs->result("materi");
        $json = [];

        foreach($materi as $m)
        {
            $data = $this->db->where('id_materi', $m->id, TRUE)->order_by('rand()')->get('evaluasi')->result();
            $soal = [];
            foreach($data as $dt)
            {
    
                $abc = [
                    0 => $dt->opsi_a,
                    1 => $dt->opsi_b, 
                    2 => $dt->opsi_c,
                    3 => $dt->opsi_d
                ];
                
                $jawaban = $this->_jawaban($abc);

                $soal[] = 
                [
                    
                    'id_soal'           => $dt->id,
                    'bab'               => $dt->id_materi,
                    'soal'              => $dt->soal,
                    'photo_soal'        => $dt->photo_soal == NULL ? "kosong" : $dt->photo_soal,
                    'type_jawaban'      => $dt->type_jawaban,
                    'jawaban_abc'       => $dt->jawaban_abc,
                    'abc'               => $jawaban["value"],
                    'abc_key'           => $jawaban["key"],
                    'essay'             => $dt->essay,
                    'pembahasan'        => $dt->pembahasan,
                    'photo_pembahasan'  => $dt->photo_pembahasan == NULL ? photo_main("error-image.png") : $dt->photo_pembahasan,
    
                ];
            }
            $json[] = [ "evaluasi_bab" => $m->id, "pertanyaan" => $soal ];

        }

        echo json_encode($json);
    }

    protected function _jawaban($data)
    {
        $result = [];
        $keys = array_keys($data);
        shuffle($keys);
        foreach($keys as $k)
        {
            $result["key"][] = $k;
            $result["value"][] = $data[$k];
        }
        return $result;
    }

    function tampil_materi($id = null)
    {
        if($id != NULL)
        {
            $data['materi'] = $this->dbs->row_array('id', $id, 'materi');
            view("materi-user", $data);
        }
    }

    function tampil_pembahasan($id_soal = NULL)
    {
        if($id_soal != NULL)
        {
            $data['evaluasi'] = $this->dbs->row_array('id', $id_soal, 'evaluasi');
            view("pembahasan-evaluasi-user", $data);
        }
    }

    function nilai()
    {
        set_rules("id_mahasiswa", "ID Mahasiswa", "required");
        set_rules("id_kelas", "ID Kelas", "required");
        $json['info'] = "error";
        if(valid_run())
        {
            $data['id_mahasiswa'] = posts('id_mahasiswa');
            $data['id_kelas']     = posts('id_kelas');
            $data['nilai_bab_1']  = posts('nilai_bab_1');
            $data['nilai_bab_2']  = posts('nilai_bab_2');
            $data['nilai_bab_3']  = posts('nilai_bab_3');
            $data['nilai_bab_4']  = posts('nilai_bab_4');
            $check = $this->dbs->row_array("id_mahasiswa", posts('id_mahasiswa'), 'nilai');
            ($check) ? $this->dbs->update("id_mahasiswa", $check['id'], $data, 'nilai') : $this->dbs->insert($data, 'nilai');
            $json['info'] = 'success';
        }
        echo json_encode($json);
    }
}