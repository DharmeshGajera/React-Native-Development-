<?php 
include_once 'utiles/Utiles.php';
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/RedesDao.php');

Utiles::ValidarSesionIniciada();

$tienePermiso = (isset($_GET['id']) && $_GET['id'] > 0 ) ? Utiles::validarPermisos("usuarios", "modificar") : Utiles::validarPermisos("usuarios", "agregar");

if ($tienePermiso) {
	
	include_once 'view/redes-form.php';
	
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$accion = "editar";
		$view = new redes_sociales_form($_GET['id']);
	} else {
		$accion = "nuevo";
		$view = new redes_sociales_form(0);
	}// if-else
	
}

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
                                <h5><?php echo ((isset($_GET['id'])) ? "Editar" : "Nueva"); ?> <b>Red Social</b></h5>
                            </header>
						</section>
                                
						<?php if ($tienePermiso) {?>
                                
						<div class="row">
                            <div class="col-lg-9">
                                <section class="panel">
                                    <header class="panel-heading">Datos de las <strong>Redes Sociales</strong></header>
                                    <div class="panel-body">
                                    
                                    	<div id="mensajes-error">
										</div>

                                        <form class="form-horizontal" action="javascript:void(1);" id="frm">
                                        	<input type="hidden" name="id" id="id" value="<?php echo $view->item->id; ?>"/>
											<input type="hidden" name="accion" id="accion" value="<?php echo $accion; ?>"/>
											<input type="hidden" name="token" id="token" value="<?php echo Utiles::obtenerToken(); ?>"/>
											<div class="form-group">
                                                <label class="col-sm-2 control-label">Nombre</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $view->item->nombre; ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button onclick="javascript:guardar();" type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                                                    <button onclick="javascript:volver();" class="btn btn-color"><i class="fa fa-arrow-left"></i> Volver</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </section>
                            </div>
                            
                            <div class="col-lg-3">
                                <section class="panel">
                                    <header class="panel-heading">Auditor&iacute;a</header>
                                    <div class="panel-body">

                                       <form role="form">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Fecha de creaci&oacute;n:</label>
                                                <input type="text" disabled="disabled" class="form-control" value="<?php echo (($view->item->creado_fecha != '') ? date("d/m/Y", strtotime($view->item->creado_fecha)) : ''); ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Creado por:</label>
                                                <input type="text" disabled="disabled" class="form-control" value="<?php echo $view->item->creado_por > 0 ? $view->item->getCreado()->nombre . ' ' . $view->item->getCreado()->apellido : ''; ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Ultima modificaci&oacute;n:</label>
                                                <input type="text" disabled="disabled" class="form-control" value="<?php echo (($view->item->modificado_fecha != '') ? date("d/m/Y", strtotime($view->item->modificado_fecha)) : ''); ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Creado por:</label>
                                                <input type="text" disabled="disabled" class="form-control" value="<?php echo $view->item->modificado_por > 0 ? $view->item->getModificado()->nombre . ' ' . $view->item->getModificado()->apellido : ''; ?>" />
                                            </div>
                                        </form>

                                    </div>
                                </section>
                            </div>
                        </div>
                        
                        <?php } else { ?>
                        
                        <div class="row">
                            <div class="col-lg-12">
                            	No tiene permisos para la operaci&oacute;n que desea realizar.
                            </div>
						</div>
                        
                        <?php } ?>
								
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
    <script src="js/datatables.js"></script>
    <!-- /page script -->

    <link type="text/css" rel="stylesheet" href="css/demo.css">
    <link type="text/css" rel="stylesheet" href="css/jquery-te-1.4.0.css">

    <!--<script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>-->
    <script type="text/javascript" src="js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
    <script>
    $('.jqte-test').jqte();
    </script>
    
    <script type="text/javascript">
    function guardar() {
    	$.ajax({
			async:true,
			type: "POST",
			url: "controller/redes-controller.php",
			data: $('#frm').serialize(),
			beforeSend:function(){
    			startLoading();
			},
			success:function(datos) {
				if (datos == '') {					
					window.location="redes-listado.php";
				} else {
					location.hash = '';
					completeLoading();
					$('#mensajes-error').html(datos);
					location.hash = 'mensajes-error';
				}
				return true;					
			},
			timeout:8000,
			error:function(){
				completeLoading();
				$.msgbox('Error al eliminar el registro', {type: "error"});
				return false;
			}
		});
    }
    
    function volver() {
    	window.location="redes-listado.php";
    }
    </script>
	
	</body>
<!-- /body -->

</html>

