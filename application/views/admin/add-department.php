<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <!-- Main heading and breadcrumb navigation -->
    <h1>
      Departments
    </h1>
    <ol class="breadcrumb">
      <!-- Breadcrumb links -->
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Departments</a></li>
      <li class="active">Add Department</li> <!-- Current page indicator -->
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">

      <!-- Flash messages display -->
      <?php if($this->session->flashdata('success')): ?>
        <div class="col-md-12">
          <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $this->session->flashdata('success'); ?> <!-- Display success message -->
          </div>
        </div>
      <?php elseif($this->session->flashdata('error')):?>
      <div class="col-md-12">
          <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Failed!</h4>
                <?php echo $this->session->flashdata('error'); ?> <!-- Display error message -->
          </div>
        </div>
      <?php endif;?>

      <!-- Form for adding a department -->
      <div class="col-md-12">
        <!-- General form elements -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Add Department</h3>
          </div>
          <!-- Form start -->
          <form role="form" action="<?php echo base_url(); ?>insert-department" method="POST">
            <div class="box-body">
             
              <div class="col-md-12">
                <!-- Department Name input field -->
                <div class="form-group">
                  <label for="exampleInputPassword1">Department Name</label>
                  <input type="text" name="txtdepartment" class="form-control" placeholder="Department Name">
                </div>
              </div>
              
            </div>
            <!-- Form footer with submission button -->
            <div class="box-footer">
              <button type="submit" class="btn btn-success pull-right">Submit</button>
            </div>
          </form>
        </div>
        <!-- /.box -->
      </div>
      <!--/.col (left) -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
