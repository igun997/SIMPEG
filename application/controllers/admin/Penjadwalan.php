<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjadwalan extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model("crud/main");
    if ($this->session->level != "admin") {
      redirect(base_url("public"));
    }
  }

  function index()
  {
    $this->template->setFolder("admin");
    $this->template->defaultStyle("front");
    $this->main->setTable("divisi");
    $data = $this->main->get();
    $this->main->setTable("setting");
    $r = $this->main->get(["meta_key"=>"tgl_penggajian"])->row()->meta_value;
    $date = $this->main->loopDate(date("Y-m-01"),date("Y-m-".$r));
    $d = [];
    foreach ($date as $key => $value) {
      $d[] = ["d"=>date("d/m",strtotime($value))];
    }
    $build = [
      "block_title"=>"Penggajian Pegawai",
      "data_divisi"=>$data->result_array(),
      "date"=>$d,
      "msg"=>$this->session->flashdata("message")
    ];
    $this->template->renderHTML(['head','penjadwalan','foot'],['title'=>"Penjadwalan Pegawai",'other'=>$build]);
  }

}
