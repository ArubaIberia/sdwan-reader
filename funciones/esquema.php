<?php
    include("../config.php");

$datapath=$_POST["datapath"];
$uplink=$_POST["uplink"];
$nexthop=$_POST["nexthop"];
$interfaces=$_POST["interfaces"];




$ip_pc_cliente=$ip_cliente;

if($datapath!=""){
    $datapath =  json_decode($datapath,true);
	$uplink =  json_decode($uplink,true);
	$nexthop =  json_decode($nexthop,true);
	$interfaces =  json_decode($interfaces,true);
	$resultado=array();
	
	// ordenamos los NEXT-HOP ID y los valores
	$lineas=count($nexthop["Nexthop-List Entries"]);
	
	
	
	
	
	// SACAMOS EL ESTADO DE LOS INTERFACES PARA CADA VLAN
	// SACAMOS EL ESTADO ADMINISTRATIVO Y PROTOCOLO
	$interfaces_status=array();
    foreach ($interfaces["_data"] as $key=>$item ){
        $cortado=preg_split("/\s\s+/", $interfaces["_data"][$key]);
		if(array_key_exists(2,$cortado) AND array_key_exists(3,$cortado)){
			$interfaces_status[$cortado[0]]=array($cortado[2],$cortado[3]);
		}
    }
	//print("<pre>".print_r($interfaces_status,true)."</pre>");
	// FIN EXTRACCIÓN DEL ESTADO DE LOS INTERFACES PARA CADA VLAN
	
	
	
	
	
	foreach($nexthop["Nexthop-List Entries"] AS $key=>$value){
		$destino=$value["Nexthop Dest"];
		$hop_id=$value["Nexthop"];
		$hop_id=substr($hop_id,-1);
		$resultado[$hop_id]=array("destino"=>$destino,"hop_id"=>$hop_id);
	}
	

	// ordenamos los UPLINKS y la VLAN
	foreach($uplink[" Uplink Management Table"] AS $key=>$value){
		$uplink_id=$value["Id"];
		$vlan=$value["Properties"];
		$resultado[$uplink_id]["vlan"]=$vlan;
	}	
	// -------------------
    
    foreach($datapath["_data"] AS $key=>$value){
        $value=explode(" ",$value);

         // print("<pre>".print_r($value,true)."</pre>");


        if(in_array($ip_pc_cliente,$value) AND $value[0]==$ip_pc_cliente){
             
            if(in_array($ping_site,$value)){
				
				foreach($resultado AS $key2=>$value2){
					
					if(array_key_exists("destino",$value2)){

						if(in_array($value2["destino"],$value)){

							if(array_key_exists("vlan",$value2)){
							
								if($value2["vlan"]==$vlan_2_id){
									$l1=$color_KO;
									$t1=$vlan_1_name;
									$l2=$color_OK;
									$t2=$vlan_2_name;
									if($interfaces_status[$vlan_1_id][0]=="up" AND $interfaces_status[$vlan_1_id][1]=="up"){
										$l1=$color_STB;
									}
								}
								if($value2["vlan"]==$vlan_1_id){
									$l1=$color_OK;
									$t1=$vlan_1_name;
									$l2=$color_KO;
									$t2=$vlan_2_name;
									if($interfaces_status[$vlan_2_id][0]=="up" AND $interfaces_status[$vlan_2_id][1]=="up"){
										$l2=$color_STB;
									}									
								}
							}
						}
					}
				}
            }    
        }

    }
    ?>
    <style>
    #container_sdwan{
      height: 40px;
      width: 800px;
      position:relative;
        text-align: center;
    }
    #image_sdwan{
      position: relative;
      left: 0;
      top: 0;
		
    }
    #text_sdwan{
      z-index: 100;
      position: absolute;
      color: white;
      font-size: 1em;
      font-weight: bold;
      left: 520px;
      top:90px;
        background-color: <?php echo $l1; ?>;
        height:20px;
        width: 300px;
		box-shadow: 8px 5px 1000px <?php echo $l1; ?>;
		-webkit-box-shadow: 0 0 30px <?php echo $l1; ?>;
				box-shadow: 0 0 30px <?php echo $l1; ?>;

		border-radius: 10px 10px 10px 10px;
		-moz-border-radius: 10px 10px 10px 10px;
		-webkit-border-radius: 10px 10px 10px 10px;
		border: 0px solid #000000;         
    }
    #text2_sdwan{
      z-index: 100;
      position: absolute;
      color: white;
      font-size: 1em;
      font-weight: bold;
      left: 520px;
      top: 30px;
        background-color: <?php echo $l2; ?>;
        height:20px;
        width: 300px;
		box-shadow: 8px 5px 1000px <?php echo $l2; ?>;
		-webkit-box-shadow: 0 0 30px <?php echo $l2; ?>;
				box-shadow: 0 0 30px <?php echo $l2; ?>;

		border-radius: 10px 10px 10px 10px;
		-moz-border-radius: 10px 10px 10px 10px;
		-webkit-border-radius: 10px 10px 10px 10px;
		border: 0px solid #000000;        
    }        
    </style>
    <div id="container_sdwan" style="">
      <img id="image_sdwan" src="img/controlador.jpg" width="300" />
      <p id="text_sdwan" class=""><?php echo $t1; ?></p>
      <p id="text2_sdwan"><?php echo $t2; ?></p>
    </div>

    <?php
}
?>