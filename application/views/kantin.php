<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo $judul ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <div class="navbar-form navbar-right">
                <a href="<?php echo base_url() ?>Dashboard" type="submit" class="btn btn-success"><i class="fa fa-sign-out"></i> Dashboard</a>
            </div>
        </div>
</nav>
<div class="container" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
              <a href="#" class="list-group-item active" style="text-align: center;background-color: black;border-color: black">
                ADMINISTRATOR Kantin
              </a>
              <a href="<?php echo base_url();?>Supplier" class="list-group-item"><i class="fa fa-book"></i> Data Supplier</a>
              <a href="<?php echo base_url();?>Dagangan" class="list-group-item"><i class="fa fa-folder"></i> Barang Dagang Supplier</a>
              <a href="<?php echo base_url();?>Hargadagang" class="list-group-item"><i class="fa fa-comments-o"></i> Harga Dagang Supplier</a>
              <a href="<?php echo base_url();?>Transaksi" class="list-group-item"><i class="fa fa-comments-o"></i> Transaksi</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-dashboard"></i> Dashboard Kantin</h3>
              </div>
              <div class="panel-body">
                Selamat Datang <b><?php echo $this->session->userdata("user_name") ?></b> 
              </div>
            </div>
        </div>
    </div>
</div>