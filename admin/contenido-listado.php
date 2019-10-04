<?php
include_once 'utiles/Utiles.php';

Utiles::ValidarSesionIniciada();

$tienePermiso = Utiles::validarPermisos("usuarios", "consultar");

?>

<!doctype html>
<html class="no-js" lang="">

<head>
    <?php include_once 'include/scripts-header.php'; ?>
</head>

<!-- body -->

<body>
    <div class="app">
        <?php include_once 'include/header.php'; ?>

        <section class="layout">
           <?php include_once 'include/menu.php'; ?>

            <!-- main content -->
            <section class="main-content">

                <!-- content wrapper -->
                <div class="content-wrap">

                    <!-- inner content wrapper -->
                    <div class="wrapper">
                        <section class="panel panel-default">
                            <header class="panel-heading">
                                <h5>Listado de <strong>Contenidos</strong></h5>
                            </header>
                            
                            <?php if ($tienePermiso) {?>
                            
                            <div class="panel-body">
                            	<button onclick="nuevo();" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo Contenido</button>
                            	<br><br>
                                <div class="table-responsive no-border">
                                    <table id="tabla-listado" class="table table-bordered table-striped mg-t datatable">
                                        <thead>
                                            <tr>
                                                <th>Titulo</th>
                                                <th>Bajada</th>
                                                <th>Link</th>
                                                <th>Categoria</th>
                                                <th>Publicacion</th>
                                                <th>Actividad</th>
                                                <th>Compartir</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            
                            <?php } else { ?>
                        
	                        <div class="row">
	                            <div class="col-lg-12">
	                            	No tiene permisos para la operaci&oacute;n que desea realizar.
	                            </div>
							</div>
	                        
	                        <?php } ?>
                            
                        </section>
                    </div>
                    <!-- /inner content wrapper -->

                </div>
                <!-- /content wrapper -->
                
                <a class="exit-offscreen"></a>
            </section>
            <!-- /main content -->
        </section>

    </div>
    
    <div class="cargando">
		<img src="img/ajax_loading_bar.gif" alt="Cargando..." /><br/>
	</div>
	
	<!-- core scripts -->
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="plugins/jquery.slimscroll.min.js"></script>
    <script src="plugins/jquery.easing.min.js"></script>
    <script src="plugins/appear/jquery.appear.js"></script>
    <script src="plugins/jquery.placeholder.js"></script>
    <script src="plugins/fastclick.js"></script>
    <!-- /core scripts -->

    <!-- page level scripts -->
    <script src="plugins/chosen/chosen.jquery.min.js"></script>
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <!-- /page level scripts -->

    <!-- template scripts -->
    <script src="js/offscreen.js"></script>
    <script src="js/main.js"></script>
    <!-- /template scripts -->

    <!-- page script -->
    <script src="js/bootstrap-datatables.js"></script>
<!--    <script src="js/datatables.js"></script>-->
    <!-- /page script -->
    
    <script>
    
    var demoDataTables = function () {
        return {
            init: function () {
                $('.datatable').dataTable({
                    "ajax": "view/contenido-listado.php?token=" + usertoken,
                    "sPaginationType": "bootstrap"
                });

                $('.chosen').chosen({
                    width: "80px"
                });
            }
        };
    }();

    $(function () {
        "use strict";
        demoDataTables.init();
    });

    function editar(id) {
    	window.location="contenido-form.php?id=" + id;
    }

    function eliminar(id) {
    	$.msgbox("Desea eliminar el registro seleccionado?", {
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
					url: "controller/contenido-controller.php",
					data: "id=" + id + "&accion=eliminar&token=" + usertoken,
					beforeSend:function(){
						startLoading();
					},
					success:function(datos) {
						if (datos == '') {					
							window.location.reload(true);
						} else {
							$.msgbox(datos, {type: "alert"});
						}
						return true;					
					},
					timeout:8000,
					error:function(){
						$.msgbox('Error al eliminar el registro', {type: "error"});
						return false;
					}
				});
			}
		});
    }

    function nuevo() {
    	window.location="contenido-form.php";
    }

    function publish(id) {
        $.msgbox("Desea publicar el contenido seleccionado?", {
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
                    url: "controller/contenido-controller.php",
                    data: "id=" + id + "&accion=publish&token=" + usertoken,
                    beforeSend:function(){
                        //startLoading();
                    },
                    success:function(datos) {
                        if (datos == '') {                  
                            //window.location.reload(true);
                        } else {
                            $.msgbox(datos, {type: "alert"});
                        }
                        return true;                    
                    },
                    timeout:8000,
                    error:function(){
                        $.msgbox('Error al publicar el contenido', {type: "error"});
                        return false;
                    }
                });
            }
        });
    }
	
    </script>

</body>
<!-- /body -->

</html>