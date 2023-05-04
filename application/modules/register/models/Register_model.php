<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model
{
    private $_table = 'user_antri';

    public function getAll(){
        return $this->db->get($this->_table)->result();
    }

    public function maxreg(){
        $this->db->from('max_registrasi');
        return $this->db->get()->row()->maxreg;
    }

    public function hitungpendaftar(){
        date_default_timezone_set('Asia/Jakarta');
        $waktu =  date("Y-m-d H:i:s");
        $tanggal = date('Y-m-d', strtotime($waktu));

        $this->db->select('id');
        $this->db->from($this->_table);
        // $this->db->where('UNIX_TIMESTAMP(STR_TO_DATE(created_at, "%Y-%m-%d")) = ',$tanggal);
        $this->db->where('(STR_TO_DATE(created_at, "%Y-%m-%d")) = ',$tanggal);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function addregtoday(){
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');

        $this->db->where('tanggal',$tanggal);
        $row = $this->db->get('max_day');
     
        if ( $row->num_rows() > 0 ) 
        {
            $this->db->where('tanggal', $tanggal);
            $this->db->set('countmax', 'countmax+1', FALSE);
            $this->db->update('max_day');

        } else {
            $add=array(
                'tanggal'=>$tanggal,
                'countmax'=>1,
            );
            $this->db->insert('max_day', $add);
        }
    }
    
    public function dataktp(){
        $nik = $this->input->post('nik');

        $this->db->select('*');
        $this->db->from('user_antri');
        $this->db->where('nik', $nik);

        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function checkktp($intervalktp){
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d', strtotime("-$intervalktp days"));

        $nik = $this->input->post('nik');

        $this->db->select('*');
        $this->db->from('user_antri');
        $this->db->where('nik', $nik);
        $this->db->where('(STR_TO_DATE(created_at, "%Y-%m-%d")) >= ',$tanggal);

        $query = $this->db->get();
        $first = $query->row();
        
        if ($query->num_rows() > 0) {
            //ada data / tidak bisa daftar
            return false;
        } else {
            //tidak ada data / bisa daftar;
            return true;
        }
    }

    public function add(){
        date_default_timezone_set('Asia/Jakarta');
        $waktu =  date("Y-m-d H:i:s");
        
        $add=array(
			'nama'=>$this->input->post('nama'),
			'alamat'=>$this->input->post('alamat'),
			'nohp'=>$this->input->post('nohp'),
			'email'=>$this->input->post('email'),
			'nik'=>$this->input->post('nik'),
			'tgl_lahir'=>$this->input->post('tgl_lahir'),
			'jk'=>$this->input->post('jk'),
			'file_ktp'=>$this->uploadfoto(),
			'tgl_periksa'=>$this->input->post('tgl_periksa'),
			'no_antrian'=>$this->input->post('no_antrian'),
			'jenisperiksa'=>$this->input->post('jenisperiksa'),
			'pembayaran'=>$this->input->post('pembayaran'),
			'pemblain'=>$this->input->post('pemblain'),
			'created_at'=>$waktu,
		);
        return array(
            'hasil'     => $this->db->insert($this->_table, $add),
            'insertid'  => $this->db->insert_id()
        );
        // return 
    }

    public function uploadfoto(){
        $config['upload_path']      = './assets/img/ktp/';
		$config['allowed_types']    = 'gif|jpg|png|jpeg';
		$config['max_size']         = '10240';
        $config['overwrite']        = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file_ktp')) {
            return $this->upload->data("file_name");
        }
        else{
            print_r($this->upload->display_errors());
        }
        
    }
    
    public function datapendaftar($lastid){
        $this->db->select('*');
        $this->db->from('user_antri');
        $this->db->where('id', $lastid);

        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

}