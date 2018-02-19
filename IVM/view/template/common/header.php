<!DOCTYPE html>
<html lang="en">
<head>
  <title>Inventory Management</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
  <link href="view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
  <script src="view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <script defer src="view/javascript/fontawesome-free-5.0.6/svg-with-js/js/fontawesome-all.js"></script>
  <link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
  <script src="view/javascript/jquery/datetimepicker/moment.js" type="text/javascript"></script>
  <script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
  <!-- <link href="view/css/main.css" rel="stylesheet" media="screen" /> -->
  <style>
  body {
      font: 15px Montserrat, sans-serif;
      line-height: 1.8;
      /*color: #f5f6f7;*/
  }
  .navbar {
      padding-top: 15px;
      padding-bottom: 15px;
      border: 0;
      border-radius: 0;
      margin-bottom: 0;
      font-size: 12px;
      letter-spacing: 5px;
  }
  .navbar-nav  li a:hover {
      color: #1abc9c !important;
  }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="<?php echo $data['dashboard']; ?>">Inventory Management</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo $data['user']; ?>">User</a></li>
        <li><a href="<?php echo $data['inventory']; ?>">Inventory</a></li>
        <li><a href="<?php echo $data['logout']; ?>">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
