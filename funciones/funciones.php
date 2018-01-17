<?php
include("../config.php");

$accion=$_GET["accion"];

if($accion=="conexion"){
	global $usuario,$pass;
    $ip=$_GET["ip"];
    $url="https://".$ip.":4343/v1/api/login?username=".$usuario."&password=".$pass;
    $ch = curl_init();    // initialize curl handle
    $cookie_file_path = 'my_cookie.txt';
    $cookie_file_path = realpath($cookie_file_path);

    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);    
    curl_setopt($ch, CURLOPT_URL,$url); // set url to post to
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
    curl_setopt($ch, CURLOPT_TIMEOUT, 8); // times out after 8s
    curl_setopt($ch, CURLOPT_POST, 0); // set POST method
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);  

    
    $chresult = curl_exec($ch);

    
    
    if (curl_error($ch))
            printf("Error %s: %s", curl_errno($ch), curl_error($ch));
    echo $chresult; // run the whole process
}


if($accion=="uplinks"){
    $uidaruba=$_GET["uidaruba"];
    $ip=$_GET["ip"];
    $url="https://".$ip.":4343/v1/configuration/showcommand?command=show+uplink&UIDARUBA=".$uidaruba;

    $ch = curl_init();    // initialize curl handle
    curl_setopt($ch, CURLOPT_URL,$url); // set url to post to
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);// allow redirects
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 0); // set POST method
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);  
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: SESSION=".$uidaruba));
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $chresult = curl_exec($ch);

    if (curl_error($ch))
            printf("Error %s: %s", curl_errno($ch), curl_error($ch));
    echo $chresult; // run the whole process


}

if($accion=="health-check"){
    $uidaruba=$_GET["uidaruba"];
    $ip=$_GET["ip"];
    $url="https://".$ip.":4343/v1/configuration/showcommand?command=show+ip+health-check+verbose&UIDARUBA=".$uidaruba;

    $ch = curl_init();    // initialize curl handle
    curl_setopt($ch, CURLOPT_URL,$url); // set url to post to
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);// allow redirects
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 0); // set POST method
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);  
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: SESSION=".$uidaruba));
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $chresult = curl_exec($ch);

    if (curl_error($ch))
            printf("Error %s: %s", curl_errno($ch), curl_error($ch));
    echo $chresult; // run the whole process


}


if($accion=="comando"){
    $uidaruba=$_GET["uidaruba"];
    $comando=$_GET["comando"];
    $ip=$_GET["ip"];
    $url="https://".$ip.":4343/v1/configuration/showcommand?command=".$comando."&UIDARUBA=".$uidaruba;

    $ch = curl_init();    // initialize curl handle
    curl_setopt($ch, CURLOPT_URL,$url); // set url to post to
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);// allow redirects
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 0); // set POST method
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);  
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: SESSION=".$uidaruba));
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $chresult = curl_exec($ch);

    if (curl_error($ch))
            printf("Error %s: %s", curl_errno($ch), curl_error($ch));
    echo $chresult; // run the whole process
}

if($accion=="pingar"){
    $ping_site=$_GET["ping_site"];
    $resultado = exec("ping -c 1 ".$ping_site);
    if (preg_match('/stddev/',$resultado)){
        $resultado_parse=explode("/",$resultado);
        $valor=$resultado_parse[4];
    }else{
        $valor=0;
    }
    print_r($valor);
}
?>