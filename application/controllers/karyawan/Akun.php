<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author Indra Gunanda
 */
class Akun extends CI_Controller{
  /**
 	 * Konstruktor
 	 *
 	 * @return void
	 */

  public function __construct()
  {
    parent::__construct();
    $this->load->model("crud/main");
    $this->load->model("proses/upload_wrapper","gambar");
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
    $this->main->setTable("users");
    $info = $this->main->get(["nip"=>$this->session->nip])->row();
    $build = [
      "block_title"=>"Pengaturan Akun",
      "info"=>[$info],
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','akun','foot'],['title'=>"Pengaturan Akun",'other'=>$build]);
  }
  public function action()
  {
    $dpost = $this->input->post(null,true);
    $dpost["foto"] = null;
    if ($dpost["password"] == "") {
      unset($dpost["password"]);
    }
    $x = $this->gambar->upload("foto");
    if ($x != false) {
      $dpost["foto"] = $x["file_name"];
    }else {
      unset($dpost["foto"]);
    }
    $this->main->setTable("users");
    $ins = $this->main->update($dpost,["nip"=>$this->session->nip]);
    if ($ins) {
      $this->session->set_userdata($dpost);
      $this->session->set_flashdata("message",'<div class="alert alert-success">Sukses Simpan Data </div>');
    }else {
      $this->session->set_flashdata("message",'<div class="alert alert-danger">Gagal Simpan Data </div>');
    }
    redirect($_SERVER['HTTP_REFERER']);
  }
}
