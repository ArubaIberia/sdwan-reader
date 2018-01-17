<?php
/*
url: https://github.com/ArubaIberia/sdwan-reader
author: Rafael del Cerro Flores
description: SDWAN reader for Aruba Controller
*/


// Incluimos la variables de configuracion
	include("config.php");


	if($debug){
		$text_fiels_status="text";
	}else{
		$text_fiels_status="hidden";
	}
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/series-label.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>     
    <script src="funciones/funciones.js"></script>
      
    <title>SD-WAN Viewer</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/small-business.css" rel="stylesheet">
    
      
      <link rel="stylesheet" href="libs/fontawesome/css/font-awesome.min.css">
<script>

    
</script>
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary">
      <div class="container">
        <a class="navbar-brand" href="#"><i class="fa fa-tachometer" aria-hidden="true"></i> SD-WAN Viewer</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php"><i class="fa fa-user-circle" aria-hidden="true"></i> Inicio 
                <span class="sr-only">(current)</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
      <!-- Content Row -->
    <input type="<?php echo $text_fiels_status; ?>" name="ip" id="ip" value="<?php echo $ip; ?>" width="10">
    <input type="<?php echo $text_fiels_status; ?>" name="usuario" id="usuario" value="<?php echo $usuario; ?>">
    <input type="<?php echo $text_fiels_status; ?>" name="pass" id="pass" value="<?php echo $pass; ?>">
    <input type="<?php echo $text_fiels_status; ?>" name="ping_site" id="ping_site" value="<?php echo $ping_site; ?>">
    <input type="<?php echo $text_fiels_status; ?>" name="uidaruba" id="uidaruba" value="">       
    <input type="<?php echo $text_fiels_status; ?>" name="salud" id="salud">
    <input type="<?php echo $text_fiels_status; ?>" name="uplink" id="uplink">
    <input type="<?php echo $text_fiels_status; ?>" name="interfaces" id="interfaces" width="">        
    <input type="<?php echo $text_fiels_status; ?>" name="tunel" id="tunel" width="">
    <input type="<?php echo $text_fiels_status; ?>" name="pingar" id="pingar" width="">
    <input type="<?php echo $text_fiels_status; ?>" name="vlan" id="vlan" width="">
    <input type="<?php echo $text_fiels_status; ?>" name="datapath" id="datapath" width="">
	<input type="<?php echo $text_fiels_status; ?>" name="nexthop" id="nexthop" width="">
	<input type="<?php echo $text_fiels_status; ?>" name="ip_local" id="ip_local" width="">	
		
        
		<div id="res"></div>
        <div id="valores" style=""></div>
      <div class="row">
          <div class="col-md-12">
              <br><h2>Estado de las lineas WAN</h2>
        </div>
          
        <div class="col-md-12">
            <div id="resultado"></div>
        </div>
        </div>
        <div class="row">
          <div class="col-md-6">
      <div id="grafica" name="grafica"></div>    
       </div>
          <div class="col-md-6">
      <div id="grafica_ping" name="grafica_ping"></div>    
       </div>            
        </div>
        <div class="row">
          <div class="col-md-12">
      <div id="esquema" name="esquema" class="text-center" ></div>    
       </div>
           
        </div>        
      </div>
    <!-- Bootstrap core JavaScript -->
    
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
