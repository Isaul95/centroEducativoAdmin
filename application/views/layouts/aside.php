
        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar" >
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
      <?php
          $user=null;
          $student=2;
          $admin=1;
          $profesor=3;
          $user= $this->session->userdata("rol");
          // echo $user;
      ?>

                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header"><strong>OPCIONES DE MENU</strong></li>
                    <li>
                        <a href="<?php echo base_url();?>dashboard">
                            <i class="fa fa-home"></i> <span>Inicio</span>
                        </a>
                    </li>

<?php if($user==1):?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fas fa-balance-scale"></i> <span>Administración</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">

                          <li><a href="<?php echo base_url();?>Administrativos/GradosGrupos">
                            <i class="far fa-dot-circle"></i> Grado y grupos</a></li>

                          <li><a href="<?php echo base_url();?>Administrativos/Profesores">
                            <i class="far fa-dot-circle"></i> Maestros </a></li>

                          <li><a href="<?php echo base_url();?>Administrativos/Alumnos">
                                <i class="far fa-dot-circle"></i> Alumnos </a></li>
                        </ul>
                    </li>
<?php endif;?>


<?php if($user==1):?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fas fa-school"></i> <span>Datos Generales</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="<?php echo base_url();?>Administrativos/DatosEscuela">
                              <i class="far fa-dot-circle"></i> Escuela</a></li>
                        </ul>
                    </li>
<?php endif;?>


<?php if($user==1):?>
                    <li class="treeview">
                        <a href="#">
                            <i class="far fa-file-pdf"></i> <span>Reportes</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="<?php echo base_url();?>Administrativos/ReportesAlumnos">
                              <i class="far fa-dot-circle"></i> Alumnos</a></li>

                              <li><a href="<?php echo base_url();?>Administrativos/Constancias">
                              <i class="far fa-dot-circle"></i> Constancia Estudios</a></li>

                              <li><a href="<?php echo base_url();?>Administrativos/ReportesMaestros">
                              <i class="far fa-dot-circle"></i> Maestros</a></li>
                        </ul>
                    </li>
<?php endif;?>


<?php if($user==1):?>
                    <li class="treeview">
                      <a href="#">
                      <i class="fas fa-user-shield"></i> <span>Administrador</span>
                      <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                      </span>
                            </a>
                      <ul class="treeview-menu">
                      <li><a href="<?php echo base_url();?>administrador/usuarios"><i class="far fa-dot-circle"></i>  Usuarios</a></li>
                    <li><a href="<?php echo base_url();?>administrador/permisos"><i class="far fa-dot-circle"></i>  Permisos</a></li>
                                  </ul>
                </li>
<?php endif;?>


            </ul>
       </section>
    </aside>
