<?php
/*
 * Generated by CRUDigniter v3.2
 * www.crudigniter.com
 */

class Bpk_satpam extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Bpk_model');
        $this->load->model('Rekap_pembayaran_log_model');

    }

    /*
     * Listing of bpk
     */
    function index()
    {
        $data['bpk'] = $this->Bpk_model->get_all_bpk();
        $data['jumlah_bpk'] = $this->Bpk_model->jumlah_bpk();

        $data['_view'] = 'bpk_satpam/index';
        $this->load->view('bpk_satpam/index',$data);
    }



    /*
     * Adding a new bpk
     */
    function add()
    {
        $this->load->library('form_validation');

    $this->form_validation->set_rules('no_bpk','No BPK','required|max_length[20]');
    $this->form_validation->set_rules('nama_supplier','Nama Supplier','required|max_length[20]');
		$this->form_validation->set_rules('nama_sopir','Nama Sopir','required|max_length[20]');
		$this->form_validation->set_rules('dokumen','Dokumen','max_length[45]');
		$this->form_validation->set_rules('asal','Asal','max_length[45]');
		$this->form_validation->set_rules('jumlah_batang_pcs','Jumlah Batang Pcs','integer');
		$this->form_validation->set_rules('volume_m3','Volume M3','integer');
		$this->form_validation->set_rules('no_hp','No Hp','max_length[12]');
		$this->form_validation->set_rules('no_polisi','No Polisi','max_length[10]');
    // $this->form_validation->set_rules('jenis','Jenis','required');
    $this->form_validation->set_rules('jenis_kayu','Jenis Kayu','required');

		if($this->form_validation->run())
        {

            $params = array(
        'no_bpk' => $this->input->post('no_bpk'),
        // 'jenis' => $this->input->post('jenis'),
        'jenis_kayu' => $this->input->post('jenis_kayu'),
				'tanggal' => $this->Bpk_model->InggrisTgl($this->input->post('tanggal')),
				'nama_supplier' => $this->input->post('nama_supplier'),
				'nama_sopir' => $this->input->post('nama_sopir'),
				'dokumen' => $this->input->post('dokumen'),
				'jumlah_batang_pcs' => $this->input->post('jumlah_batang_pcs'),
				'volume_m3' => $this->input->post('volume_m3'),
        'no_hp' => $this->input->post('no_hp'),
        'no_hp_sopir' => $this->input->post('no_hp_sopir'),
				'jam_masuk' => $this->input->post('jam_masuk'),
				'no_polisi' => $this->input->post('no_polisi'),
				'asal' => $this->input->post('asal'),
            );

            $bpk_id = $this->Bpk_model->add_bpk($params);
            $this->Bpk_model->add_rekap_log($this->input->post('no_bpk'));
            $this->Bpk_model->add_bongkar_log($this->input->post('no_bpk'));
            $this->Bpk_model->add_cek_log($this->input->post('no_bpk'));
            $this->Bpk_model->add_selisih_stok($this->input->post('no_bpk'));

            //session simpan bpk
            $result = $this->Bpk_model->get_bpk($params['no_bpk']);
            $this->session->set_userdata($result);

            redirect('bpk_satpam');

        }
        else
        {
            $data['_view'] = 'bpk_satpam/add';
            $this->load->view('bpk_satpam/add',$data);
        }
    }

  }