<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class indexController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('indexView');
		$this->load->library('pagination');
		$this->load->library('table');
	}
	public function goToBarang()
    {
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		$this->refreshBarang();
		$this->data['posts'] = $this->indexModel->getBarang();
 
            $this->load->view('barangView',$this->data);
        
    
	}
	public function goToBarangPerTanggal()
    {
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		$this->data['posts'] = $this->indexModel->getBarangPerTanggal();
 
            $this->load->view('barangOnTanggalView',$this->data);
	}
	public function tambahPenjualan()
    {
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		$this->data['posts'] = $this->indexModel->getBarang();
            $this->load->view('tambahPenjualanView',$this->data);
	}
	public function tambahPembelian()
    {
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		$this->data['posts'] = $this->indexModel->getBarang();
            $this->load->view('tambahPembelianView',$this->data);
	}
	public function goToJual()
    {
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		$this->data['posts'] = $this->indexModel->getJual();
            $this->load->view('jualView',$this->data);
	}
	public function getDateFilter(){
		 if($this->input->post('submit') != NULL){
			 if($this->input->post('date') != NULL){
				 $date=date_format(  new DateTime ($this->input->post('date')),"m/d/Y");
			 $this->load->database(); // load database
			$this->load->model('indexModel'); // load model 
			$this->data['posts'] = $this->indexModel->getJualFilter($date);
            $this->load->view('jualView',$this->data);
			}else{
				$this->goToJual();
			}
		 }
    
	}
	public function printFilter(){
		if($this->input->post('submit') != NULL){
			if($this->input->post('date') != NULL){
			$date=date_format(  new DateTime ($this->input->post('date')),"m/d/Y");
			$this->load->database(); // load database
			$this->load->model('indexModel'); // load model 
			$this->data['posts'] = $this->indexModel->getJualFilter($date);
			$this->load->view('printView',$this->data);
		   }else{
			$this->load->database(); // load database
			$this->load->model('indexModel'); // load model 
			$this->data['posts'] = $this->indexModel->getJual();
			$this->load->view('printView',$this->data);
		   }
		}
   
   }
	public function goToBeli()
    {
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		$this->data['posts'] = $this->indexModel->getBeli();
        $this->load->view('beliView',$this->data);
	}
	public function getDateBeliFilter(){
		 if($this->input->post('submit') != NULL){
			 if($this->input->post('date') != NULL){
				 $date=date_format(  new DateTime ($this->input->post('date')),"m/d/Y");
			 $this->load->database(); // load database
			$this->load->model('indexModel'); // load model 
			$this->data['posts'] = $this->indexModel->getBeliFilter($date);
            $this->load->view('beliView',$this->data);
			}else{
				$this->goToBeli();
			}
		 }
    
	}
	public function prosesTambahPenjualan(){
		 if($this->input->post('submit') != NULL){
			 if($this->input->post('dropdown') != NULL){
				$nama_barang=$this->input->post('dropdown');
				$jumlah_barang=$this->input->post('jumlahBarang');
				$harga_jual=$this->input->post('hargaJual');
				$tanggal_jual=date_format(  new DateTime ($this->input->post('tanggalJual')),"m/d/Y");
				$this->load->database(); // load database
				$this->load->model('indexModel'); // load model 
				$arrBarang = $this->indexModel->getBarang();
				$temp = false;
				foreach ($arrBarang as $post){
					if($post->nama_barang == $nama_barang){
						if($post->qty > 0){
							$temp=true;
						}
					}
				}
				if($temp==true){
					$this->load->database(); // load database
					$this->load->model('indexModel'); // load model 
					$arrBarangTanggal = $this->indexModel->getBarangPerTanggalAsc();
					$arrTemp = array();
					foreach ($arrBarangTanggal as $post){
						if($post->nama_barang == $nama_barang){
						array_push($arrTemp,$post);
						}
					}
					
					$arrBarang = array();
					$jumlahTotal = 0;
					foreach($arrTemp as $post){
						if($jumlah_barang != 0){
						$postArray=array();	
						if($jumlah_barang<$post->qty){
							$postArray = array(
							'nama_barang'=>$post->nama_barang,
							'qty'=>$post->qty-$jumlah_barang,
							'harga_beli'=>$post->harga_beli,
							'tanggal_beli'=>$post->tanggal_beli,
							'hide'=>0,
							'id_barang_tanggal'=>$post->id_barang_tanggal
							);
							$postArray2 = array(
							'nama_barang'=>$post->nama_barang,
							'qty'=>$jumlah_barang,
							'harga_beli'=>$post->harga_beli,
							'harga_jual'=>$harga_jual,
							'tanggal_jual'=>$tanggal_jual,
							'hide'=>0,
							'id_barang_tanggal'=>$post->id_barang_tanggal
							);
							$this->indexModel->updateStock($postArray);
							$this->indexModel->updatePenjualan($postArray2);
							$jumlah_barang=0;
						}else{
							$jumlah_barang=$jumlah_barang-$post->qty;
							$postArray = array(
							'nama_barang'=>$post->nama_barang,
							'qty'=>0,
							'harga_beli'=>$post->harga_beli,
							'tanggal_beli'=>$post->tanggal_beli,
							'id_barang_tanggal'=>$post->id_barang_tanggal,
							'hide'=>0
							);
							$postArray2 = array(
							'nama_barang'=>$post->nama_barang,
							'qty'=>$post->qty,
							'harga_beli'=>$post->harga_beli,
							'harga_jual'=>$harga_jual,
							'tanggal_jual'=>$tanggal_jual,
							'hide'=>0,
							'id_barang_tanggal'=>$post->id_barang_tanggal
							);
							$this->indexModel->updateStock($postArray);
							$this->indexModel->updatePenjualan($postArray2);
						}
						array_push($arrBarang,$postArray);
						}
					}
					$this->goToJual();
			}else{
				$this->goToJual();
			}
		 }
    
		}
	}
	public function prosesTambahPembelian()
    {
		 if($this->input->post('submit') != NULL){
			 $nama_barang=$this->input->post('dropdown');
			 $nama_barang_baru=$this->input->post('namaBarangBaru');
				$jumlah_barang=$this->input->post('jumlahBarang');
				$harga_beli=$this->input->post('hargaBeli');
				$tanggal_beli=date_format(  new DateTime ($this->input->post('tanggalBeli')),"m/d/Y");
				
				$this->load->database(); // load database
				$this->load->model('indexModel'); // load model 
				$arrBarang2 = $this->indexModel->getBarang();
				if($nama_barang == 'inputManual'){
					$nama_barang=$nama_barang_baru;
					$kembar=false;
					foreach($arrBarang2 as $post){
						if($post->nama_barang == $nama_barang_baru){
							$kembar=true;
							$nama_barang=$nama_barang_baru;
						}
					}
					if($kembar==false){
						$nama_barang=$nama_barang_baru;
						$postArray2 = array(
								'nama_barang'=>$nama_barang,
								'qty'=>$jumlah_barang,
								'hide'=>0
								);
						$this->indexModel->insertBarang($postArray2);
					}else{
						$this->load->database(); // load database
					$this->load->model('indexModel'); // load model 
					$arrBarang = $this->indexModel->getBarang();
					foreach ($arrBarang as $post){
						if($nama_barang==$post->nama_barang){
							$postArray2 = array(
							'nama_barang'=>$nama_barang,
							'qty'=>$jumlah_barang+$post->qty,
							'hide'=>0
							);
							$this->indexModel->updateBarang($postArray2);
						}
					}
					}
					
				}else{
					$this->load->database(); // load database
					$this->load->model('indexModel'); // load model 
					$arrBarang = $this->indexModel->getBarang();
					foreach ($arrBarang as $post){
						if($nama_barang==$post->nama_barang){
							$postArray2 = array(
							'nama_barang'=>$nama_barang,
							'qty'=>$jumlah_barang+$post->qty,
							'hide'=>0
							);
							$this->indexModel->updateBarang($postArray2);
						}
					}
					
				}
				$postArray = array(
							'nama_barang'=>$nama_barang,
							'qty'=>$jumlah_barang,
							'harga_beli'=>$harga_beli,
							'tanggal_beli'=>$tanggal_beli,
							'hide'=>0
							);
				
				$this->indexModel->updateBarangTanggal($postArray);		
				$this->indexModel->updatePembelian($postArray);	
				$this->goToBeli();
		 }
	}
	public function deletePenjualan(){
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		$arrPenjualan = $this->indexModel->getJual();
		 $id_trans=$this->input->post('delete');
		 
		foreach ($arrPenjualan as $post){
						if($this->input->post($post->id_trans_penjualan) != null){
							$postArray2 = array(
							'id_trans_penjualan'=>$post->id_trans_penjualan,
							'nama_barang'=>$post->nama_barang,
							'qty'=>$post->qty,
							'harga_beli'=>$post->harga_beli,
							'harga_jual'=>$post->harga_jual,
							'tanggal_jual'=>$post->tanggal_jual,
							'hide'=>1
							);
							$this->indexModel->deletePenjualan($postArray2);
							$arrBarangTanggal = $this->indexModel->getBarangPerTanggal();
							foreach ($arrBarangTanggal as $posts){
								
								if($posts->id_barang_tanggal == $post->id_barang_tanggal){
								$postArray = array(
											'nama_barang'=>$posts->nama_barang,
											'qty'=>$posts->qty+$post->qty,
											'harga_beli'=>$posts->harga_beli,
											'tanggal_beli'=>$posts->tanggal_beli,
											'hide'=>0,
											'id_barang_tanggal'=>$posts->id_barang_tanggal
											);
								
								$this->indexModel->updateQtyBarangTanggal($postArray);	
								}
							}
							$arrBarang = $this->indexModel->getBarang();
							foreach ($arrBarang as $post2){
								if($post2->nama_barang == $post->nama_barang){
									$postArray2 = array(
										'id_barang'=>$post2->id_barang,
										'nama_barang'=>$post2->nama_barang,
										'qty'=>$post2->qty+$post->qty,
										'hide'=>1
										);
									$this->indexModel->updateBarang($postArray2);
								}
								
							}
							
						}
					}
					$this->data['posts'] = $this->indexModel->getJual();
            $this->load->view('jualView',$this->data);
	}
	public function editPenjualan(){
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		
		$this->data['posts'] = $this->indexModel->getBarang();
		$arrPenjualan = $this->indexModel->getJual();
		 $id_trans=$this->input->post('delete');
		foreach ($arrPenjualan as $post){
						if($this->input->post($post->id_trans_penjualan) != null){
							
							$this->data['post2']=$post;
						}
					}
					
            $this->load->view('editPenjualanView',$this->data);
	}
	public function prosesEditPenjualan(){
		$nama_barang=$this->input->post('dropdown');
				$jumlah_barang=$this->input->post('jumlahBarang');
				$harga_jual=$this->input->post('hargaJual');
				$harga_beli=$this->input->post('hargaBeli');
				$id_barang=$this->input->post('idBarang');
		$tanggal_jual=date_format(  new DateTime ($this->input->post('tanggalJual')),"m/d/Y");
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		$arrBarangTanggal = $this->indexModel->getBarangPerTanggal();
		$arrBarang = $this->indexModel->getBarang();
		$arrPenjualan = $this->indexModel->getJual();
		$jumlah_penjualan = 0;
		
		foreach ($arrPenjualan as $post){
			if($this->input->post($post->id_trans_penjualan) != null){
				$jumlah_penjualan=$post->qty;
			}
		}
		foreach ($arrBarangTanggal as $post){
			if($post->id_barang_tanggal==$id_barang){
				$postArray2 = array(
							'id_barang_tanggal'=>$post->id_barang_tanggal,
							'nama_barang'=>$post->nama_barang,
							'qty'=>$post->qty+$jumlah_penjualan-$jumlah_barang,
							'harga_beli'=>$post->harga_beli,
							'tanggal_beli'=>$post->tanggal_beli,
							'hide'=>0
							);
				$this->indexModel->editBarangPerTanggal($postArray2);
			}
		}
		foreach ($arrBarang as $post){
			if($post->nama_barang==$nama_barang){
				$postArray2 = array(
							'id_barang'=>$post->id_barang,
							'nama_barang'=>$post->nama_barang,
							'qty'=>$post->qty+$jumlah_penjualan-$jumlah_barang,
							'hide'=>0
							);
				$this->indexModel->editBarang($postArray2);
			}
		}
		 $id_trans=$this->input->post('delete');
		foreach ($arrPenjualan as $post){
						if($this->input->post($post->id_trans_penjualan) != null){
							$postArray2 = array(
							'id_trans_penjualan'=>$post->id_trans_penjualan,
							'nama_barang'=>$nama_barang,
							'qty'=>$jumlah_barang,
							'harga_beli'=>$harga_beli,
							'harga_jual'=>$harga_jual,
							'tanggal_jual'=>$tanggal_jual,
							'id_barang_tanggal'=>$post->id_barang_tanggal,
							'hide'=>0
							);
							$this->indexModel->editPenjualan($postArray2);
						}
					}
					
            $this->data['posts'] = $this->indexModel->getJual();
            $this->load->view('jualView',$this->data);
	}
	public function deleteBarangTanggal(){
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		$arrBarang = $this->indexModel->getBarangPerTanggal();
		 $id_trans=$this->input->post('delete');
		 
		foreach ($arrBarang as $post){
			
						if($this->input->post($post->id_barang_tanggal) != null){
							$postArray2 = array(
							'id_barang_tanggal'=>$post->id_barang_tanggal,
							'nama_barang'=>$post->nama_barang,
							'qty'=>$post->qty,
							'hide'=>1
							);
							$this->indexModel->deleteBarang($postArray2);
						}
					}
					$this->data['posts'] = $this->indexModel->getBarangPerTanggal();
            $this->load->view('barangOnTanggalView',$this->data);
	}
	public function updatePenjualan(){
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		
		$this->data['posts'] = $this->indexModel->getBarang();
		$arrPenjualan = $this->indexModel->getJual();
		 $id_trans=$this->input->post('delete');
		foreach ($arrPenjualan as $post){
						if($this->input->post($post->id_trans_penjualan) != null){
							
							$this->data['post2']=$post;
						}
					}
					
            $this->load->view('editPenjualanView',$this->data);
	}
	public function editBarangTanggal(){
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		
		$this->data['posts'] = $this->indexModel->getBarangPerTanggal();
		$arrBarangTanggal = $this->indexModel->getBarangPerTanggal();
		 $id_trans=$this->input->post('delete');
		foreach ($arrBarangTanggal as $post){
						if($this->input->post($post->id_barang_tanggal) != null){
							
							$this->data['post2']=$post;
						}
					}
					
            $this->load->view('editBarangOnTanggalView',$this->data);
	}
	public function prosesEditBarangPerTanggal(){
		$nama_barang=$this->input->post('dropdown');
				$jumlah_barang=$this->input->post('jumlahBarang');
				$harga_beli=$this->input->post('hargaBeli');
				$tanggal_beli=date_format(  new DateTime ($this->input->post('tanggalBeli')),"m/d/Y");
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		$this->data['posts'] = $this->indexModel->getBarangPerTanggal();
		$arrPenjualan = $this->indexModel->getBarangPerTanggal();
		 $id_trans=$this->input->post('delete');
		foreach ($arrPenjualan as $post){
			
						if($this->input->post($post->id_barang_tanggal) != null){
							
							$postArray2 = array(
							'id_barang_tanggal'=>$post->id_barang_tanggal,
							'nama_barang'=>$nama_barang,
							'qty'=>$jumlah_barang,
							'harga_beli'=>$harga_beli,
							'tanggal_beli'=>$tanggal_beli,
							'hide'=>0
							);
							$this->indexModel->editBarangPerTanggal($postArray2);
						}
					}
					
            $this->data['posts'] = $this->indexModel->getBarangPerTanggal();
            $this->load->view('barangOnTanggalView',$this->data);
	}
	function deleteBarang(){
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		$arrBarang = $this->indexModel->getBarang();
		 
		 
		foreach ($arrBarang as $post){
			
						if($this->input->post($post->id_barang) != null){
							$postArray2 = array(
							'id_barang'=>$post->id_barang,
							'nama_barang'=>$post->nama_barang,
							'qty'=>$post->qty,
							'hide'=>1
							);
							$this->indexModel->deleteBarang2($postArray2);
						}
					}
					$this->data['posts'] = $this->indexModel->getBarang();
            $this->load->view('barangView',$this->data);
	}
	function editBarang(){
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		
		$this->data['posts'] = $this->indexModel->getBarang();
		$arrBarangTanggal = $this->indexModel->getBarang();
		 $id_trans=$this->input->post('delete');
		foreach ($arrBarangTanggal as $post){
						if($this->input->post($post->id_barang) != null){
							
							$this->data['post2']=$post;
						}
					}
					
            $this->load->view('editBarangView',$this->data);
	}
	public function prosesEditBarang(){
		$nama_barang=$this->input->post('dropdown');
				$jumlah_barang=$this->input->post('jumlahBarang');
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		$this->data['posts'] = $this->indexModel->getBarang();
		$arrPenjualan = $this->indexModel->getBarang();
		 $id_trans=$this->input->post('delete');
		foreach ($arrPenjualan as $post){
			
						if($this->input->post($post->id_barang) != null){
							
							$postArray2 = array(
							'id_barang'=>$post->id_barang,
							'nama_barang'=>$nama_barang,
							'qty'=>$jumlah_barang,
							'hide'=>0
							);
							$this->indexModel->editBarang($postArray2);
						}
					}
					
            $this->data['posts'] = $this->indexModel->getBarang();
            $this->load->view('barangView',$this->data);
	}
	public function deletePembelian(){
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		$arrPenjualan = $this->indexModel->getBeli();
		$arrBarangTanggal = $this->indexModel->getBarangPerTanggal();
		$arrBarang = $this->indexModel->getBarang();
		 $id_trans=$this->input->post('delete');
		 $nama_barang="";
		 $qty=0;
		foreach ($arrPenjualan as $post){
						if($this->input->post($post->id_trans_pembelian) != null){
							$postArray2 = array(
							'id_trans_pembelian'=>$post->id_trans_pembelian,
							'nama_barang'=>$post->nama_barang,
							'qty'=>$post->qty,
							'harga_beli'=>$post->harga_beli,
							'tanggal_beli'=>$post->tanggal_beli,
							'hide'=>1
							);
							$nama_barang=$post->nama_barang;
							$qty=$post->qty;
							
							$this->indexModel->deletePembelian($postArray2);
						}
					}
		
		foreach ($arrBarangTanggal as $post){
						if($this->input->post($post->id_barang_tanggal) != null){
							$postArray2 = array(
							'id_barang_tanggal'=>$post->id_barang_tanggal,
							'nama_barang'=>$post->nama_barang,
							'qty'=>$post->qty,
							'harga_beli'=>$post->harga_beli,
							'tanggal_beli'=>$post->tanggal_beli,
							'hide'=>1
							);
							$this->indexModel->deleteBarang($postArray2);
						}
					}
					
		foreach ($arrBarang as $post){
						if($nama_barang==$post->nama_barang){
							
							if($post->qty-$qty <= 0){
								$postArray2 = array(
							'id_barang'=>$post->id_barang,
							'nama_barang'=>$post->nama_barang,
							'qty'=>0,
							'hide'=>1
							);
							
							$this->indexModel->updateBarang($postArray2);
							$this->indexModel->deleteBarang2($postArray2);
							}else{
							$postArray2 = array(
							'id_barang'=>$post->id_barang,
							'nama_barang'=>$post->nama_barang,
							'qty'=>$post->qty-$qty,
							'hide'=>0
							);
							
							$this->indexModel->updateBarang($postArray2);
							}
							
						}
					}
					
					$this->data['posts'] = $this->indexModel->getBeli();
            $this->load->view('beliView',$this->data);
	}
	function editPembelian(){
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		
		$this->data['posts'] = $this->indexModel->getBeli();
		$arrBarangTanggal = $this->indexModel->getBeli();
		 $id_trans=$this->input->post('delete');
		foreach ($arrBarangTanggal as $post){
						if($this->input->post($post->id_trans_pembelian) != null){
							$this->data['post2']=$post;
						}
					}
            $this->load->view('editPembelianView',$this->data);
	}

	public function prosesEditPembelian(){
		$nama_barang=$this->input->post('dropdown');
				$jumlah_barang=$this->input->post('jumlahBarang');
				$harga_beli=$this->input->post('hargaBeli');
				$tanggal_beli=date_format(  new DateTime ($this->input->post('tanggalBeli')),"m/d/Y");
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		$this->data['posts'] = $this->indexModel->getBeli();
		$arrPenjualan = $this->indexModel->getBeli();
		$arrBarang = $this->indexModel->getBarang();
		$arrBarangTanggal= $this->indexModel->getBarangPerTanggal();
		
		 $id_trans=$this->input->post('delete');
		 $jumlah_pembelian = 0;
		 $jumlah_pembelian_baru = 0;
		foreach ($arrPenjualan as $post){
						if($this->input->post($post->id_trans_pembelian) != null){
							$jumlah_pembelian = $post->qty;
							$jumlah_pembelian_baru = $jumlah_barang;
							$postArray2 = array(
							'id_trans_pembelian'=>$post->id_trans_pembelian,
							'nama_barang'=>$nama_barang,
							'qty'=>$jumlah_barang,
							'harga_beli'=>$harga_beli,
							'tanggal_beli'=>$tanggal_beli,
							'hide'=>0
							);
							$this->indexModel->editPembelian($postArray2);
							
						}
					}
					 $selisih = $jumlah_pembelian-$jumlah_pembelian_baru;
				foreach ($arrBarang as $post){
					
						if($nama_barang == $post->nama_barang){
							$postArray2 = array(
							'id_barang'=>$post->id_barang,
							'nama_barang'=>$post->nama_barang,
							'qty'=>$post->qty-$selisih,
							'hide'=>0
							);
							$this->indexModel->editBarang($postArray2);
						}
					}	
				
				foreach ($arrBarangTanggal as $post){
					if($this->input->post($post->id_barang_tanggal) != null){
						$postArray2 = array(
									'id_barang_tanggal'=>$post->id_barang_tanggal,
									'nama_barang'=>$post->nama_barang,
									'qty'=>$post->qty-$selisih,
									'harga_beli'=>$harga_beli,
									'tanggal_beli'=>$tanggal_beli,
									'hide'=>0
									);
						$this->indexModel->editBarangPerTanggal($postArray2);
					}
				}
				$arrPenjualan = $this->indexModel->getJual();
				foreach ($arrPenjualan as $post){
					if($this->input->post($post->id_barang_tanggal) != null){
						$postArray2 = array(
						'id_trans_penjualan'=>$post->id_trans_penjualan,
						'nama_barang'=>$post->nama_barang,
						'qty'=>$post->qty,
						'harga_beli'=>$harga_beli,
						'harga_jual'=>$post->harga_jual,
						'tanggal_jual'=>$post->tanggal_jual,
						'id_barang_tanggal'=>$post->id_barang_tanggal,
						'hide'=>0
						);
						$this->indexModel->editPenjualan($postArray2);
					}
				}
            $this->data['posts'] = $this->indexModel->getBeli();
            $this->load->view('beliView',$this->data);
	}
	public function refreshBarang(){
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		$arrBarang = $this->indexModel->getBarang();
		$arrBarangTanggal = $this->indexModel->getBarangPerTanggal();
		foreach ($arrBarang as $post){
			if($post->hide == 0){
				$qty = 0;
				foreach($arrBarangTanggal as $barangtanggal){
					if($post->nama_barang == $barangtanggal->nama_barang){
						if($barangtanggal->hide == 0){
							$qty=$qty+$barangtanggal->qty;
						}
					}
				}
				$postArray2 = array(
					'id_barang'=>$post->id_barang,
					'nama_barang'=>$post->nama_barang,
					'qty'=>$qty,
					'hide'=>0
					);
				
				$this->indexModel->editBarang($postArray2);
			}
		}
	}

	function comparation(){
		$this->load->database(); // load database
		$this->load->model('indexModel'); // load model 
		$this->refreshBarang();
		$barang = $this->indexModel->getBarang();
		$jual = $this->indexModel->getJual();
		$beli = $this->indexModel->getBeli();
		$arrFinal = array();
		foreach ($barang as $post){
			$qtyBeli = 0;
			$qtyJual = 0;
						foreach ($beli as $postBeli){
							if($post->nama_barang == $postBeli->nama_barang){
								$qtyBeli = $postBeli->qty+$qtyBeli;
							}
						}
						foreach ($jual as $postJual){
							if($post->nama_barang == $postJual->nama_barang){
								$qtyJual = $postJual->qty+$qtyJual;
							}
						}
			$arrayTemp = array(
				'id_barang'=>$post->id_barang,
				'nama_barang'=>$post->nama_barang,
				'qtyBarang'=>$post->qty,
				'qtyJual'=>$qtyJual,
				'qtyBeli'=>$qtyBeli,
			);
			array_push($arrFinal,$arrayTemp);
		}
		$this->data['arrFinal']=$arrFinal;
            $this->load->view('comparationView',$this->data);
	}
}

