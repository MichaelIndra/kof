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
                <a href="<?php echo base_url() ?>/dashboard/logout" type="submit" class="btn btn-success"><i class="fa fa-sign-out"></i> Logout</a>
            </div>
        </div>
</nav>
<div class="container" style="margin-top: 80px">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
              <a href="#" class="list-group-item active" style="text-align: center;background-color: black;border-color: black">
                ADMINISTRATOR
              </a>
              <a href="<?php echo base_url();?>Jemaat" class="list-group-item"><i class="fa fa-book"></i> Jemaat</a>
              <a href="<?php echo base_url();?>Absensi" class="list-group-item"><i class="fa fa-folder"></i> Absensi</a>
              <a href="<?php echo base_url();?>Kas" class="list-group-item"><i class="fa fa-comments-o"></i> Kas</a>
              
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-dashboard"></i> Dashboard</h3>
              </div>
              <div class="panel-body">
                Selamat Datang <b><?php echo $this->session->userdata("user_name") ?></b> 
              </div>
            </div>
        </div>
    </div>
</div>