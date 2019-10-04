<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_excel extends CI_Model{
  public $tabel;
  public $removeCell;
  public $uploaddata;
  public function __construct()
  {
    parent::__construct();
  }
  public function setTable($table=""){
      $this->tabel = $table;
  }
  public function removeCell($arr=[]){
      $this->removeCell = $arr;
  }
  public function upload($name=""){
      $this->load->model("proses/upload_wrapper");
      $up = $this->upload_wrapper->upload($name);
      if(is_array($up)){
          $this->uploaddata = $up;
          return $up;
      }else{
          return $up;
      }
  }
  public function import($sheet = 0,$coltable = 0){
      $this->load->library("excel_reader");
      $this->excel_reader->setOutputEncoding('230787');
      $file = realpath(APPPATH . '../temp/'.$this->uploaddata["file_name"]);
      $this->excel_reader->read($file);
      $data = $this->excel_reader->sheets[$sheet];
      $cells = $data["cells"];
        $b = [];
        foreach($cells as $k => &$v){
        	$b[] = $v;
        	
        }
        foreach($b as $k => &$v){
        	$t = [];
        	foreach($v as $o => $s){
        	    $t[] = $s;
        	}
        	$v = $t;
        }
        $cells = $b;
        $table = $cells[$coltable];
        unset($cells[$coltable]);
        $rt = [];
        foreach($cells as $k => $o){
            $ts = [];
            foreach($o as $kl => $lk){
                $ts[] = [$table[$kl]=>$lk];
            }
            $rt[] = $ts;
        }
        foreach($rt as $t => &$os){
            $new = $os;
            $os = [];
            foreach($new as  $ts => $ks){
                foreach($ks as $kl => $ll){
                    $os[$kl] = $ll;
                }
            }
        }
      @unlink($file);
      return $this->db->insert_batch($this->tabel,$rt);
  }
}