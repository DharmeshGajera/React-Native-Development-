<!doctype html>
<html class="signin no-js" lang="">

<head>
    <!-- meta -->
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <!-- /meta -->
    <link rel="shortcut icon" href="img/flechaAccenture.png" />

    <title>Bienvenidos - Club de Embajadores</title>

    <!-- page level plugin styles -->
    <link rel="stylesheet" href="plugins/chosen/chosen.min.css">
    <link rel="stylesheet" href="plugins/datatables/jquery.dataTables.css">
    <!-- /page level plugin styles -->

    <!-- core styles -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <!-- /core styles -->

    <!-- template styles -->
    <link rel="stylesheet" href="css/skins/palette.css">
    <link rel="stylesheet" href="css/fonts/font.css">
    <link rel="stylesheet" href="css/main.css">
    <!-- template styles -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- load modernizer -->
    <script src="plugins/modernizr.js"></script>
    
    <!-- JS Libs -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="plugins/jquery-1.11.1.min.js"><\/script>')</script>
    
	<!-- msgbox -->	
    <script type="text/javascript" src="js/msgbox/jquery.msgbox.min.js"></script>
	<link href="js/msgbox/jquery.msgbox.css" rel="stylesheet" type="text/css" />
</head>

<body class="bg-primary">

    <div class="cover" style="background-image: url(img/cover3.jpg)"></div>

    <div class="overlay bg-primary"></div>

    <div class="center-wrapper">
	
        <div class="center-content">
			<div class="row" style="height:80px;">
                <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 text-center">
					<!--<a href="index.html" class="navbar-brand">-->
					<p style="font-size: 45px">
						Club de Embajadores
					</p>
				</div>
				
			</div>
			<br/><br/>
            <div class="row">
			
                <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
				
                    <section class="panel bg-white no-b">
                        <ul class="switcher-dash-action">
                            <li id="loginTab" class="active"><a href="javascript:loginView();">Login</a></li>
                            <li id="olvidoTab"><a href="javascript:olvidoView();">Olvidé Contraseña</a></li>
                        </ul>
                        <div class="p15">  
                            <form role="form" action="javascript:void(1);" id="frm">
                            	<input type="hidden" name="accion" id="accion" value="login" />
                                <input name="usuario" id="usuario" type="text" class="form-control input-lg mb25" placeholder="Email" autofocus>
                                <input name="clave" clave="clave" type="password" class="form-control input-lg mb25" placeholder="Contrase&ntilde;a">
                                
                                <button class="btn btn-primary btn-lg btn-block" onclick="javascript:login();">Entrar</button>
                            </form>
                            <form role="form" action="javascript:void(1);" id="frm2" style="display: none;">
                                <input type="hidden" name="accion" id="accion" value="recuperar_clave" />
                                <div style="text-align: center; margin-bottom: 20px;">
                                    <span>Recibirás un email con las instrucciones para recuperar tu contraseña</span>
                                </div>
                                <input name="email" id="email" type="text" class="form-control input-lg mb25" placeholder="Email" autofocus>
                                <button class="btn btn-primary btn-lg btn-block" onclick="javascript:recuperar_clave();">Envíar</button>
                            </form>
                        </div>
                    </section>
                    <!--<p class="text-center">
                        Creado por - 
                        <a href="https://www.accenture.com/" target="_blank"><span>Club de Embajadores</span></a>
                    </p>-->
                </div>
            </div>
        
        </div>
    </div>
    
    <div class="cargando">
		<img src="img/ajax_loading_bar.gif" alt="Cargando..." /><br/>
	</div>
		
    <script type="text/javascript">
        var el = document.getElementById("year"),
            year = (new Date().getFullYear());
        el.innerHTML = year;

        function loginView() {
            $("#loginTab").addClass("active");
            $("#olvidoTab").removeClass("active");
            $("#frm").css("display", "block");
            $("#frm2").css("display", "none");
        }

        function olvidoView() {
            $("#loginTab").removeClass("active");
            $("#olvidoTab").addClass("active");
            $("#frm2").css("display", "block");
            $("#frm").css("display", "none");
        }

        function login() {
			$.ajax({
				async:true,
				type: "POST",
				url: "controller/login-controller.php",
				data: $('#frm').serialize(),
				beforeSend:function(){
					startLoading();
				},
				success:function(datos) {
					if (datos == '') {
						window.location = "index.php";
					} else {
						completeLoading();
						$.msgbox(datos, {type: "alert"});
					}
					return true;					
				},
				timeout:8000,
				error:function(){
					completeLoading();
					$.msgbox('Error al iniciar sesion', {type: "error"});
					return false;
				}
			});
		}

        function recuperar_clave() {
            $.ajax({
                async:true,
                type: "POST",
                url: "controller/login-controller.php",
                data: $('#frm2').serialize(),
                beforeSend:function(){
                    startLoading();
                },
                success:function(datos) {
                    if (datos == '') {
                        alert('Mensaje enviado exitosamente!');
                        window.location = "index.php";
                    } else {
                        completeLoading();
                        $.msgbox(datos, {type: "alert"});
                    }
                    return true;                    
                },
                timeout:8000,
                error:function(){
                    completeLoading();
                    $.msgbox('Error al Recuperar Clave', {type: "error"});
                    return false;
                }
            });
        }

        function startLoading() {
			$('.cargando').toggle();
			return true;
		}

        function completeLoading() {
			$('.cargando').hide();
			return true;
		}
		
    </script>
</body>

</html>
