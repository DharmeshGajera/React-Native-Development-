<?php 
include_once 'utiles/Utiles.php';
?>

<div class="row">

	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">Modificar <strong>contrase&ntilde;a</strong></header>
			<div class="panel-body">
			
				<div id="mensajes-error-clave">
				</div>
				
				<form class="form-horizontal" action="javascript:void(1);" id="frm-clave">
					<input type="hidden" name="id" id="id" value="<?php echo ((isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : Utiles::obtenerIdUsuarioLogueado()); ?>" />
					<input type="hidden" name="accion" id="accion" value="modificar-clave" />
					<input type="hidden" name="token" id="token" value="<?php echo Utiles::obtenerToken(); ?>" />
					<div class="form-group">
						<label class="col-sm-5 control-label">Contrase&ntilde;a *</label>
						<div class="col-sm-7">
							<input type="password" id="clave" name="clave" class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 control-label">Repetir contrase&ntilde;a *</label>
						<div class="col-sm-7">
							<input type="password" id="repetir" name="repetir" class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button onclick="javascript:guardar();" class="btn btn-primary"><i class="fa fa-plus"></i> Guardar</button>
							<button onclick="javascript:cancelar();" class="btn btn-color"><i class="fa fa-close"></i> Cancelar</button>
						</div>
					</div>
				</form>
			</div>
		</section>
	</div>
</div>

<script>

$("#clave").focus();

function cancelar() {
	$.lightbox().close();
}

function guardar() {
	$.ajax({
		async:true,
		type: "POST",
		url: "controller/usuario-controller.php",
		data: $('#frm-clave').serialize(),
		beforeSend:function(){
			startLoading();
		},
		success:function(datos) {
			if (datos == '') {
				$.lightbox().close();
				completeLoading();
			} else {
				completeLoading();
				$('#mensajes-error-clave').html(datos);
				location.hash = 'mensajes-error-clave';
			}
			return true;					
		},
		timeout:8000,
		error:function(){
			completeLoading();
			$.msgbox('Error al modificar la contrase&ntilde;a', {type: "error"});
			return false;
		}
	});
}

</script>