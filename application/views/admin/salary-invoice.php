<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Invoice
      <small>#00<?php echo rand(1000,100)?></small> <!-- Generating a random invoice number -->
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Salary Management</a></li>
      <li class="active">Invoice</li>
    </ol>
  </section>

  <?php 
    // Check if $content is set and loop through its items
    if(isset($content)):
    $i=1; 
    foreach($content as $cnt): 
  ?>
  <!-- Main content -->
  <section class="invoice" id="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          Human Resource Management System
          <small class="pull-right">Date: <?php echo date('d-m-Y'); ?></small> <!-- Displaying current date -->
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <!-- From -->
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong>Nano Tech</strong><br>
          Bethany<br>
          6964 Ralph Street<br>
          Website: www.nanotech.com<br>
          Email: admin@nanotech.com
        </address>
      </div>
      <!-- To -->
      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong><?php echo $cnt['staff_name']; ?></strong><br>
          <?php echo $cnt['city']; ?><br>
          <?php echo $cnt['state']; ?>, <?php echo $cnt['country']; ?><br>
          Phone: <?php echo $cnt['mobile']; ?><br>
          Email: <?php echo $cnt['email']; ?>
        </address>
      </div>
      <!-- Invoice details -->
      <div class="col-sm-4 invoice-col">
        <b>Invoice #00<?php echo $cnt['id']; ?></b><br> <!-- Displaying invoice number -->
        <br>
        <b>Paid On:</b> <?php echo date('d-m-Y', strtotime($cnt['added_on'])); ?> <!-- Displaying payment date -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Basic Salary</th>
              <th>Allowance</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>$ <?php echo $cnt['basic_salary']; ?></td>
              <td>$ <?php echo $cnt['allowance']; ?></td>
              <td>$ <?php echo $cnt['total']; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Payment and Salary Info -->
    <div class="row">
      <!-- Payment methods and message -->
      <div class="col-xs-6">
        <p class="lead">Payment Methods:</p>
        <!-- Payment method icons -->
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
          <!-- Payment message -->
        </p>
      </div>
      <!-- Salary Info -->
      <div class="col-xs-6">
        <p class="lead">Salary Info</p>
        <!-- Salary details -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Print and PDF generation buttons -->
    <div class="row no-print">
      <div class="col-xs-12">
        <!-- Print button -->
        <a href="<?php echo base_url(); ?>print-invoice/<?php echo $cnt['id']; ?>" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> Print</a>
        <!-- Generate PDF button -->
        <button type="button" id="cmd" class="btn btn-danger pull-right" style="margin-right: 5px;">
          <i class="fa fa-download"></i> Generate PDF
        </button>
      </div>
    </div>
  </section>
  <!-- /.content -->

  <?php 
    $i++;
    endforeach;
    endif; 
  ?>

  <div class="clearfix"></div>
</div>
<!-- /.content-wrapper -->

<!-- Libraries for PDF generation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
<script>
$(document).ready(function() {
    // Function to generate PDF
    $('#cmd').click(function () {
      let doc = new jsPDF('p','pt','a4');
      doc.addHTML($('#invoice'),function() {
          doc.save('invoice.pdf');
      }); 
    });
});
</script>
