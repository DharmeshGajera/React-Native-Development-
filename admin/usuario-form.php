<?php 
include_once 'utiles/Utiles.php';
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/RolDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/UsuarioDao.php');

Utiles::ValidarSesionIniciada();
$listcategorias = RolDao::listActivos();

$tienePermiso = (isset($_GET['id']) && $_GET['id'] > 0 ) ? Utiles::validarPermisos("usuarios", "modificar") : Utiles::validarPermisos("usuarios", "agregar");
if ($tienePermiso) {
	
	include_once 'view/usuario-form.php';
	
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$accion = "editar";
		$view = new usuario_form($_GET['id']);
	} else {
		$accion = "nuevo";
		$view = new usuario_form(0);
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
                                <h5><?php echo ((isset($_GET['id'])) ? "Editar" : "Nuevo"); ?> <b>Usuario</b></h5>
                            </header>
						</section>
                                
						<?php if ($tienePermiso) {?>
                                
						<div class="row">
                            <div class="col-lg-9">
                                <section class="panel">
                                    <header class="panel-heading">Datos del <strong>Usuario</strong></header>
                                    <div class="panel-body">
                                    
                                    	<div id="mensajes-error">
										</div>

                                        <form class="form-horizontal" action="javascript:void(1);" id="frm">
                                        	<input type="hidden" name="id" id="id" value="<?php echo $view->item->id; ?>"/>
											<input type="hidden" name="accion" id="accion" value="<?php echo $accion; ?>"/>
											<input type="hidden" name="token" id="token" value="<?php echo Utiles::obtenerToken(); ?>"/>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Nombre *</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $view->item->nombre; ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Apellido *</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="apellido" name="apellido" class="form-control" value="<?php echo $view->item->apellido; ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Email *</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="email" name="email" class="form-control" value="<?php echo $view->item->email; ?>" />
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label class="col-sm-2 control-label">Categoria del usuario *</label>
                                                <div class="col-sm-10">
																																		
												<select class="form-control" id="id_rol" name="id_rol">
                                                    <?php
														foreach ($listcategorias as $categoria)
														{
															?>
															<option <?php if(isset($_GET['id'])){if($categoria->id == UsuarioDao::get($_GET['id'])->id_rol){echo "selected";}} ?> value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre;?></option>
															<?php
														}
													?>													
												<select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Nombre de Usuario *</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control" value="<?php echo $view->item->nombre_usuario; ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" id="imagenChange" name="imagenChange" value="0"/>
                                                <label class="col-sm-2 control-label">Foto *</label>
                                                <div class="col-sm-8">
                                                    <input id="fileupload" type="file" name="fileupload[]" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">&nbsp;</label>
                                                <div id="progress" class="col-sm-8 progress">
                                                    <div class="progress-bar progress-bar-success" id="fileupload-progres"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">&nbsp;</label>
                                                <div class="col-sm-10">
                                                    <table id="tabla-imagenes" class="table table-hover no-m">
                                                        <tbody>
                                                            <?php 
                                                            if ($view->item->archivo != '' && $view->item->foto != '') { 
                                                                $ext = explode(".", $view->item->archivo);

                                                                echo '
                                                            <tr id="' . $ext[0] . '">
                                                                <td><img src="/archivos/' . $view->item->archivo . '" width="70px" height="70px" /></td>
                                                                <td>' . $view->item->foto . '</td>
                                                                <td><button onclick="javascript:eliminarimg(' . $ext[0] . ');" type="button" class="btn btn-danger btn-sm mr5" title="Quitar Foto"><i class="fa fa-trash"></i> </button></td>
                                                            </tr>
                                                                ';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php if ($accion == 'nuevo') { ?>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Contrase&ntilde;a *</label>
                                                <div class="col-sm-10">
                                                    <input type="password" id="clave" name="clave" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Repetir contrase&ntilde;a *</label>
                                                <div class="col-sm-10">
                                                    <input type="password" id="repetir" name="repetir" class="form-control" />
                                                </div>
                                            </div>
                                            <?php 
                                            }
                                            ?>
                                            <br/><br/>
                                            <header class="panel-heading"><strong>Redes Sociales</strong> del usuario</header>
                                            <div class="panel-body">
                                                <?php
                                                $contador = 0;
                                                foreach ($view->redes as $red_social) {
                                                    ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label"><?php echo $red_social->nombre ?></label>
                                                        <div class="col-sm-10">
                                                            <?php $nombre = $red_social->nombre ?>
                                                            <input type="text" id="<?php echo $red_social->nombre ?>" name="<?php echo $red_social->nombre ?>" class="form-control" value="<?php echo (isset($view->usuario_redsocial[$contador])) ? $view->usuario_redsocial[$contador]->link : '' ?>" />
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $contador += 1;
                                                }
                                                ?>
                                            </div>
                                            <br/><br/>
                                            <header class="panel-heading"><strong>Intereses</strong> del usuario</header>
                                            <div class="panel-body">
                                                <?php
                                                $contador = 0;
                                                foreach ($view->intereses as $interes) {
                                                    if ($interes->nombre == 'Accenture' && $accion == 'nuevo') {
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label"><?php echo $interes->nombre ?></label>
                                                            <label class="switch switch-label switch-pill switch-primary">
                                                                <input class="switch-input" type="checkbox" value="1" id="<?php echo $interes->nombre ?>" name="<?php echo $interes->nombre ?>" checked >
                                                                <span class="switch-slider" data-checked="&#x2713;" data-unchecked="&#x2715;"></span>
                                                            </label>
                                                        </div>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label"><?php echo $interes->nombre ?></label>
                                                            <label class="switch switch-label switch-pill switch-primary">
                                                                <input class="switch-input" type="checkbox" value="1" id="<?php echo $interes->nombre ?>" name="<?php echo $interes->nombre ?>" <?php echo (isset($view->usuario_interes[$contador])) ? ($view->usuario_interes[$contador]->checked == 1 ? 'checked' : '') : '' ?> >
                                                                <span class="switch-slider" data-checked="&#x2713;" data-unchecked="&#x2715;"></span>
                                                            </label>
                                                        </div>
                                                        <?php
                                                        $contador += 1;
                                                    }
                                                }
                                                ?>
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
                                                <input type="text" disabled="disabled" class="form-control" value="<?php echo (($view->item->creado_fecha != '') ? date("d/m/Y H:i:s", strtotime($view->item->creado_fecha)) : ''); ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Creado por:</label>
                                                <input type="text" disabled="disabled" class="form-control" value="<?php echo $view->item->creado_por > 0 ? $view->item->getCreado()->nombre . ' ' . $view->item->getCreado()->apellido : ''; ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Ultima modificaci&oacute;n:</label>
                                                <input type="text" disabled="disabled" class="form-control" value="<?php echo (($view->item->modificado_fecha != '') ? date("d/m/Y H:i:s", strtotime($view->item->modificado_fecha)) : ''); ?>" />
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
    
    <script type="text/javascript">
    function guardar() {
    	$.ajax({
			async:true,
			type: "POST",
			url: "controller/usuario-controller.php",
			data: $('#frm').serialize() + "&imagenes=" + JSON.stringify(imagenes),
			beforeSend:function(){
    			startLoading();
			},
			success:function(datos) {
				if (datos == '') {					
					window.location="usuario-listado.php";
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
    	window.location="usuario-listado.php";
    }
    </script>

    <!-- Upload -->
    <script src="plugins/upload/jquery.ui.widget.js"></script>
    <script src="plugins/upload/jquery.iframe-transport.js"></script>
    <script src="plugins/upload/jquery.fileupload.js"></script>
    
    <script>
    var imagenes = [];

    var jsonImagenes = '<?php echo $view->jsonImagenes; ?>';
    imagenes = JSON.parse(jsonImagenes)
    
    if (imagenes.length > 0) {
        $("#fileupload").attr("disabled", true);
    }
    
    $(function () {
        'use strict';                
        
        // Call the fileupload widget and set some parameters
        $('#fileupload').fileupload({
            url: 'utiles/upload/files.php?nombre_input=fileupload',     
            dataType: 'json',
            beforeSend:function(){},
            done: function (e, data) {          
                $.ajax({
                    async:true,
                    type: "POST",
                    url: "utiles/upload/obtener-foto.php",                      
                    data: 'foto=fileupload&repo=files&recorte=1',
                    beforeSend:function(){},
                    success:function(datos) {
                        var imagen = JSON.parse(datos);                        
                        
                        imagenes.push(imagen);
                        
                        var linea = '<tr id="' + imagen.ref + '">';
                        linea += '<td><img src="/admin/temp/' + imagen.namecode + '" width="70px" height="70px" /></td>';
                        linea += '<td>' + imagen.name + '</td>';
                        linea += '<td><button onclick="javascript:eliminarimg(' + imagen.ref + ');" type="button" class="btn btn-danger btn-sm mr5" title="Quitar Imagen"><i class="fa fa-trash"></i> </button> ';                        

                        $("#tabla-imagenes tbody").append(linea);
                        $("#imagenChange").val(1);
                        $("#fileupload").prop('disabled', true);
                        
                        return true;                    
                    },
                    timeout:8000,
                    error:function(){
                        $.msgbox('Error al adjuntar el archivo', {type: "error"});
                        return false;
                    }
                });                                                                         

            },
            progressall: function (e, data) {
                // Update the progress bar while files are being uploaded
                var progress = parseInt(data.loaded / data.total * 100, 10);                
                $('#fileupload-progres').css(
                    'width',
                    progress + '%'
                );
            }
        });
    });

    function eliminarimg(ref) {

        startLoading();

        $("#" + ref).remove();
        
        imagenes.forEach(
            function eliminar(imagen) {
                if(imagen.ref == ref) {
                    if (imagen.id == 0) {
                        $.ajax({
                            async:true,
                            type: "POST",
                            url: "utiles/upload/eliminar-upload.php",
                            data: "file=" + imagen.namecode + '&place=' + imagen.place,
                            beforeSend:function(){},
                            success:function(datos) {               
                                return true;                    
                            },
                            timeout:8000,
                            error:function(){
                                $.msgbox('Error al eliminar la imagen', {type: "error"});
                                return false;
                            }
                        });
                    }
                    else{
                        $("#imagenChange").val(1);
                    }
                    
                    var pos = imagenes.indexOf(imagen);
                    imagenes.splice(pos, 1);

                }
            }
        );
        
        $("#fileupload").attr("disabled", false);
         $('#fileupload-progres').css(
                    'width',
                    0 + '%'
                );      

        completeLoading();
    
    }    
        
    </script>

</body>
<!-- /body -->

</html>

