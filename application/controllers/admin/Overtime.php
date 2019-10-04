<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author Indra Gunanda
 */
class Overtime extends CI_Controller{
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
    $this->main->setTable("overtime");
    $data = $this->main->get();

    $build = [
      "block_title"=>"Data Tunjangan",
      "data_overtime"=>$data->result_array(),
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','overtime','foot'],['title'=>"Data Tunjangan",'other'=>$build]);
  }
  public function update($id='')
  {
    $dpost = $this->input->post(null,true);
    $this->main->setTable("overtime");
    $ins = $this->main->update($dpost,["id_overtime"=>$id]);
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
    $this->main->setTable("overtime");
    $ins = $this->main->delete(["id_overtime"=>$id]);
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
      "block_title"=>"Tambah - Data Tunjangan",
      "info"=>[["kode_overtime"=>"","total"=>"","nama_tunjangan"=>"","jenis_tunjangan"=>""]],
      "gaji_pokok"=>"",
      "action"=>base_url("admin/overtime/create"),
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','overtime_form','foot'],['title'=>"Tambah - Data Tunjangan",'other'=>$build]);
  }
  public function ubah($id)
  {
    $this->template->setFolder("admin");
    $this->template->defaultStyle("front");
    $this->main->setTable("overtime");
    $now = $this->main->get(["id_overtime"=>$id]);
    if ($now->num_rows() < 0) {
      redirect($_SERVER["HTTP_REFERER"]);
    }else {
      $now = $now->row();
    }
    $build = [
      "block_title"=>"Ubah - Data Tunjangan",
      "info"=>[$now],
      "action"=>base_url("admin/overtime/update/".$id),
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','overtime_form','foot'],['title'=>"Ubah - Data Tunjangan",'other'=>$build]);
  }
  public function create()
  {
    $dpost = $this->input->post(null,true);
    $this->main->setTable("overtime");
    $ins = $this->main->insert($dpost);
    if ($ins) {
      $this->session->set_flashdata("message",'<div class="alert alert-success">Sukses Simpan Data</div>');
    }else {
      $this->session->set_flashdata("message",'<div class="alert alert-danger">Gagal Simpan Data</div>');
    }
    redirect($_SERVER['HTTP_REFERER']);
  }
}
