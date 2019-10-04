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
  }
  /**
 	 * Index Home
 	 *
 	 * @return void
	 */

  function index()
  {
    $this->template->setFolder("public");
    $this->template->defaultStyle("login");
    $build = [
      "action"=>base_url("public/home/action"),
      "msg"=>$this->session->flashdata('message')
    ];
    $this->template->renderHTML(['head','home','foot'],['title'=>"Login Page",'other'=>$build]);
  }
  public function logout()
  {
    $this->session->sess_destroy();
    $this->session->set_flashdata('message', '<div class="alert alert-success">Anda Berhasil Keluar Sistem</div>');
    redirect('public');
  }
  public function action()
  {
    $post = $this->input->post(null,true);
    $this->main->setTable("users");
    $ins = $this->main->get($post);
    if ($ins->num_rows() > 0) {
      $row = $ins->row();
      $this->session->set_userdata(((array) $row));
      $this->session->set_flashdata('message', '<div class="alert alert-success">Username & Password Benar</div><script>setTimeout(function () {
        location.href="'.base_url($row->level).'"
      }, 2000);</script>');
    }else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Username & Password Salah </div>');
    }
    redirect($_SERVER['HTTP_REFERER']);
  }
}
