<?php

if(isset($_POST["health_check"]) AND isset($_POST["interfaces"]) AND $_POST["health_check"]!="" AND $_POST["interfaces"]!="" AND $_POST["vlans"]!=""){

    $health_check=$_POST["health_check"];
    $uplink=$_POST["uplink"];
    $interfaces=$_POST["interfaces"];
    $tunel=$_POST["tunel"];
    $vlans=$_POST["vlans"];

    $tabla="";
    
    $vlans =  json_decode($vlans,true);
    
    $data =  json_decode($health_check,true);
    $salud1=$data['IP Health-check Entries'];
    
    foreach ($salud1 as $key=>$item ){
        foreach($item as $key1=>$item1){
            $icono="";
            $texto=$item1;
            if($key1=="State"){
                if($item1=="Up"){
                    $icono='<i class="fa fa-arrow-circle-o-up text-success fa-2x" aria-hidden="true"></i>';
                    $texto="";
                }else{
                    $icono='<i class="fa fa-arrow-circle-o-down text-danger fa-2x" aria-hidden="true"></i>';
                    $texto="";
                }
            }
        }
    }

    
// -------------
// Función buscar claves en array multidimension
// -------------
function buscar_multidimension($array,$cadena){
    $resultado="";
    foreach ($array as $key=>$item ){
        // foreach($item as $key1=>$item1){
            if(array_search($cadena, $item)){
               $resultado=array($key,array_search($cadena, $item)); 
            }
        // }
    }    
    return($resultado);
}
// -------------
// Fin buscara en array multidimensional
// -------------
    

function buscar_vlan($array,$vlan){
    $resultado="";
    foreach ($array["VLAN CONFIGURATION"] as $key=>$item ){
            if($item["VLAN"]==$vlan){
                $resultado=$item["Description"];
            }
    } 
    return($resultado);
}
    
    
    $resultado=buscar_multidimension($salud1,'vlan 4093');
    
    
    $data2 = json_decode($uplink,true);
    $uplink1 = $data2[' Uplink Management Table'];
    $item="";
    foreach ($uplink1 as $key=>$item ){
        $vlan=$uplink1[$key]["Properties"];
        $resultado=buscar_multidimension($salud1,$vlan);
        foreach($item as $key1=>$item1){
            $salud1[$resultado[0]][$key1]=$item1;
        }
    }

    
    
    
// -------------------
// INTERFACES
// -------------------
    $interfaces = json_decode($interfaces,true);

    $interfaces2=array();
    foreach ($interfaces["_data"] as $key=>$item ){
        $cortado=preg_split("/\s\s+/", $interfaces["_data"][$key]);
        $interfaces2[]=$cortado;
        $vlan = $cortado[0];
        
        $resultado=buscar_multidimension($salud1,$vlan);
        
        if($resultado){
            $datos_ip=explode("/",$cortado[1]);
            $salud1[$resultado[0]]["ip"]=trim($datos_ip[0]);
            $salud1[$resultado[0]]["mascara"]=trim($datos_ip[1]);
            $salud1[$resultado[0]]["admin"]=$cortado[2];
            $salud1[$resultado[0]]["protocol"]=$cortado[3];
        }
    }
// -------------------    
// FIN DE INTERFACES    
// -------------------    

    
    
    
// -------------------
// TUNEL
// -------------------    
    $tunel = json_decode($tunel,true);
    $tunel2=array();
    foreach ($tunel["_data"] as $key=>$item ){
        $cortado=preg_split("/\s\s+/", $tunel["_data"][$key]);
        $ip=$cortado[0];
        $resultado=buscar_multidimension($salud1,$ip);
        if($resultado){
            $salud1[$resultado[0]]["tunel"]=$cortado[1];
        }
    }
// -------------------    
// FIN DE TUNEL    
// -------------------    

    
    
    // Metemos las cabeceras de la tabla que se mostrará
    // se sacarán en el orden que se metan
    // cada línea del array incluye: 0 => Nombre real; 1 => Etiqueta que le ponemos
    $orden=array();
    $orden[]=array("Src Interface","Interface");
    $orden[]=array("State","Estado");
    $orden[]=array("admin","Admin");
    $orden[]=array("protocol","Protocol");
    $orden[]=array("H/w State","Puerto HW");
    $orden[]=array("Avg RTT(in ms)","RTT (ms)");
    $orden[]=array("Reachability","Alcanzable");
    $orden[]=array("ip","IP");
    $orden[]=array("tunel","Tunel");
    // fin de las cabeceras y su orden
    
    
    // Pintamos la tabla
    echo '<table border="1" class="table table-bordered table-sm">';
    echo "<tr>";
    foreach($orden as $key=>$item){
        echo "<th>".$item[1]."</th>";
    }
    echo "</tr>";
    foreach ($salud1 as $key=>$item ){
        if($item["Src Interface"]!="--"){
            echo "<tr>";
            foreach ($orden as $key1=>$item1 ){   
                $valor="";
                
                if(array_key_exists($item1[0],$salud1[$key])){
                    $valor=$salud1[$key][$item1[0]];
                    $cabecera=$item1[0];
                    
                    if($cabecera=="State"){
                        if($valor=="Up"){
                            $icono='<i class="fa fa-arrow-circle-o-up text-success fa-2x" aria-hidden="true"></i>';
                            $texto="";
                        }else{
                            $icono='<i class="fa fa-arrow-circle-o-down text-danger fa-2x" aria-hidden="true"></i>';
                            $texto="";
                        }
                        $valor=$icono;
                    }
                    if($cabecera=="protocol"){
                        if($valor=="up"){
                            $icono='<i class="fa fa-arrow-circle-o-up text-success fa-2x" aria-hidden="true"></i>';
                            $texto="";
                        }else{
                            $icono='<i class="fa fa-arrow-circle-o-down text-danger fa-2x" aria-hidden="true"></i>';
                            $texto="";
                        }
                        $valor=$icono;
                    }  
                    if($cabecera=="admin"){
                        if($valor=="up"){
                            $icono='<i class="fa fa-arrow-circle-o-up text-success fa-2x" aria-hidden="true"></i>';
                            $texto="";
                        }else{
                            $icono='<i class="fa fa-arrow-circle-o-down text-danger fa-2x" aria-hidden="true"></i>';
                            $texto="";
                        }
                        $valor=$icono;
                    }
                    if($cabecera=="Src Interface"){
                        $valor_vlan=str_replace("vlan ","",$valor);
                        $vlan_descripcion=buscar_vlan($vlans,$valor_vlan);
                        if($vlan_descripcion!=""){
                            $valor=$vlan_descripcion;
                        }
                    }
                }
                echo "<td>".$valor."</td>";
            }
            echo "</tr>";
        }
    }
    echo "</table>";
    
}

?>