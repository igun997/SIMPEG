<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author Indra Gunanda
 */
class Divisi extends CI_Controller{
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
    $this->main->setTable("divisi");
    $data = $this->main->get();

    $build = [
      "block_title"=>"Data Divisi",
      "data_divisi"=>$data->result_array(),
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','divisi','foot'],['title'=>"Data Divisi",'other'=>$build]);
  }
  public function tunjangan($nip)
  {
    if ($this->input->get("cmd") == "hapus") {
      $this->main->setTable("overtime_divisi");
      $hapus = $this->main->delete(["id_od"=>$this->input->get("id")]);
      if ($hapus) {
        $this->session->set_flashdata("message",'<div class="alert alert-success">Sukses Hapus Data </div>');
      }else {
        $this->session->set_flashdata("message",'<div class="alert alert-danger">Gagal Hapus Data </div>');
      }
      redirect($_SERVER["HTTP_REFERER"]);
    }
    if (isset($_POST["id_overtime"])) {
      $this->main->setTable("overtime_divisi");
      $d = $this->input->post(null,true);
      $d["id_divisi"] = $nip;
      $h = $this->main->insert($d);
      if ($h) {
        $this->session->set_flashdata("message",'<div class="alert alert-success">Sukses Simpan Data </div>');
      }else {
        $this->session->set_flashdata("message",'<div class="alert alert-danger">Gagal Simpan Data </div>');
      }
    }
    $this->main->setTable("divisi");
    $g = $this->main->get(["id_divisi"=>$nip])->row();
    $this->main->setTable("overtime");
    $d = $this->main->get();
    $this->main->setJoin([
      "table"=>"overtime_divisi",
      "join"=>[
        "overtime|overtime.id_overtime = overtime_divisi.id_overtime|null"
      ]
    ]);
    $x = $this->main->get(["overtime_divisi.id_divisi"=>$nip]);
    $ext = [
      "overtime"=>$d,
      "ov"=>$x
    ];
    $this->template->setFolder("admin");
    $this->template->defaultStyle("front");
    $this->main->setTable("users");
    $build = [
      "block_title"=>"Tambah Tunjangan Divisi [{$g->nama_divisi}]",
      "action"=>base_url("admin/divisi/tunjangan")."/".$nip,
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','tunjangan_divisi','foot'],['extend'=>$ext,'title'=>"Tambah Tunjangan Pegawai",'other'=>$build]);
  }
  public function update($id='')
  {
    $dpost = $this->input->post(null,true);
    $this->main->setTable("divisi");
    $ins = $this->main->update($dpost,["id_divisi"=>$id]);
    if ($ins) {
      $this->session->set_flashdata("message",'<div class="alert alert-success">Sukses Simpan Data</div>');
    }else {
      $this->session->set_flashdata("message",'<div class="alert alert-danger">Gagal Simpan Data</div>');
    }
    redirect($_SERVER['HTTP_REFERER']);
  }
  public function delete($id='')
  {
    // $dpost = $this->input->post(null,true);
    $this->main->setTable("divisi");
    $ins = $this->main->delete(["id_divisi"=>$id]);
    if ($ins) {
      $this->session->set_flashdata("message",'<div class="alert alert-success">Sukses Hapus Data</div>');
    }else {
      $this->session->set_flashdata("message",'<div class="alert alert-danger">Gagal Hapus Data</div>');
    }
    redirect($_SERVER['HTTP_REFERER']);
  }
  public function tambah()
  {
    $this->template->setFolder("admin");
    $this->template->defaultStyle("front");
    $build = [
      "block_title"=>"Tambah - Data Divisi",
      "info"=>[["nama_divisi"=>"","gaji_pokok"=>"","jam_masuk1"=>"","jam_masuk2"=>"","waktu_kerja"=>"","libur_minggu"=>""]],
      "gaji_pokok"=>"",
      "action"=>base_url("admin/divisi/create"),
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','divisi_form','foot'],['title'=>"Tambah - Data Divisi",'other'=>$build]);
  }
  public function ubah($id)
  {
    $this->template->setFolder("admin");
    $this->template->defaultStyle("front");
    $this->main->setTable("divisi");
    $now = $this->main->get(["id_divisi"=>$id]);
    if ($now->num_rows() < 0) {
      redirect($_SERVER["HTTP_REFERER"]);
    }else {
      $now = $now->row();
    }
    $build = [
      "block_title"=>"Ubah - Data Divisi",
      "info"=>[$now],
      "action"=>base_url("admin/divisi/update/".$id),
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','divisi_form','foot'],['title'=>"Ubah - Data Divisi",'other'=>$build]);
  }
  public function create()
  {
    $dpost = $this->input->post(null,true);
    $this->main->setTable("divisi");
    $ins = $this->main->insert($dpost);
    if ($ins) {
      $this->session->set_flashdata("message",'<div class="alert alert-success">Sukses Simpan Data</div>');
    }else {
      $this->session->set_flashdata("message",'<div class="alert alert-danger">Gagal Simpan Data</div>');
    }
    redirect($_SERVER['HTTP_REFERER']);
  }
}
