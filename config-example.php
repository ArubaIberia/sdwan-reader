<?php

/*
Fichero de configuración del SCRIPT
*/

// ------------------------------------------------------
// Configuración del Controlador Branch
// ------------------------------------------------------
// Dirección IP del Controlador Branch
$ip="10.228.50.65";
// Usuario para acceder por la API
$usuario="admin-user";
// Password para acceder por la API
$pass="admin-password";
// ------------------------------------------------------


// ------------------------------------------------------
// Configuración del Ping
// ------------------------------------------------------
// Dirección IP contra la que hacer Ping en el Data Center
$ping_site="10.150.2.63";
// Dirección IP del PC del cliente conectado en la Branch. 
// Pendiente de mejora para futuras versiones.
$ip_cliente="10.228.70.4";
// ------------------------------------------------------


// ------------------------------------------------------
// Configuración de nombres y Colores para el esquema
// ------------------------------------------------------
// ID de la VLAN 1. Deberá incluir "vlan " 
$vlan_1_id="vlan 4094";
// Nombre que se quiere mostrar en el esquema para VLAN 1
$vlan_1_name="Uplink FTTH";
// ID de la VLAN 2. Deberá incluir "vlan " 
$vlan_2_id="vlan 4093";
// Nombre que se quiere mostrar en el esquema para VLAN 2
$vlan_2_name="Uplink 3G";
// Color para linea usada para enviar trafico
$color_OK="#00cc00"; // Verde, levantado
// Color para linea caída
$color_KO="#ff0000"; // Rojo, caído
// Color para linea activa pero no usada
$color_STB="#cccc00"; // Standby
// ------------------------------------------------------


// ------------------------------------------------------
// Otras configuraciones
// ------------------------------------------------------
// Dirección para atacar a la API
$url="https://".$ip."/api/v1/";
// ------------------------------------------------------

?>