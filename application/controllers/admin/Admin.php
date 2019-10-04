<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author Indra Gunanda
 */
class Admin extends CI_Controller{
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
     $this->main->setTable("users");
     $data = $this->main->get(["level"=>"admin","status"=>"aktif"]);
     $build = [
       "block_title"=>"Data Administrator",
       "data_admin"=>$data->result_array(),
       "msg"=>$this->session->flashdata("message")
     ];
     $this->template->renderHTML(['head','admin','foot'],['title'=>"Data Administrator",'other'=>$build]);
   }
  public function tambah()
  {
    $this->template->setFolder("admin");
    $this->template->defaultStyle("front");
    $this->main->setTable("users");
    $build = [
      "block_title"=>"Tambah - Data Administrator",
      "info"=>[["nip"=>"","nama"=>"","tgl_lhr"=>"","nomor_hp"=>"","alamat"=>"","jk"=>"laki-laki","unjk"=>"perempuan","email"=>""]],
      "action"=>base_url("admin/admin/create"),
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','admin_form','foot'],['title'=>"Tambah - Data Administrator",'other'=>$build]);
  }
  public function ubah($id)
  {
    $this->template->setFolder("admin");
    $this->template->defaultStyle("front");
    $this->main->setTable("users");
    $info = $this->main->get(["nip"=>$id,"level"=>"admin","status"=>"aktif"])->row();
    if ($info->jk == "laki-laki") {
      $info->unjk = "perempuan";
    }else {
      $info->unjk = "laki-laki";
    }
    $build = [
      "block_title"=>"Ubah - Data Administrator",
      "info"=>[$info],
      "action"=>base_url("admin/admin/update/".$id),
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','admin_form','foot'],['title'=>"Ubah - Data Administrator",'other'=>$build]);
  }
  public function update($id)
  {
    $dpost = $this->input->post(null,true);
    $dpost["foto"] = null;
    if ($dpost["password"] == "") {
      unset($dpost["password"]);
    }
    unset($dpost["nip"]);
    $x = $this->gambar->upload("foto");
    if ($x != false) {
      $dpost["foto"] = $x["file_name"];
    }else {
      unset($dpost["foto"]);
    }
    $this->main->setTable("users");
    $ins = $this->main->update($dpost,["nip"=>$id]);
    if ($ins) {
      $this->session->set_flashdata("message",'<div class="alert alert-success">Sukses Simpan Data </div>');
    }else {
      $this->session->set_flashdata("message",'<div class="alert alert-danger">Gagal Simpan Data </div>');
    }
    redirect($_SERVER['HTTP_REFERER']);
  }
  public function delete($id)
  {
    $this->main->setTable("users");
    $s = $this->main->update(["status"=>"tidak"],["nip"=>$id]);
    redirect($_SERVER["HTTP_REFERER"]);
  }
  public function create()
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
      $dpost["foto"] = null;
    }
    $dpost["level"] = "admin";
    $dpost["status"] = "aktif";
    $this->main->setTable("users");
    $ins = $this->main->insert($dpost);
    if ($ins) {
      $this->session->set_flashdata("message",'<div class="alert alert-success">Sukses Simpan Data </div>');
    }else {
      $this->session->set_flashdata("message",'<div class="alert alert-danger">Gagal Simpan Data </div>');
    }
    redirect($_SERVER['HTTP_REFERER']);
  }
}
