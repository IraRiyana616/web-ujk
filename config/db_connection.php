<?php
$server="localhost";
$akun="root";
$sandi="";
$database="sertifikasi";

$koneksi=new mysqli($server,$akun,$sandi,$database);
if(!$koneksi){
  die();
}
?>