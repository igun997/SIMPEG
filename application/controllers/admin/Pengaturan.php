<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author Indra Gunanda
 */
class Pengaturan extends CI_Controller{
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
    $this->main->setTable("setting");
    $jam_masuk = $this->main->get(["meta_key"=>"jam_masuk"])->row();
    $jam_keluar = $this->main->get(["meta_key"=>"jam_keluar"])->row();
    $tgl_penggajian = $this->main->get(["meta_key"=>"tgl_penggajian"])->row();
    $overtime = $this->main->get(["meta_key"=>"overtime"])->row();
    $build = [
      "block_title"=>"Pengaturan Aplikasi",
      "masuk"=>$jam_masuk->meta_value,
      "keluar"=>$jam_keluar->meta_value,
      "tgl_penggajian"=>$tgl_penggajian->meta_value,
      "overtime"=>$overtime->meta_value,
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','pengaturan','foot'],['title'=>"Pengaturan Aplikasi",'other'=>$build]);
  }
  public function update()
  {
    $dpost = $this->input->post(null,true);
    $this->main->setTable("setting");
    $ins = $this->main->update(["meta_value"=>$dpost["tgl_penggajian"]],["meta_key"=>"tgl_penggajian"]);
    $ins = $this->main->update(["meta_value"=>$dpost["overtime"]],["meta_key"=>"overtime"]);
    if (true) {
      $this->session->set_flashdata("message",'<div class="alert alert-success">Sukses Simpan Data</div>');
    }else {
      $this->session->set_flashdata("message",'<div class="alert alert-danger">Gagal Simpan Data</div>');
    }
    redirect($_SERVER['HTTP_REFERER']);
  }

}
