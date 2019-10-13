<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');
class Dbs extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function row_array($field, $value, $table)
    {
        return $this->db->where($field, $value, TRUE)->get($table)->row_array();
    }
    function result($table)
    {
        return $this->db->get($table)->result();
    }
    function result_key($field, $value, $table)
    {
        return $this->db->where($field, $value, TRUE)->get($table)->result();
    }
    function delete($field, $value, $table)
    {
        return $this->db->where($field, $value, TRUE)->delete($table);
    }
    function insert($data, $table)
    {
        return $this->db->insert($table, $data);
    }
    function update($field, $value, $data, $table)
    {
        return $this->db->where($field, $value, TRUE)->update($table, $data);
    }
    function evaluasi($rand = false)
    {
        return $this->db->select("evaluasi.*, materi.id as id_materi, materi.name as name_materi")->from('evaluasi')->join('materi', 'materi.id = evaluasi.id_materi')->order_by('materi.id', $rand ? 'asc' : 'rand()')->get()->result();
    }

    function mahasiswa()
    {
        return $this->db->select("user.*, user.id as id_user, kelas.id, kelas.name as nama_kelas")->from("user")->join("kelas", "kelas.id = user.id_kelas")->get()->result();
    }

    function nilai($kelas = NULL)
    {
        $this->db->select("nilai.*, user.name, user.id_kelas, user.nim, kelas.name as nama_kelas")->from("nilai")->join("user", "user.id = nilai.id_mahasiswa")->join("kelas", "user.id_kelas = kelas.id");
        if($kelas != NULL)
        {
            $this->db->where("user.id_kelas", $kelas, TRUE);
        }
        return $this->db->get()->result();
    }
    function nilai_mahasiswa($id = NULL)
    {
        $this->db->select("nilai.*, user.name, user.id_kelas, user.nim, kelas.name as nama_kelas")->from("nilai")->where('nilai.id', $id, TRUE)->join("user", "user.id = nilai.id_mahasiswa")->join("kelas", "user.id_kelas = kelas.id");
        return $this->db->get()->row_array();
    }
}