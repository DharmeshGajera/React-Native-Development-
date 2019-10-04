<?php 
    $usuario = Utiles::obtenerUsuarioLogueado();
?>
<!-- top header -->
<header class="header header-fixed navbar">

    <div class="brand">
        <!-- toggle offscreen menu -->
        <a href="javascript:;" class="ti-menu off-left visible-xs" data-toggle="offscreen" data-move="ltr"></a>
        <!-- /toggle offscreen menu -->

        <!-- logo -->
			<a href="index.php" class="navbar-brand">
                Club de Embajadores
				<!--<img src="img/accentureWhite.png" alt="" style="width: 70%">-->
			</a>
        <!-- /logo -->
    </div>

       <ul class="nav navbar-nav navbar-right">

        <li class="off-right">
            <a href="javascript:;" data-toggle="dropdown">
                <img src="img/faceless.jpg" class="header-avatar img-circle" alt="user" title="user">
                <span class="hidden-xs ml10"><?php echo $usuario->nombre . ' ' . $usuario->apellido; ?></span>
                <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu animated fadeInRight">
                <li>
                    <a href="javascript:cambiarClave();">Cambiar Contrase&ntilde;a</a>
                </li>
                <li>
                    <a href="javascript:logout();">Logout</a>
                </li>
            </ul>
        </li>
    </ul>
</header>
<!-- /top header -->