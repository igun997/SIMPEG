<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author Indra Gunanda
 */
class Home extends CI_Controller{
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
    $this->main->setTable("setting");
    $tgl = $this->main->get(["meta_key"=>"tgl_penggajian"])->row()->meta_value;
    if (($tgl - date("d")) <= 7) {
      $sisa = ($tgl - date("d"));
      if ($sisa > 0) {
        $this->session->set_flashdata("msg","{$sisa} Hari Sebelum Hari Penggajian");
      }
    }
    $this->template->setFolder("admin");
    $this->template->defaultStyle("front");
    $build = [
      "block_title"=>"Dashboard Administrator"
    ];
    $this->template->renderHTML(['head','home','foot'],['title'=>"Dashboard Administrator",'other'=>$build]);
  }
}
