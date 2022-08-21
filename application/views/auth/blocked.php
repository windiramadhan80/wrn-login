<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>WRN Animation</title>
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style-forbidden.css">

  <style>
    a {
        text-decoration: none;
        color: blue;
    }
    a:hover{
        color: black;
    }
  </style>

</head>
<body>
<!-- partial:index.partial.html -->
<div class="lock"></div>
<div class="message">
  <h1>Access to this page is restricted</h1>
  <p>Please check with the site admin if you believe this is a mistake.</p>
  
</div>
<br>

<div class="text-center" style="margin-bottom: 10px;">
    <a href="<?= base_url('user'); ?>">Back to page</a>
</div>
<!-- partial -->
<div class="text-center">
    <p><span>Copyright &copy; WRN Animation <?= date("Y"); ?></span></p>
    <hr style="margin-top: 3px;">
</div>
  
</body>
</html>
