
	
<?php
class indexModel extends CI_Model {
 
 function getBarang(){
  $this->db->select("id_barang,nama_barang,qty,hide"); 
  $this->db->from('barang');
  $this->db->like("hide",0);
  $query = $this->db->get();
  return $query->result();
 }
 function getJual(){
  $this->db->select("id_trans_penjualan,nama_barang,qty,harga_jual,harga_beli,tanggal_jual,id_barang_tanggal"); 
  $this->db->from('transaksi_penjualan');
  $this->db->like("hide",0);
  $this->db->order_by('tanggal_jual', 'DESC');
  $query = $this->db->get();
  return $query->result();
 }
 function getJualFilter($date){
  $this->db->select("id_trans_penjualan,nama_barang,qty,harga_jual,harga_beli,tanggal_jual"); 
  $this->db->from('transaksi_penjualan');
  $this->db->like("hide",0);
  $this->db->like("tanggal_jual",$date);
  $this->db->order_by('tanggal_jual', 'DESC');
  $query = $this->db->get();

  return $query->result();
 }
 function getBeli(){
  $this->db->select("id_trans_pembelian,nama_barang,qty,harga_beli,tanggal_beli"); 
  $this->db->from('transaksi_pembelian');
  $this->db->like("hide",0);
  $this->db->order_by('tanggal_beli', 'DESC');
  $query = $this->db->get();
  return $query->result();
 }
 function getBarangPerTanggal(){
  $this->db->select("id_barang_tanggal,nama_barang,qty,harga_beli,tanggal_beli,hide"); 
  $this->db->from('barang_tanggal');
  $this->db->like("hide",0);
  $this->db->order_by('tanggal_beli', 'DESC');
  $query = $this->db->get();
  return $query->result();
 }
 function getBarangPerTanggalAsc(){
  $this->db->select("id_barang_tanggal,nama_barang,qty,harga_beli,tanggal_beli"); 
  $this->db->from('barang_tanggal');
  $this->db->like("hide",0);
  $this->db->order_by('tanggal_beli', 'ASC');
  $query = $this->db->get();
  return $query->result();
 }
 function getBeliFilter($date){
  $this->db->select("id_trans_pembelian,nama_barang,qty,harga_beli,tanggal_beli"); 
  $this->db->from('transaksi_pembelian');
  $this->db->like("hide",0);
  $this->db->like("tanggal_beli",$date);
  $query = $this->db->get();

  return $query->result();
 }
 
 function updateStock($arrayModels){
	 $arrayModel = array(
							
							'qty'=>$arrayModels['qty'],
							);
	 
	 $this->db->where('id_barang_tanggal',$arrayModels['id_barang_tanggal']);
	 
  $query = $this->db->update('barang_tanggal',$arrayModel);
  
 }
 
 function updatePenjualan($arrayModels){
   if($arrayModels['qty'] != 0){
    $query = $this->db->insert('transaksi_penjualan',$arrayModels);
   }

 }
 function editPenjualan($arrayModels){
	
	$postArray2 = array(
							'nama_barang'=>$arrayModels['nama_barang'],
							'qty'=>$arrayModels['qty'],
							'harga_beli'=>$arrayModels['harga_beli'],
							'harga_jual'=>$arrayModels['harga_jual'],
							'tanggal_jual'=>$arrayModels['tanggal_jual'],
							'hide'=>0
							);
	 $this->db->where('id_trans_penjualan',$arrayModels['id_trans_penjualan']);
  $query = $this->db->update('transaksi_penjualan',$postArray2);
 }
 function editBarangPerTanggal($arrayModels){
	
	$postArray2 = array(
							'nama_barang'=>$arrayModels['nama_barang'],
							'qty'=>$arrayModels['qty'],
							'harga_beli'=>$arrayModels['harga_beli'],
							'tanggal_beli'=>$arrayModels['tanggal_beli'],
							'hide'=>0
							);
	 $this->db->where('id_barang_tanggal',$arrayModels['id_barang_tanggal']);
  $query = $this->db->update('barang_tanggal',$postArray2);
 }
 function editBarang($arrayModels){
	
	$postArray2 = array(
							'nama_barang'=>$arrayModels['nama_barang'],
							'qty'=>$arrayModels['qty'],
							'hide'=>0
							);
	 $this->db->where('id_barang',$arrayModels['id_barang']);
  $query = $this->db->update('barang',$postArray2);
 }
 function updateBarang($arrayModels){
  $arrayModel = array(
							
							'qty'=>$arrayModels['qty'],
							);
	 $this->db->where('nama_barang',$arrayModels['nama_barang']);
  $query = $this->db->update('barang',$arrayModel);
 }
 function deletePenjualan($arrayModels){
  $arrayModel = array(
							
							'hide'=>1,
							);
	 $this->db->where('id_trans_penjualan',$arrayModels['id_trans_penjualan']);
  $query = $this->db->update('transaksi_penjualan',$arrayModel);
 }
 function deleteBarang($arrayModels){
  $arrayModel = array(
							
							'hide'=>1,
							);
	 $this->db->where('id_barang_tanggal',$arrayModels['id_barang_tanggal']);
  $query = $this->db->update('barang_tanggal',$arrayModel);
 }
 function updateQtyBarangTanggal($arrayModels){
  $arrayModel = array(
							
							'qty'=>$arrayModels['qty']
							);
	 $this->db->where('id_barang_tanggal',$arrayModels['id_barang_tanggal']);
  $query = $this->db->update('barang_tanggal',$arrayModel);
 }
 function deleteBarang2($arrayModels){
  $arrayModel = array(
							
							'hide'=>1,
							);
	 $this->db->where('id_barang',$arrayModels['id_barang']);
  $query = $this->db->update('barang',$arrayModel);
 }
 function updateBarangTanggal($arrayModels){
  $query = $this->db->insert('barang_tanggal',$arrayModels);
 }
 function updatePembelian($arrayModels){
  $query = $this->db->insert('transaksi_pembelian',$arrayModels);
 }
 function insertBarang($arrayModels){
  $query = $this->db->insert('barang',$arrayModels);
 }
 function deletePembelian($arrayModels){
  $arrayModel = array(
							
							'hide'=>1,
							);
	 $this->db->where('id_trans_pembelian',$arrayModels['id_trans_pembelian']);
  $query = $this->db->update('transaksi_pembelian',$arrayModel);
 }
  function editPembelian($arrayModels){
	
	$postArray2 = array(
							'nama_barang'=>$arrayModels['nama_barang'],
							'qty'=>$arrayModels['qty'],
							'harga_beli'=>$arrayModels['harga_beli'],
							'tanggal_beli'=>$arrayModels['tanggal_beli'],
							'hide'=>0
							);
	 $this->db->where('id_trans_pembelian',$arrayModels['id_trans_pembelian']);
  $query = $this->db->update('transaksi_pembelian',$postArray2);
 }
 
}
?>