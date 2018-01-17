$(function() {
    var rtt=[];
    function bucle(){        
        uidaruba=$("#uidaruba").val();
        if(uidaruba!=""){
            sacar_vlans();
            sacar_datos_health_check();
            sacar_datos_uplinks();
            sacar_datos_interfaces();
            sacar_datos_tunel();
            pingar();
            sacar_tunel_usado();
			sacar_nexthop();
            pintar_esquema();
			
            salud=$("#salud").val();
            uplink=$("#uplink").val();
            interfaces=$("#interfaces").val();
            tunel=$("#tunel").val();
            pintar(salud,uplink,interfaces,tunel);        
            pingado=$("#pingar").val();
            
            if(salud!=""){
                salud_json = $.parseJSON(salud);
                vlans = $.parseJSON(vlans);
                indice=0;
                cambiado=0;
                $.each( salud_json["IP Health-check Entries"], function( key, value ) {
                    valor_rtt=value["Avg RTT(in ms)"];
                    valor_vlan=value["Src Interface"];
                    valor_int=value["Src Interface"];
                    
                    
                    if(valor_int!="--"){
                        
                        // miramos el nombre de la VLAN
                        $.each(vlans["VLAN CONFIGURATION"], function( key, value ) {
                            var red=value["VLAN"];
                            var vlan_parse=valor_vlan.replace("vlan ", "");
                            if(parseFloat(vlan_parse)==parseFloat(red)){
                                var vlan_des=value["Description"];
                                valor_vlan=vlan_des;
                            }
                        });
                        // fin mirar el nombre de la vlan
                        
                        
                        rtt.push(value["Avg RTT(in ms)"]);                          
                        
                        largo=graficaa.series.length;
                        estimado=indice+1;
                        
                        if(estimado>largo){
                             graficaa.addSeries({                        
                                name: valor_vlan,
                                data: []
                            });
                        }
                        
                        var series = graficaa.series[indice];
                        var x = (new Date()).getTime();
                        series.addPoint([x, parseFloat(valor_rtt)], true);
                        series.name=valor_vlan;
                        
                        // ------------------------------------------------------------
                        // Inicio de Grafica de Pings
                        // ------------------------------------------------------------
                        if(pingado==""){
                            pingado=parseFloat(0);
                        }
                        var series2 = grafica_ping.series[0];
                        series2.addPoint([x, parseFloat(pingado)], true);
                        // ------------------------------------------------------------
                        // FIN de Gráfica de Pings
                        // ------------------------------------------------------------
                        
                        indice+=1;
                    } // si es un UPLINK bueno
                    
                });
            }
        }
    }    

    function pingar(){
        ping_site=$("#ping_site").val();
        $.ajax({
            url: "funciones/funciones.php",
            data: { 
                accion: 'pingar',
                ping_site: ping_site
            },
            success: function(result){
                $("#pingar").val(result);
                // $("#res").html(result);
            }
        });
    }
    
    function conexion(){
        ip=$("#ip").val();
        $.ajax({
            url: "funciones/funciones.php",
            dataType: "json",
            data: { 
                accion: 'conexion',
                ip: ip
            },
            success: function(result){
                var uidaruba=result["_global_result"].UIDARUBA;
                $("#uidaruba").val(uidaruba);
                if(uidaruba!=""){
                    bucle();
                    setInterval(bucle, 1500);
                }
            }
        });
    } // function conexion()


    
    function pintar(health_check,uplink,interfaces,tunel){
        ip=$("#ip").val();
        vlans=$("#vlan").val();
        $.ajax({
            url: "funciones/tablas.php",
            method: "POST",
            data: { 
                health_check: health_check,
                uplink: uplink,
                interfaces: interfaces,
                tunel: tunel,
                ip: ip,
                vlans: vlans
            },
            success: function(result){   
                $("#resultado").html(result);
            }
        });
    }
    
    function pintar_esquema(){
        datapath=$("#datapath").val();
		nexthop=$("#nexthop").val();
		uplink=$("#uplink").val();
		interfaces=$("#interfaces").val();
        $.ajax({
            url: "funciones/esquema.php",
            method: "POST",
            data: { 
                datapath: datapath,
				nexthop: nexthop,
				uplink: uplink,
				interfaces: interfaces
            },
            success: function(result){   
                $("#esquema").html(result);
            }
        });
    }    
    
    function sacar_datos_health_check(){
        uidaruba=$("#uidaruba").val();
        resultado="";
        ip=$("#ip").val();
        $.ajax({
            url: "funciones/funciones.php",
            // dataType: "json",
            data: { 
                accion: 'health-check',
                uidaruba: uidaruba,
                ip
            },
			success: function(result){
                $("#salud").val(result);                
            }
        });   
    }


	
    function sacar_datos_interfaces(){
        uidaruba=$("#uidaruba").val();
        p=$("#ip").val();
        $.ajax({
            url: "funciones/funciones.php",
            data: { 
                accion: 'comando',
                uidaruba: uidaruba,
                comando: 'show+ip+interface+brief',
                ip: ip
            },
            success: function(result){
                $("#interfaces").val(result);
            }
        });
    }    
    
	
    function sacar_nexthop(){
        uidaruba=$("#uidaruba").val();
        p=$("#ip").val();
        $.ajax({
            url: "funciones/funciones.php",
            data: { 
                accion: 'comando',
                uidaruba: uidaruba,
                comando: 'show+ip+nexthop-list+load-balance-ipsecs',
                ip: ip
            },
            success: function(result){
                $("#nexthop").val(result);
            }
        });
    }	
	
    function sacar_datos_tunel(){
        uidaruba=$("#uidaruba").val();
        p=$("#ip").val();
        $.ajax({
            url: "funciones/funciones.php",
            data: { 
                accion: 'comando',
                uidaruba: uidaruba,
                comando: 'show+crypto+ipsec+sa',
                ip: ip
            },
            success: function(result){
                $("#tunel").val(result);
            }
        });
    }

    function sacar_tunel_usado(){
        uidaruba=$("#uidaruba").val();
		ip_local=$("#ip_local").val();
		ping_site=$("#ping_site").val();
        p=$("#ip").val();
        $.ajax({
            url: "funciones/funciones.php",
            data: { 
                accion: 'comando',
                uidaruba: uidaruba,
                comando: 'show+datapath+session+table+'+ip_local+'+"|"+include+'+ping_site,
                ip: ip
            },
            success: function(result){
                $("#datapath").val(result);
            }
			
        });
		
    }    
    
    
    function sacar_vlans(){
        uidaruba=$("#uidaruba").val();
        p=$("#ip").val();
        $.ajax({
            url: "funciones/funciones.php",
            data: { 
                accion: 'comando',
                uidaruba: uidaruba,
                comando: 'show+vlan',
                ip: ip
            },
            success: function(result){
                $("#vlan").val(result);
            }
        });
    }    
  
    
    function sacar_datos_uplinks(){
        uidaruba=$("#uidaruba").val();
        p=$("#ip").val();
        $.ajax({
            url: "funciones/funciones.php",
            data: { 
                accion: 'uplinks',
                uidaruba: uidaruba,
                ip: ip
            },
            success: function(result){
                $("#uplink").val(result);
            }
        });
    }    

	
	function getUserIP(onNewIP) { //  onNewIp - your listener function for new IPs
		//compatibility for firefox and chrome
		var myPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
		var pc = new myPeerConnection({
			iceServers: []
		}),
		noop = function() {},
		localIPs = {},
		ipRegex = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/g,
		key;

		function iterateIP(ip) {
			if (!localIPs[ip]) onNewIP(ip);
			localIPs[ip] = true;
		}

		 //create a bogus data channel
		pc.createDataChannel("");

		// create offer and set local description
		pc.createOffer(function(sdp) {
			sdp.sdp.split('\n').forEach(function(line) {
				if (line.indexOf('candidate') < 0) return;
				line.match(ipRegex).forEach(iterateIP);
			});

			pc.setLocalDescription(sdp, noop, noop);
		}, noop); 

		//listen for candidate events
		pc.onicecandidate = function(ice) {
			if (!ice || !ice.candidate || !ice.candidate.candidate || !ice.candidate.candidate.match(ipRegex)) return;
			ice.candidate.candidate.match(ipRegex).forEach(iterateIP);
		};
	}


    
    var uidaruba=$("#uidaruba").val();
    if(uidaruba==''){
		getUserIP(function(ip){
			$("#ip_local").val(ip);
		});	
        conexion();
    }

    
	var graficaa = new Highcharts.Chart({
		chart: {
					renderTo: 'grafica',
					type: 'spline',
					marginRight: 10,
					height: 300,
				},
		credits: {
			enabled: false
		},
				title: {
					text: 'RTT'
				},
				xAxis: {
					type: 'datetime',
					tickPixelInterval: 150
				},
				yAxis: {
					min:0,
					title: {
						text: 'ms'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}]
				},
				tooltip: {
					formatter: function() {
							return '<b>'+ this.series.name +'</b><br/>'+
							Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+
							Highcharts.numberFormat(this.y, 2);
					}
				},
				legend: {
					enabled: false
				},
				exporting: {
					enabled: false
				},
				series: [{
					name: '',
					data: []
				}]
	});

    
	var grafica_ping = new Highcharts.Chart({
		chart: {
			renderTo: 'grafica_ping',
			type: 'spline',
			marginRight: 10,
			height: 300,
		},
		credits: {
			enabled: false
		},
				title: {
					text: 'Ping'
				},
				xAxis: {
					type: 'datetime',
					tickPixelInterval: 150
				},
				yAxis: {
					min:0,
					title: {
						text: 'ms'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}]
				},
				tooltip: {
					formatter: function() {
							return '<b>'+ this.series.name +'</b><br/>'+
							Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+
							Highcharts.numberFormat(this.y, 2);
					}
				},
				legend: {
					enabled: false
				},
				exporting: {
					enabled: false
				},
				series: [{
					name: 'Ping',
					data: []
				}]
	});
});