<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author Indra Gunanda
 */
class Pinjaman extends CI_Controller{
  /**
 	 * Konstruktor
 	 *
 	 * @return void
	 */

  public function __construct()
  {
    parent::__construct();
    $this->load->model("crud/main");
    if ($this->session->level != "karyawan") {
      redirect(base_url("public"));
    }
  }
  /**
 	 * Index Home
 	 *
 	 * @return void
	 */

  public function index()
  {
    $this->template->setFolder("karyawan");
    $this->template->defaultStyle("front");
    $data = [];
    $this->main->setJoin([
      "table"=>"pinjaman",
      "join"=>[
        "users|users.nip = pinjaman.nip|null"
      ]
    ]);
    foreach ($this->main->get(["pinjaman.nip"=>$this->session->nip])->result() as $key => $value) {
      $value->jumlah_pinjaman = number_format($value->jumlah_pinjaman);
      $value->action = "";
      $data[] = $value;
    }
    foreach ($data as $key => &$value) {
      if ($value->status_pengajuan == "menunggu") {
        $value->status_pengajuan = "<center><span class='badge badge-danger'>Menunggu</span></center>";
      }else {
        $value->status_pengajuan = "<center><span class='badge badge-success'>Disetujui</span></center>";
      }
      if ($value->status_pinjaman == "belum") {
        $value->status_pinjaman = "<center><span class='badge badge-danger'>Belum</span></center>";
      }else {
        $value->status_pinjaman = "<center><span class='badge badge-success'>Lunas</span></center>";
      }
    }
    $build = [
      "block_title"=>"Pinjaman Pegawai",
      "data_pinjam"=>$data
    ];
    $this->template->renderHTML(['head','pinjaman','foot'],['title'=>"Pinjaman Pegawai",'other'=>$build]);
  }
  public function detail($id='')
  {
    $this->main->setTable("pinjaman");
    if ($this->main->get(["id_pinjaman"=>$id])->num_rows() > 0) {
      $this->template->setFolder("karyawan");
      $this->template->defaultStyle("front");
      $data = [];
      $this->main->setTable("pinjaman_detail");
      $total_bayar = 0;
      $x = $this->main->get(["id_pinjaman"=>$id]);
      $this->main->setJoin([
        "table"=>"pinjaman",
        "join"=>[
          "users|users.nip = pinjaman.nip|null"
        ]
      ]);
      $info = $this->main->get(["id_pinjaman"=>$id])->row();
      foreach ($x->result() as $key => $value) {
        $total_bayar = $total_bayar + $value->total_bayar;
      }
      $info->total_bayar = $total_bayar;
      $build = [
        "block_title"=>"Detail Pinjaman [{$id}]",
        "angsuran"=>$x->result_array(),
        "msg"=>$this->session->flashdata("message")
      ];
      $ext = [
        "info"=>$info
      ];
      $this->template->renderHTML(['head','pinjaman_detail','foot'],["extend"=>$ext,'title'=>"Detail Pinjaman [{$id}]",'other'=>$build]);
    }else {
      redirect($_SERVER["HTTP_REFERER"]);
    }
  }
  public function create()
  {
    $dpost = $this->input->post(null,true);
    $this->main->setTable("divisi");
    $cekgaji = $this->main->get(["id_divisi"=>$this->session->id_divisi])->row()->gaji_pokok;
    $persentase = ($cekgaji/2);
    $ix = 1;
    $dpost["cicilan"] = ($dpost["jumlah_pinjaman"] / $dpost["lama_angsuran"]);

    $dpost["nip"] = $this->session->nip;
    $this->main->setTable("pinjaman");
    if ($this->main->get(["nip"=>$this->session->nip,"status_pinjaman"=>"belum"])->num_rows() > 0) {
      $this->session->set_flashdata("message",'<div class="alert alert-danger">Pinjaman Sebelumnnya Belum di Lunasi</div>');
        redirect($_SERVER['HTTP_REFERER']);
    }
    $num = $this->main->get(["nip"=>$this->session->nip])->num_rows() + 1;
    $dpost["id_pinjaman"] = "P".$this->session->nip."-".str_pad($num,3,"000",STR_PAD_LEFT);
    $this->main->setTable("pinjaman");
    $ins = $this->main->insert($dpost);
    if ($ins) {
      $this->session->set_flashdata("message",'<div class="alert alert-success">Sukses Pengajuan Pinjaman, Menunggu Verifikasi Owner</div>');
    }else {
      $this->session->set_flashdata("message",'<div class="alert alert-danger">Gagal Simpan Data</div>');
    }
    redirect($_SERVER['HTTP_REFERER']);
  }
  public function tambah()
  {
    $this->template->setFolder("karyawan");
    $this->template->defaultStyle("front");
    $id = $this->session->id_divisi;
    $this->main->setTable("divisi");
    $gapok = $this->main->get(["id_divisi"=>$id])->row()->gaji_pokok;
    $build = [
      "block_title"=>"Pengajuan Pinjaman",
      "action"=>base_url("karyawan/pinjaman/create"),
      "max_gaji"=>$gapok*3,
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','pengajuan','foot'],['title'=>"Pengajuan Pinjaman",'other'=>$build]);

  }
}
