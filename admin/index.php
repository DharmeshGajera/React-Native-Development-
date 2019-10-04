<?php 
include_once 'utiles/Utiles.php';

Utiles::ValidarSesionIniciada();

include_once 'view/home-form.php';
$view = new home_form();
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
                <div class="row">
                    <div class="col-md-12" style="text-align: center; margin-top: 20px">





                        <div class="container-fluid">
                          <div class="animated fadeIn">
                            <div class="row">
                              <div class="col-sm-4 col-lg-4">
                                <div class="card text-white bg-success">
                                  <div class="card-body pb-0">
                                    <button class="btn btn-transparent p-0 float-right" type="button">
                                      <i class="icon-location-pin"></i>
                                    </button>
                                    <div class="text-value"><?php echo count($view->embajadores); ?></div>
                                    <div class="title-value">Embajadores</div>
                                  </div>
                                  <div class="chart-wrapper mt-3 mx-3" style="height:50px;">
                                    <canvas class="chart" id="card-chart2" height="70"></canvas>
                                  </div>
                                </div>
                              </div>
                              <!-- /.col-->
                              <div class="col-sm-4 col-lg-4">
                                <div class="card text-white bg-warning">
                                  <div class="card-body pb-0">
                                    <div class="text-value"><?php echo count($view->asistentes); ?></div>
                                    <div class="title-value">Asistentes</div>
                                  </div>
                                  <div class="chart-wrapper mt-3" style="height:50px;">
                                    <canvas class="chart" id="card-chart3" height="70"></canvas>
                                  </div>
                                </div>
                              </div>
                              <!-- /.col-->
                              <div class="col-sm-4 col-lg-4">
                                <div class="card text-white bg-danger">
                                  <div class="card-body pb-0">
                                    <div class="text-value"><?php echo count($view->administradores); ?></div>
                                    <div class="title-value">Administradores</div>
                                  </div>
                                  <div class="chart-wrapper mt-3 mx-3" style="height:50px;">
                                    <canvas class="chart" id="card-chart4" height="70"></canvas>
                                  </div>
                                </div>
                              </div>
                              <!-- /.col-->
                            </div>
                            <!-- /.row-->
                            <div class="card">
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-sm-5" style="text-align: left;">
                                    <h3 class="">Tráfico en la APP</h4>
                                    <div class="small text-muted">Agosto 2019</div>
                                  </div>
                                  <!-- /.col-->
                                  <div class="col-sm-7 d-none d-md-block">
                                    <div class="btn-group btn-group-toggle float-right mr-3" data-toggle="buttons">
                                      <label class="btn btn-outline-secondary">
                                        <input id="option1" type="radio" name="options" autocomplete="off"> Dia
                                      </label>
                                      <label class="btn btn-outline-secondary active">
                                        <input id="option2" type="radio" name="options" autocomplete="off" checked=""> Mes
                                      </label>
                                      <label class="btn btn-outline-secondary">
                                        <input id="option3" type="radio" name="options" autocomplete="off"> Año
                                      </label>
                                    </div>
                                  </div>
                                  <!-- /.col-->
                                </div>
                                <!-- /.row-->
                                <div class="chart-wrapper" style="height:300px;margin-top:40px;">
                                  <canvas class="chart" id="main-chart" height="300"></canvas>
                                </div>
                              </div>
                            </div>
                            <!-- 
                            <div class="row">
                              <div class="col-sm-6 col-lg-3">
                                <div class="brand-card">
                                  <div class="brand-card-header bg-facebook">
                                    <i class="fa fa-facebook"></i>
                                    <div class="chart-wrapper">
                                      <canvas id="social-box-chart-1" height="90"></canvas>
                                    </div>
                                  </div>
                                  <div class="brand-card-body">
                                    <div>
                                      <div class="title-value">0</div>
                                      <div class="text-uppercase text-muted small">Embajadores</div>
                                    </div>
                                    <div>
                                      <div class="title-value">0</div>
                                      <div class="text-uppercase text-muted small">Asistentes</div>
                                    </div>
                                    <div>
                                      <div class="title-value">0</div>
                                      <div class="text-uppercase text-muted small">Admin</div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <div class="col-sm-6 col-lg-3">
                                <div class="brand-card">
                                  <div class="brand-card-header bg-twitter">
                                    <i class="fa fa-twitter"></i>
                                    <div class="chart-wrapper">
                                      <canvas id="social-box-chart-2" height="90"></canvas>
                                    </div>
                                  </div>
                                  <div class="brand-card-body">
                                    <div>
                                      <div class="title-value">0</div>
                                      <div class="text-uppercase text-muted small">Embajadores</div>
                                    </div>
                                    <div>
                                      <div class="title-value">0</div>
                                      <div class="text-uppercase text-muted small">Asistentes</div>
                                    </div>
                                    <div>
                                      <div class="title-value">0</div>
                                      <div class="text-uppercase text-muted small">Admin</div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <div class="col-sm-6 col-lg-3">
                                <div class="brand-card">
                                  <div class="brand-card-header bg-linkedin">
                                    <i class="fa fa-linkedin"></i>
                                    <div class="chart-wrapper">
                                      <canvas id="social-box-chart-3" height="90"></canvas>
                                    </div>
                                  </div>
                                  <div class="brand-card-body">
                                    <div>
                                      <div class="title-value">0</div>
                                      <div class="text-uppercase text-muted small">Embajadores</div>
                                    </div>
                                    <div>
                                      <div class="title-value">0</div>
                                      <div class="text-uppercase text-muted small">Asistentes</div>
                                    </div>
                                    <div>
                                      <div class="title-value">0</div>
                                      <div class="text-uppercase text-muted small">Admin</div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                              <div class="col-sm-6 col-lg-3">
                                <div class="brand-card">
                                  <div class="brand-card-header bg-google-plus">
                                    <i class="fa fa-google-plus"></i>
                                    <div class="chart-wrapper">
                                      <canvas id="social-box-chart-4" height="90"></canvas>
                                    </div>
                                  </div>
                                  <div class="brand-card-body">
                                    <div>
                                      <div class="title-value">0</div>
                                      <div class="text-uppercase text-muted small">Accenture</div>
                                    </div>
                                    <div>
                                      <div class="title-value">0</div>
                                      <div class="text-uppercase text-muted small">Asistentes</div>
                                    </div>
                                    <div>
                                      <div class="title-value">0</div>
                                      <div class="text-uppercase text-muted small">Admin</div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              -->
                            </div>
                            <!-- /.row-->
                            <div class="row">
                              <div class="col-md-12">
                                <div class="card">
                                  <div class="card-header">Ranking de Uso</div>
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-sm-12">
                                        <div class="row">
                                          <div class="col-sm-4">
                                            <div class="callout callout-info" style="text-align: left;">
                                              <div class="text-muted">Logueos de Usuarios</div>
                                              <div class="title-value"><?php echo $view->cantidad_logueos; ?></div>
                                              <div class="chart-wrapper">
                                                <canvas id="sparkline-chart-1" width="100" height="30"></canvas>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-sm-4">
                                            <div class="callout callout-warning" style="text-align: left;">
                                              <div class="text-muted">Contenido Mas Leído</div>
                                              <div class="title-value"><?php echo $view->contenidoTotalLeido; ?></div>
                                              <div class="chart-wrapper">
                                                <canvas id="sparkline-chart-3" width="100" height="30"></canvas>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-sm-4">
                                            <div class="callout callout-success" style="text-align: left;">
                                              <div class="text-muted">Contenido Mas Compartido</div>
                                              <div class="title-value"><?php echo $view->contenidoTotalCompartido; ?></div>
                                              <div class="chart-wrapper">
                                                <canvas id="sparkline-chart-4" width="100" height="30"></canvas>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <!-- /.row-->
                                        <hr class="mt-0">
                                      </div>
                                      <!-- /.col-->
                                      <div class="col-sm-6">
                                        <!-- /.row-->
                                        <?php
                                        foreach ($view->contenido as $contenido) {
                                          $porcentaje = $view->contenidoTotalLeido > 0 ? ($contenido->leido * 100) / $view->contenidoTotalLeido : 0;
                                          ?>
                                          <div class="progress-group">
                                            <div class="progress-group-header">
                                              <i class="icon-user progress-group-icon"></i>
                                              <div><?php echo $contenido->nombre ?></div>
                                              <div class="ml-auto font-weight-bold mr-2"><?php echo $contenido->leido ?></div>
                                              <div class="text-muted small">(<?php echo $porcentaje ?>%)</div>
                                            </div>
                                            <div class="progress-group-bars">
                                              <div class="progress progress-xs">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $porcentaje ?>%" aria-valuenow="<?php echo $porcentaje ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                              </div>
                                            </div>
                                          </div>
                                          <?php
                                        }
                                        ?>
                                      </div>
                                      <div class="col-sm-6">
                                        <?php
                                        foreach ($view->contenido as $contenido) {
                                          $porcentaje = $view->contenidoTotalCompartido > 0 ? ($contenido->compartido * 100) / $view->contenidoTotalCompartido : 0;
                                          ?>
                                          <div class="progress-group">
                                            <div class="progress-group-header align-items-end">
                                              <i class="icon-globe progress-group-icon"></i>
                                              <div><?php echo $contenido->nombre ?></div>
                                              <div class="ml-auto font-weight-bold mr-2"><?php echo $contenido->compartido ?></div>
                                              <div class="text-muted small">(<?php echo $porcentaje ?>%)</div>
                                            </div>
                                            <div class="progress-group-bars">
                                              <div class="progress progress-xs">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $porcentaje ?>%" aria-valuenow="<?php echo $porcentaje ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                              </div>
                                            </div>
                                          </div>
                                          <?php
                                        }
                                        ?>
                                      </div>
                                      <!-- /.col-->
                                    </div>
                                    <!-- /.row-->
                                    <br>
                                    <table class="table table-responsive-sm table-hover table-outline mb-0">
                                      <thead class="thead-light">
                                        <tr>
                                          <th class="text-center">
                                            <i class="icon-people"></i>
                                          </th>
                                          <th>Usuario</th>
                                          <th>Cantidad de Logueos</th>
                                          <th>Ultima Actividad</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php
                                        foreach ($view->lastFiveUsers as $usuario) {
                                          ?>
                                          <tr>
                                            <td class="text-center">
                                              <div class="avatar">
                                                <img class="img-avatar" style="width: 40px;height: 40px;" src="img/faceless.jpg">
                                              </div>
                                            </td>
                                            <td>
                                              <div><?php echo ($usuario->nombre);?> <?php echo ($usuario->apellido); ?></div>
                                              <div class="small text-muted">
                                                Registrado: <?php echo date("d/m/Y", strtotime($usuario->creado_fecha));?></div>
                                            </td>
                                            <td>
                                              <strong><?php echo ($usuario->cantidad_logueos);?></strong>
                                            </td>
                                            <td>
                                              <div class="small text-muted">Ultimo Login</div>
                                              <strong><?php echo ($usuario->fecha_ultimo_logueo);?></strong>
                                            </td>
                                          </tr>
                                          <?php
                                        }
                                        ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                              <!-- /.col-->
                            </div>
                            <!-- /.row-->
                          </div>
                        </div>

















                    </div>
                </div>

                <a class="exit-offscreen"></a>
            </section>
            <!-- /main content -->
        </section>

    </div>
    
    <div class="cargando">
		<img src="img/ajax_loading_bar.gif" alt="Cargando..." /><br/>
	</div>
	
	
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="plugins/jquery.slimscroll.min.js"></script>
    <script src="plugins/jquery.easing.min.js"></script>
    <script src="plugins/appear/jquery.appear.js"></script>
    <script src="plugins/jquery.placeholder.js"></script>
    <script src="plugins/fastclick.js"></script>
    
    <script src="plugins/chosen/chosen.jquery.min.js"></script>
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    
    <script src="js/offscreen.js"></script>
    <script src="js/main.js"></script>
    
    <script src="js/bootstrap-datatables.js"></script>
    <script src="js/datatables.js"></script>
    
    <script type="text/javascript">


    
    </script>

</body>
<!-- /body -->

</html>

