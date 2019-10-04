<?php 
include_once 'utiles/ValidarURLCambiarClave.php';

$tienePermiso = true;
if (isset($_GET['token']) && $_GET['token'] != '') {
    $validation = new usuario_clave_temp_form($_GET['token']);
    $tienePermiso = $validation->item ? true : false;
} else {
    $tienePermiso = false;
}
?>

<!doctype html>
<html class="signin no-js" lang="">

<head>
    <!-- meta -->
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <!-- /meta -->
    <link rel="shortcut icon" href="img/flechaAccenture.png" />

    <title>Recuperar Clave - Club de Embajadores</title>

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
                        <div class="p15">
                            <?php
                                if ($tienePermiso) {
                            ?>
                            <form role="form" action="javascript:void(1);" id="frm">
                            	<input type="hidden" name="accion" id="accion" value="updatePass" />
                                <input type="hidden" name="id" id="id" value="<?php echo $validation->item->id ?>" />
                                <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $validation->usuario[0]->id ?>" />
                                <input name="clave" clave="clave" type="password" class="form-control input-lg mb25" placeholder="Contrase&ntilde;a Nueva">
                                <input name="claveRepetida" clave="claveRepetida" type="password" class="form-control input-lg mb25" placeholder="Repetir Contrase&ntilde;a Nueva">
                                
                                <button class="btn btn-primary btn-lg btn-block" onclick="javascript:updatePass();">Guardar</button>
                            </form>
                            <?php
                                } else {
                            ?>
                            <p style="text-align: center; font-weight: bold; font-size: 18px;">No tiene permisos para realizar esta operación.</p>
                            <p style="text-align: center;">Puede que se haya vencido el plazo para realizar el cambio de contraseña o ingreso a una página incorrecta.</p>
                            <?php
                                }
                            ?>
                        </div>
                    </section>
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

        function updatePass() {
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
					$.msgbox('Error al actualizar clave', {type: "error"});
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
