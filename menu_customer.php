<?php 
include("layout.php");
include("config.php");
include('link_bootstrap.php');
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Order Tracking System</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home <span class="sr-only"></span></a></li>
        <li><a href="product.php">Products</a></li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">My Orders <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="order_customer_pending.php">Pending</a></li>
            <li><a href="order_customer_processing.php">Processing</a></li>
            <li><a href="order_customer_delivered.php">Delivered</a></li>
            <li><a href="order_customer_cancelled.php">Cancelled</a></li>
          </ul>
        </li>
        <li><a href="customer_profile.php">My Profile</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="destroy.php">Logout<?php echo"(".$_SESSION['username'].")";?></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>