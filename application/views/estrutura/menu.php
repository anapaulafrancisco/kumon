<?php

    $arrCredencial = get_credencial(); 
	//$arrCategorias = getSubMenuCategorias();
	//$arrRelatorios = getSubMenuRelatorios();
	$arrPerfilNome = explode(',', $arrCredencial['perfis_nomes']);

	$fotoPerfil = 'foto_padrao.png';

	if(strlen(trim($arrCredencial['foto'])) > 0)
	{
		$fotoPerfil = trim($arrCredencial['foto']);
    }
 
?> 

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
            <!--aqui estava o esquema do menu de notificacoes-->
          
            <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo base_url('assets/uploads/perfil/') . $fotoPerfil; ?>" class="user-image" alt="Foto Usuário">
                        
                        <span class="hidden-xs"><?php echo $arrCredencial['nome_usuario']; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo base_url('assets/uploads/perfil/') . $fotoPerfil; ?>" class="img-circle" alt="Foto Usuário">
                            <p>
                                <?php echo $arrCredencial['nome_usuario'] . ' - '. ucfirst($arrCredencial['perfis_nomes']); ?>
                                <small><?php echo $arrCredencial['email']; ?></small>
                            </p>
                        </li>
                        
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo base_url('usuario/configuracao'); ?>" class="btn btn-default btn-flat">Configuração</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo base_url('login/logout'); ?>" class="btn btn-default btn-flat">Sair</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Menu</li>

          
            <li <?php echo $this->uri->segment(1) == 'home' ? "class='active'" : "" ?>><a href="<?php echo base_url('home'); ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            
            <?php if(!in_array('aluno', $arrPerfilNome)): ?>
                <li <?php echo $this->uri->segment(1) == 'curso' ? "class='active'" : "" ?>><a href="<?php echo base_url('curso/gerenciar'); ?>"><i class="fa fa-folder-open"></i> <span>Curso</span></a></li>
            <?php endif; ?>
            
            <?php if(!in_array('aluno', $arrPerfilNome)): ?>
                <li <?php echo $this->uri->segment(1) == 'unidade' ? "class='active'" : "" ?>><a href="<?php echo base_url('unidade/editar'); ?>"><i class="fa fa-home"></i> <span>Unidade</span></a></li>
            <?php endif; ?>
            
           <?php if(!in_array('aluno', $arrPerfilNome)): ?>
                <li <?php echo $this->uri->segment(1) == 'pessoa' ? "class='active'" : "" ?>><a href="<?php echo base_url('pessoa/gerenciar'); ?>"><i class="fa fa-graduation-cap"></i> <span>Pessoa</span></a></li>
            <?php endif; ?>

            <?php if(!in_array('aluno', $arrPerfilNome)): ?>
                <li <?php echo $this->uri->segment(1) == 'aluno' ? "class='active'" : "" ?>><a href="<?php echo base_url('aluno/gerenciar');?>"><i class="fa fa-user"></i> <span>Aluno</span></a></li>
            <?php endif; ?>

            <?php if(!in_array('aluno', $arrPerfilNome)): ?>
                <li <?php echo $this->uri->segment(1) == 'matricula' ? "class='active'" : "" ?>><a href="<?php echo base_url('matricula/gerenciar');?>"><i class="fa fa-book"></i> <span>Matrícula</span></a></li>
            <?php endif; ?>

            <?php if(!in_array('aluno', $arrPerfilNome)): ?>
                <li <?php echo $this->uri->segment(1) == 'progresso' ? "class='active'" : "" ?>><a href="<?php echo base_url('progresso/gerenciar');?>"><i class="fa fa-edit"></i> <span>Progresso Estudo</span></a></li>
            <?php endif; ?>

            <?php if(!in_array('aluno', $arrPerfilNome)): ?>
                <li <?php echo $this->uri->segment(1) == 'horario' ? "class='active'" : "" ?>><a href="<?php echo base_url('horario/gerenciar');?>"><i class="fa fa-clock-o"></i> <span>Horários</span></a></li>
            <?php endif; ?>
             
           <?php $infoPath = $this->uri->segment(1) . '/' . $this->uri->segment(2); ?>

            <li class="treeview <?php echo $this->uri->segment(1) == 'relatorio' ? "class=' active menu-open'" : "" ?>">
                <a>
                    <i class="fa fa-pie-chart"></i> <span>Relatórios</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li <?php echo $infoPath == 'relatorio/gerenciar' ? "class='active'" : "" ?>><a href="<?php echo base_url('relatorio/gerenciar');?>"><i class="fa fa-circle-o"></i> Histórico estudo</a></li>
                    
                    <?php if(!in_array('aluno', $arrPerfilNome)): ?>
                        <li <?php echo $infoPath == 'relatorio/aluno' ? "class='active'" : "" ?>><a href="<?php echo base_url('relatorio/aluno');?>"><i class="fa fa-circle-o"></i> Saldo de alunos</a></li>
                    <?php endif; ?>  
                </ul>
            </li>
           
            <?php //if(in_array('implementador', $arrPerfilNome)  || in_array('orientador', $arrPerfilNome) || in_array('auxiliar', $arrPerfilNome)): ?>
            <?php if(!in_array('aluno', $arrPerfilNome)): ?>
                <li <?php echo $this->uri->segment(1) == 'usuario' ? "class='active'" : "" ?>><a href="<?php echo base_url('usuario/gerenciar');?>"><i class="fa fa-users"></i> <span>Usuário Sistema</span></a></li>
            <?php endif; ?>

        </ul>
        <!-- sidebar menu: : style can be found in sidebar.less -->
    </section>
    <!-- /.sidebar -->
</aside>