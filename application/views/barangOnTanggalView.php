<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>POS-Kios</title>
	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
	}

	li {
	  float: left;
	}

	li a {
	  display: block;
	  color: white;
	  text-align: center;
	  padding: 14px 16px;
	  text-decoration: none;
	}

	/* Change the link color to #111 (black) on hover */
	li a:hover {
	  background-color: #111;
	}
	table, td, th {  
	  border: 1px solid #ddd;
	  text-align: left;
	}

	table {
	  border-collapse: collapse;
	  width: 100%;
	}

	th, td {
	  padding: 15px;
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
	#container {
		margin-left:2.5%;
		alignment:center;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
		text-align: center;
		font-family:Calibri;
		width:20%;
		vertical-align:middle;
		float:left;
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
	
	 BARANG PER TANGGAL
	 <form id="start" action="/pos-kios/index.php/indexController/goToBarangPerTanggal" method="POST" >
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
   
  
   <div style="float:left; width:100%;">
<h1>List Barang</h1>
    <table>
     <tr>
	 <td><strong>ID</strong></td>
      <td><strong>Nama Barang</strong></td>
      <td><strong>Jumlah</strong></td>
	  <td><strong>Harga Beli</strong></td>
	  <td><strong>Tanggal Beli</strong></td>
    </tr> 
     <?php $no = 1;foreach($posts as $post){?>
     <tr>
	 <td><?php echo $post->id_barang_tanggal;?></td>
         <td><?php echo $post->nama_barang;?></td>
         <td><?php echo $post->qty;?></td>
         <td><?php echo $post->harga_beli;?></td>
         <td><?php echo $post->tanggal_beli;?></td>
      </tr>     
     <?php }?>  
   </table>
   
   </div>
</body>
</html>