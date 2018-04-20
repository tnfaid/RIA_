<!DOCTYPE html>
<html>
<head>
	<title>TRANSAKSI</title>

<link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>/assets/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>/assets/jquery-ui/jquery-ui.theme.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>/assets/DataTables/datatables.min.css"/>
 

<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/assets/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/assets/DataTables/datatables.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		/*$("#kode_pelanggan").change(function(){
			//ambil kode
			var kode_pelanggan = $("#kode_pelanggan").val();
			$.ajax({
				url: "<?php echo site_url('ctrl_transaksi/kodePel_lookup') ?>",
				data: {kode_pelanggan: $("#kode_pelanggan").val(), term:$("#kode_pelanggan").val()},
				type: "get",
				cache: false,
				success: function(data){
					var pelanggan=data.split("|");
					$("#nama").val(pelanggan[0]);
					$("#alamat").val(pelanggan[1]);
					$("#telp").val(pelanggan[2]);
					$("#email").val(pelanggan[3]);
					
				}
			});
		}); */

		$("#kode_pelanggan").autocomplete({
			source:"<?php echo site_url('ctrl_transaksi/kodePel_lookup') ?>",
			minLength: 1,
			select:function(event,ui){
				$("#kode_pelanggan").val(ui.item.id);
				var term = $("#kode_pelanggan").val();
				$.ajax({
					url: "<?php echo site_url('ctrl_transaksi/pel_by_id') ?>",
					data: {term:$("#kode_pelanggan").val()},
					type: "post",
					dataType:"JSON",
					cache: false,
					success: function(data){
						$("#nama").val(data.nama_pelanggan);
						$("#alamat").val(data.alamat);
						$("#telp").val(data.telepon);
						$("#email").val(data.email);
					}
				});
			}
		});

		$("#kode_barang").autocomplete({
			source:"<?php echo site_url('ctrl_transaksi/kodeBar_lookup') ?>",
			minLength: 1,
			select:function(event,ui){
				$("#kode_barang").val(ui.item.id);
				var term = $("#kode_barang").val();
				$.ajax({
					url: "<?php echo site_url('ctrl_transaksi/bar_by_id') ?>",
					data: {term:$("#kode_barang").val()},
					type: "post",
					dataType:"JSON",
					cache: false,
					success: function(data){
						$("#nama_barang").val(data.nama_barang);
						$("#harga_jual").val(data.harga_jual);
					}
				});
			}
		});



//mencari autocomplete propinsi
		$("#propinsi").autocomplete({
			source:"<?php echo site_url('ctrl_transaksi/propinsi_lookup') ?>",
			minLength: 1,
			select:function(event,ui){
				$("#id_prov").val(ui.item.id);
			}
		});

//mencari autocomplete kabupaten/kota
		$("#kabkot").autocomplete({
			minLength: 1,
			source: function(request,response){
				$.ajax({
					url:"<?php echo site_url('ctrl_transaksi/kabkot_lookup') ?>",
					dataType:'json',
					type:'POST',
					data: {id_prov: $("#id_prov").val(), term:$("#kabkot").val()},
					success:function(msg)
					{
						response(msg);
					}
				});
			},
			select:function(event,ui){
				$("#id_kabkot").val(ui.item.id);
			}
		});

		$('#table_barang').DataTable();

	});

	function save()
		{
			$.ajax({
				url: "<?php echo site_url('ctrl_transaksi/barang_add') ?>",
				type: 'POST',
				dataType: 'JSON',
				data: $("#form_barang").serialize(),
				success: function(data){
					location.reload();
					$("#subtotal").value() = $("#harga_jual").value() * $("#jumlah_barang").value();
				},
				error: function(jqXHR,textStatus,errorThrow){
					alert('Error Adding data');
				}
			})
		}

	function delete_barang(id)
		{
			if(confirm('Are you sure ? '))
			{
				$.ajax({
					url: "<?php echo site_url('ctrl_transaksi/barang_delete') ?>",
					data: {id :id},
					type: "POST",
					dataType: "JSON",
					success: function(data)
					{
						location.reload();
					},
					error: function(jqXHR,textStatus,errorThrow)
					{
						alert('Error Deleting Data');
					}
				});
			}
		}
</script>
</head>
<body>

<div class="container">
	<p>
	<h3><b><font color="red">Transaksi Penjualan</font></b></h3>
	<h6>Toko Komputer "Saturnus"</h6>
	<h6>Jalan Kaliurang 56 Malang</h6>
	</p>
	<hr>

				
					<form>
						<div class="form row">
							<div class="form-group col-md-2">
								<p>
								Kode Pelanggan:<br>
								<input type="text" name="kode_pelanggan" id="kode_pelanggan" class="form-control">	
								</p>
							</div>
							
						</div>

						<div class="form row">
							<div class="form-group col-md-8">
								<p>Nama</p>
								<input type="text" name="nama" id="nama" class="form-control" readonly="readonly">	
							</div>
						</div>

						<div class="form row">
							<div class="form-group col-md-8">
								<p>No Telpon</p>
								<input type="text" name="telp" id="telp" class="form-control" readonly="readonly">	
							</div>
						</div>

						<div class="form row">
							<div class="form-group col-md-8">
								<p>Email</p>
								<input type="text" name="email" id="email" class="form-control"  readonly="readonly">	
							</div>
						</div>
 
						<p>Alamat</p>
						<div class="form-group">
							<input type="text" name="alamat" id="alamat" class="form-control"  readonly="readonly">
						</div>
					</form>
					<!-- -->
					<form id="form_barang">
						<div class="form row">
							<div class="form-group col-md-2">
								<p>
								Kode Barang:<br>
								<input type="text" name="kode_barang" id="kode_barang" class="form-control">	
								</p>
							</div>
							
							<div class="form-group col-md-5">
								<p>
								Nama Barang:<br>
								<input type="text" name="nama_barang" id="nama_barang" class="form-control" readonly="readonly">	
								</p>
							</div>

							<div class="form-group col-md-1">
								<p>
								Jumlah:<br>
								<input type="text" name="jumlah" id="jumlah" class="form-control" >	
								</p>
							</div>

							<div class="form-group col-md-2">
								<p>
								Harga:<br>
								<input type="text" name="harga_jual" id="harga_jual" class="form-control" readonly="readonly">	
								</p>
							</div>
							
							<button class="btn btn-success" id="btn_save" onclick="save()">Tambah</button>
					</div>
					</form>
				<br>

<table id="table_barang" class="table table-bordered table-striped table-sm">
	<thead>
		<tr>
			<th>Kode Barang</th>
			<th>Nama Barang</th>
			<th>Harga</th>
			<th>JML</th>
			<th>Subtotal</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
		<?php
$no =1;
foreach($tb_jual_detil->result_array() as $row) 
{	
	echo '<tr>';
	echo '<td>' . $row['kode_barang'] . '</td>';
	echo '<td>' . $row['nama_barang'] . '</td>';
	echo '<td id="harga_jual">' . $row['harga_jual'] . '</td>';
	echo '<td id="jumlah_barang">' . $row['jumlah'] . '</td>';
?>
<td></td>
<td><button class="btn btn-danger btn-sm" onclick="delete_barang(<?php echo $row['id'] ?>)">Delete</button></td>
<?php
}
?>
	</tbody>
</table>

</body>
</html>