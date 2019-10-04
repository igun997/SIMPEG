<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'math/vendor/autoload.php';
class CSI {
  public $listKPI = [];
  public $nint;
  public $dataskor = [];
  public $dataskortranspose = [];
  public $rangeskor = [];
  public $kuesioner_label;
  public $csibank = [];
  private function CheckKPIRules()
  {
    $data = $this->listKPI;
    $total = 0;
    foreach ($data as $key => $value) {
      $total = $total + $value->bobot;
    }
    return ($total == 100);
  }
  public function setKPI($data='')
  {
    // Array [(object)["label"=>"v","bobot"=>1,"target"=>2,"realisasi"=>1]]
    $this->listKPI = $data;
    return $this->CheckKPIRules();
  }
  public function KPICalc()
  {
    $data = $this->listKPI;
    foreach ($data as $key => &$value) {
      $value->kpimax = ($value->realisasi/$value->target)*100;
      $value->skorakhirkpi = ($value->realisasi/$value->target)*$value->bobot;
    }
    return $data;
  }
  public function setCSI($tkuesioner=0,$skor=4,$kuesioner_label=[],$dataskor=[])
  {
    if (count($dataskor) != $tkuesioner) {
      return false;
    }
    $this->kuesioner_label = $kuesioner_label;
    $rangeskor = range(1,$skor);
    $this->rangeskor = $rangeskor;
    $nint = 100/$skor;
    $this->nint = $nint;
    // [[1,2,3,4,5,6,7],[1,2,3,4,5,6,7]]
    $this->dataskor = $dataskor;
    $this->dataskortranspose = array_map(null, ...$dataskor);
    return $this->dataskortranspose;
  }
  public function buildSkor($rules = [],$labels = [])
  {
    //[[1,1.75],[1,75,2.50]]
    $sumSkor = [];
    $ratarata = [];
    $tkuesioner = count($this->dataskor);
    foreach ($this->dataskortranspose as $key => $value) {
      if (is_array($value)) {
        $sumSkor[] = array_sum($value);
        $ratarata[] = array_sum($value)/$tkuesioner;
      }else {
        $sumSkor[] = $value;
        $ratarata[] = $value/$tkuesioner;
      }
    }
    $tabel_akhir = [];
    $ci = 1/count($this->dataskortranspose);
    foreach ($this->kuesioner_label as $key => $value) {
      $tabel_akhir["list"][$key] = ["label"=>$value,"nilai_rerata"=>$ratarata[$key],"nrxci"=>$ratarata[$key]*$ci];
    }
    $tabel_akhir["list"] = (object) $tabel_akhir["list"];
    $a = 0;
    $b = 0;
    foreach ($tabel_akhir["list"] as $key => $value) {
      $a = $a + $value["nilai_rerata"];
      $b = $b + $value["nrxci"];
    }
    $tabel_akhir["sum_ratarata"] = $a;
    $tabel_akhir["sum_nrxci"] = $b;
    $tabel_akhir["nint"] = $this->nint;
    $csi = (double) substr(($b*$this->nint),0,5);
    $tabel_akhir["csi"] = $csi;
    foreach ($rules as $key => &$value) {
      $t =[];
      foreach ($value as $ky => $vlue) {
        $t[] = $vlue*$this->nint;
      }
      $value = $t;
    }
    $rank = ["E","D","C","B","A"];
    foreach ($rules as $key => &$value) {
      $value = ["label"=>$labels[$key],"rank"=>$rank[$key],"start"=>$value[0],"end"=>$value[1]];
    }
    
    $tabel_akhir["label"] = "Tidak Baik";
    foreach ($rules as $key => $vale) {
        if ( $csi >= $vale["start"] && $csi <= $vale["end"]) {
          $tabel_akhir["label"] = $vale["label"];
          break;
        }
    }
    if($csi >= 0 && $csi <= 19.99){
        $tabel_akhir["rank"] = "E";
    }elseif($csi >= 20 && $csi <= 49.99){
        $tabel_akhir["rank"] = "D";
    }elseif($csi >= 50 && $csi <= 69.99){
        $tabel_akhir["rank"] = "C";
    }elseif($csi >= 70 && $csi <= 84.99){
        $tabel_akhir["rank"] = "B";
    }elseif($csi >= 85 && $csi <= 100){
        $tabel_akhir["rank"] = "A";
    }
    
    $this->csibank = ["score_by_kuesioner"=>$this->dataskortranspose,"score_by_responden"=>$this->dataskor,"total_kuesioner"=>count($this->dataskortranspose),"total_responden"=>count($this->dataskor),"sum_by_skor_responden"=>$sumSkor,"ratarata_by_skor_responden"=>$ratarata,"rules"=>$rules,"tabel_akhir"=>$tabel_akhir];
    return $this->csibank;
  }
}
