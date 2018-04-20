<?php include 'admin/header.php'; ?>
<?php include 'admin/aside.php'; ?>


<link rel="stylesheet" href="<?php echo base_url() ?>/assets/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>/assets/jquery-ui/jquery-ui.theme.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>/assets/DataTables/datatables.min.css"/>

<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/assets/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/assets/DataTables/datatables.min.js"></script>
 
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transaksi
        <small>Penjualan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Transaksi</li>
      </ol>
    </section>
<script type="text/javascript">
	$(document).ready(function(){
		/*$("#kode_pelanggan").change(function(){
			//ambil kode
			var kode_pelanggan = $("#kode_pelanggan").val();
			$.ajax({
				url: "<?php echo site_url('transaksi/kodePel_lookup') ?>",
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
			source:"<?php echo site_url('transaksi/kodePel_lookup') ?>",
			minLength: 1,
			select:function(event,ui){
				$("#kode_pelanggan").val(ui.item.id);
				var term = $("#kode_pelanggan").val();
				$.ajax({
					url: "<?php echo site_url('transaksi/pel_by_id') ?>",
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
			source:"<?php echo site_url('transaksi/kodeBar_lookup') ?>",
			minLength: 1,
			select:function(event,ui){
				$("#kode_barang").val(ui.item.id);
				var term = $("#kode_barang").val();
				$.ajax({
					url: "<?php echo site_url('transaksi/bar_by_id') ?>",
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


		$('#table_barang').DataTable();

	});

	function save()
		{
			$.ajax({
				url: "<?php echo site_url('transaksi/barang_add') ?>",
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
					url: "<?php echo site_url('transaksi/barang_delete') ?>",
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
	<!-- form start -->
    <form role="form">
      <div class="box-body">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
            <input type="text" class="form-control" name="kode_pelanggan" id="kode_pelanggan" placeholder="input kode pelanggan">
        </div>
        <br>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
            <input type="text" class="form-control" name="nama" id="nama" readonly="readonly" placeholder="nama">
        </div>
        <br>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-phone"> </i></span>
            <input type="text" class="form-control" name="telp" id="telp" readonly="readonly" placeholder="nomor telepon">
        </div>
        <br>
        <div class="input-group">
            <span class="input-group-addon">@</span>
            <input type="text" class="form-control" name="email" id="email" readonly="readonly" placeholder="Email">
        </div>
        <br>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-home"> </i></span>
            <input type="text" class="form-control" name="alamat" id="alamat" readonly="readonly" placeholder="Alamat">
        </div>
      </div>
      <hr>
      <hr>
    <!-- /.box-body -->
    	<form id="form_barang">
	    	<div class="form row">
	    	<div class="col-xs-3">
	    		<input type="text" id="kode_barang" class="form-control input-lg" placeholder="Kode Barang" >
	    		<br>
	    		<br>
	    		<input type="text" name="nama_barang" id="nama_barang" class="form-control input-lg" readonly="readonly" placeholder="Nama Barang">
	    	</div>

	    	<div class="col-xs-3">
	    		<input type="text" id="jumlah" name="jumlah" class="form-control input-lg" placeholder="Jumlah Barang" >
	    		<br>
	    		<br>
	    		<input type="text" name="harga_jual" id="harga_jual" class="form-control input-lg" readonly="readonly" placeholder="Nama Barang">
	    	</div>

	    	<div class="col-xs-3">
	    		<input type="text" name="total" id="total" class="form-control input-lg" readonly="readonly" placeholder="Total">
	    		<br>
	    		<br>
	    		<button class="btn btn-success form-control input-lg" id="btn_save" onclick="save()">Tambah</button>
	    	</div>

	    	<div class="col-lg-3 col-xs-6">
	          <!-- small box -->
	          <div class="small-box bg-aqua">
	            <div class="inner">
	              <h3>150</h3>

	              <p>New Orders</p>
	            </div>
	            <div class="icon">
	              <i class="fa fa-shopping-cart"></i>
	            </div>
	            <a href="#" class="small-box-footer">
	              More info <i class="fa fa-arrow-circle-right"></i>
	            </a>
	          </div>
	        </div>
	    	</div> 	
	    </form>
					
		<hr><hr>

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