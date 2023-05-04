<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Register extends CI_Controller {
 
	public $lastid = "";

	public function __construct()
    {
		parent::__construct();
		$this->load->library('form_validation');
        $this->load->model('Register_model');
	}

	public function index()
	{
		$data['antrian'] = $this->Register_model->hitungpendaftar();
		$this->load->view('Index', $data);
	}

	public function store()
	{
        //jarak hari bisa daftar dengan ktp yang sama
		$intervalktp = 4;
		
		$dataktp = $this->Register_model->dataktp();
		$checkktp = $this->Register_model->checkktp($intervalktp);
		
		if($checkktp == false){
			// ada data ktp / tidak bisa daftar
			$daftar = $dataktp->created_at;
			$tanggaldaftar = date('d F Y', strtotime($daftar));
			$tanggalbisadaftar = date('d F Y', strtotime($tanggaldaftar. "+5 days"));
			
			$this->session->set_flashdata('pesan', "Nomor KTP tersebut sudah terdaftar pada $tanggaldaftar, pendaftaran dengan ktp yang sama dibatasi selama $intervalktp hari, coba lagi pada $tanggalbisadaftar");
			redirect(base_url('Register'), 'refresh');
		}else{
			// tidak ada data ktp / bisa daftar
			$emailto = $this->input->post('email');

			$pendaftar = $this->Register_model->hitungpendaftar();
			$maxpendaftar = $this->Register_model->maxreg();

			$addmodel = $this->Register_model->add();

			$this->form_validation->set_rules('nama', 'nama','trim|required', array('required' => 'Nama harus diisi'));
			$this->form_validation->set_rules('alamat', 'alamat','trim|required', array('required' => 'Alamat harus diisi'));
			$this->form_validation->set_rules('nohp', 'nohp','trim|required', array('required' => 'Nomor HP harus diisi'));
			$this->form_validation->set_rules('email', 'email','trim|required', array('required' => 'Email harus diisi'));
			$this->form_validation->set_rules('nik', 'nik','trim|required', array('required' => 'NIK harus diisi'));
			$this->form_validation->set_rules('tgl_lahir', 'tgl_lahir','trim|required', array('required' => 'Tanggal Lahir harus diisi'));
			$this->form_validation->set_rules('jk', 'jk','trim|required', array('required' => 'Jenis Kelamin harus diisi'));
			$this->form_validation->set_rules('tgl_periksa', 'tgl_periksa','trim|required', array('required' => 'Tanggal Periksa harus diisi'));
			$this->form_validation->set_rules('no_antrian', 'no_antrian','trim|required', array('required' => 'Nomor Antrian harus diisi'));
			$this->form_validation->set_rules('jenisperiksa', 'jenisperiksa','trim|required', array('required' => 'Jenis Periksa harus diisi'));
			$this->form_validation->set_rules('pembayaran', 'pembayaran','trim|required', array('required' => 'Pembayaran harus diisi'));

			if($pendaftar <= $maxpendaftar){

				if ($this->form_validation->run() == TRUE ) 
				{
					$tambah=$addmodel['hasil'];
					if($tambah==true){
						$this->lastid = $addmodel['insertid'];
						$this->Register_model->addregtoday();
						$this->sendmail($this->lastid);
						$this->session->set_flashdata('pesan','Sukses Daftar');
					} else{
						$this->session->set_flashdata('pesan', 'Gagal Daftar');
					}

					redirect(base_url('Register/Success/'.$this->lastid),'refresh');
				} else {
					$this->session->set_flashdata('pesan', validation_errors());
					redirect(base_url('Register/Index'), 'refresh');
				}

			}else{
				$this->session->set_flashdata('pesan', 'Kuota pendaftaran hari ini penuh');
				redirect(base_url('Register'), 'refresh');
			}
		}
	}

	public function success($lastid)
	{
		$data['pendaftar'] = $this->Register_model->datapendaftar($lastid);
		$this->load->view('Success',$data);
	}

	public function pdf($lastid)
	{
		$data['pendaftar'] = $this->Register_model->datapendaftar($lastid);
		if($data['pendaftar']->jenisperiksa == 1){
			$data['jenisperiksa'] = 'PCR SWAB';
		}else if($data['pendaftar']->jenisperiksa == 2){
			$data['jenisperiksa'] = 'PCR ANTIGEN';
		}else if($data['pendaftar']->jenisperiksa == 3){
			$data['jenisperiksa'] = 'RAPID ANTIGEN';
		}

		if($data['pendaftar']->pembayaran == 1){
			$data['pembayaran'] = 'tunai';
		}else if($data['pendaftar']->pembayaran == 2){
			$data['pembayaran'] = 'denit';
		}else if($data['pendaftar']->pembayaran == 3){
			$data['pembayaran'] = 'credit card';
		}else{
			$data['pembayaran'] = $data['pendaftar']->pemblain;
		}

		$this->load->library('pdf');
		$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->filename = "laporan.pdf";
		$this->pdf->load_view('Pdf_view', $data);
	}

	public function sendmail($lastid)
    {
		$pendaftar = $this->Register_model->datapendaftar($lastid);
		$urlpdf = base_url().'register/pdf/'.$pendaftar->id;
		
		if($pendaftar->jenisperiksa == 1){
			$jenisperiksa = 'PCR SWAB';
		}else if($pendaftar->jenisperiksa == 2){
			$jenisperiksa = 'PCR ANTIGEN';
		}else if($pendaftar->jenisperiksa == 3){
			$jenisperiksa = 'RAPID ANTIGEN';
		}

		if($pendaftar->pembayaran == 1){
			$pembayaran = 'tunai';
		}else if($pendaftar->pembayaran == 2){
			$pembayaran = 'denit';
		}else if($pendaftar->pembayaran == 3){
			$pembayaran = 'credit card';
		}else{
			$pembayaran = $pendaftar->pemblain;
		}

        $config = [
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            // 'smtp_user' => 'example@gmail.com',
            // 'smtp_pass'   => 'example',
            'smtp_crypto' => 'ssl',
            'smtp_port'   => 993,
            'crlf'    => "\r\n",
            'newline' => "\r\n"
        ];
        $this->load->library('email', $config);
        $this->email->from('no-reply@antriyakk.com', 'Antriyakk');
        $this->email->to($pendaftar->email);
		$this->email->subject('Informasi Antriyakk Antrian Antriyakk');
		$this->email->message("Terima kasih $pendaftar->nama telah mendaftar antrian jasa periksa Antriyakk <br> <br> Anda telah mendaftar periksa jenis $jenisperiksa pada $pendaftar->created_at untuk periksa tanggal $pendaftar->tgl_periksa dengan nomor antrian $pendaftar->no_antrian dan dengan pembayaran $pembayaran <br><br> <a href='$urlpdf'>Download PDF</a>");
        $this->email->send();
    }
 
}