	<!-- meta -->
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <!-- /meta -->

    <title>Club de Embajadores</title>
    <link rel="shortcut icon" href="img/flechaAccenture.png" />

    <!-- page level plugin styles -->
    <link rel="stylesheet" href="plugins/chosen/chosen.min.css">
    <link rel="stylesheet" href="plugins/datatables/jquery.dataTables.css">
    <link rel="stylesheet" href="plugins/timepicker/jquery.timepicker.css">
    <link rel="stylesheet" href="plugins/bootstrap-colorpalette/bootstrap-colorpalette.css">
    <link rel="stylesheet" href="plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">
    <!-- /page level plugin styles -->

    <!-- core styles -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <!-- /core styles -->

    <!-- template styles -->
    <link rel="stylesheet" href="css/style.css">
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
	
	<script type="text/javascript" src="plugins/jquery.lightbox.js"></script>
	<link href="css/jquery.lightbox.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" src="plugins/jquery.autocomplete.js"></script>
	<link href="css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

	<script src="js/jscolor.js"></script>
	
	<!--<script src="js/pickers.js"></script>-->
</script>
	
	<script type="text/javascript">
		var usertoken = <?php echo Utiles::obtenerToken(); ?>;

		function logout() {
			$.msgbox("Desea salir del sistema?", {
					type: "confirm",
					buttons : [
						{type: "submit", value: "Si"},			
						{type: "cancel", value: "No"}
					]
			}, 
			function(result) {
				if (result) {
					$.ajax({
						async:true,
						type: "POST",
						url: "controller/login-controller.php",
						data: "accion=logout",
						beforeSend:function(){
							startLoading();
						},
						success:function(datos) {
							if (datos == '') {					
								window.location.reload(true);					
							} else {
								completeLoading();
								$.msgbox(datos, {type: "alert"});
							}
							return true;					
						},
						timeout:8000,
						error:function() {
							completeLoading();
							$.msgbox('Error al eliminar el registro', {type: "error"});
							return false;
						}
					});
				}
			});	
		}

		function cambiarClave() {
	    	URL = 'usuario-modificar-clave-form.php';

			$.lightbox(URL, {
				width   : 780,
				height  : 300
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