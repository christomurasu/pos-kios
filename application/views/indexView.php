<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>POS-Kios</title>
	<style type="text/css">

	#container {
		margin: 1%;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
		text-align: center;
		font-family:Calibri;
		width:30%;
		vertical-align:middle;
		float:left;
	}
	
	.nav {
		width:98%;
		margin-left:1%;
		background-color:#e0e0e0;
		height:100px;
	}
	.nav-center{
		 margin: auto;
		width: 50%;
		text-align: center;
		font-family:Calibri;
		vertical-align:middle;
		position: relative;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
  font-size:24px;
	}
	
	</style>
</head>
<body>
 <div class="nav">
	 <div class="nav-center">
	 POS KIOS
	 </div>
 </div>
 <div style="float:left; width:100%;">
   <div id="container">
	
	 BARANG
	 <form id="start" action="/pos-kios/index.php/indexController/goToBarang" method="POST" >
   <input type="submit" name="goToBarang" value="Manage Barang" />
</form>
  </div>
   <div id="container">
	
	 Transaksi Jual
	 
	 <form id="start" action="/pos-kios/index.php/indexController/goToJual" method="POST" >
   <input type="submit" name="goToBarang" value="Manage Penjualan" />
</form>
  </div> 
  <div id="container">
	 Transaksi Beli
	 <form id="start" action="/pos-kios/index.php/indexController/goToBeli" method="POST" >
   <input type="submit" name="goToBarang" value="Manage Pembelian" />
</form>
  </div>
   </div>
   
   
   
</body>
</html>