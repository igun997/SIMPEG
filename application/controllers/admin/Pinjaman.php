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
    if ($this->session->level != "admin") {
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
    $this->template->setFolder("admin");
    $this->template->defaultStyle("front");
    $data = [];
    $this->main->setJoin([
      "table"=>"pinjaman",
      "join"=>[
        "users|users.nip = pinjaman.nip|null"
      ]
    ]);
    foreach ($this->main->get()->result() as $key => $value) {
      $value->jumlah_pinjaman = number_format($value->jumlah_pinjaman);
      $value->action = "";
      if ($value->status_pengajuan == "menunggu") {
        $value->action = "<a href='".base_url("admin/pinjaman/verif/").$value->nip."' class='btn btn-success'><li class='fa fa-check'></li></a>";
        $value->status_pengajuan = "<center><span class='badge badge-warning'>Menunggu</span></center>";
      }else {
        $value->status_pengajuan = "<center><span class='badge badge-success'>Disetujui</span></center>";
      }
      if ($value->status_pinjaman == "belum") {
        $value->status_pinjaman = "<center><span class='badge badge-danger'>Belum</span></center>";
      }else {
        $value->status_pinjaman = "<center><span class='badge badge-success'>Lunas</span></center>";
      }
      $data[] = $value;
    }
    $build = [
      "block_title"=>"Peminjaman Pegawai",
      "data_pinjam"=>$data
    ];
    $this->template->renderHTML(['head','pinjaman','foot'],['title'=>"Peminjaman Pegawai",'other'=>$build]);
  }
  public function verif($nip="")
  {
    $this->main->setTable("pinjaman");
    if ($this->main->get(["nip"=>$nip])->num_rows() > 0) {
      $this->main->update(["status_pengajuan"=>"disetujui"],["nip"=>$nip]);
    }
    redirect($_SERVER["HTTP_REFERER"]);
  }
  public function detail($id="")
  {
    if (isset($_POST["total_bayar"])) {
      $this->main->setTable("pinjaman_detail");
      $tp = 0;
      $l = $this->main->get(["id_pinjaman"=>$id])->result();
      foreach ($l as $key => $value) {
        $tp = $value->total_bayar + $tp;
      }
      $dpost = $this->input->post(null,true);
      $dpost["id_pinjaman"] = $id;
      $this->main->setTable("pinjaman");
      $info = $this->main->get(["id_pinjaman"=>$id])->row();
      if (($dpost["total_bayar"] + $tp) > $info->jumlah_pinjaman) {
        $this->session->set_flashdata("message","<div class='alert alert-danger'>Angsuran Terlalu Besar</div>");
      }else {
        if (($dpost["total_bayar"] + $tp) == $info->jumlah_pinjaman) {
          $this->main->update(["status_pinjaman"=>"lunas"],["id_pinjaman"=>$id]);
        }
        $this->main->setTable("pinjaman_detail");
        $ins = $this->main->insert($dpost);
        if ($ins) {
          $this->session->set_flashdata("message","<div class='alert alert-success'>Sukses Simpan Data</div>");
        }else {
          $this->session->set_flashdata("message","<div class='alert alert-danger'>Gagal Simpan Data</div>");
        }
      }
    }
    $this->main->setTable("pinjaman");
    if ($this->main->get(["id_pinjaman"=>$id])->num_rows() > 0) {
      $this->template->setFolder("admin");
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
        "block_title"=>"Detail Pinjaman [{$id}] - [{$info->nama}]",
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
}
