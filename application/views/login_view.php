 <?php getCabecalho(); ?>
	 <!-- Animate.css -->
    <!-- <link href="<?php //echo base_url('template_admin/vendors/animate.css/animate.min.css'); ?>" rel="stylesheet">

    <style type="text/css">
    	.login_wrapper {
    		margin-top: 0% !important;
    	}

		
	input.error, textarea.error {
		background: #FAEDEC;
		border: 1px solid #E85445;
 	}

 	label.error{
 		color: #E74C3C;
 	}

 	
    </style> -->
</head>

	<body class="hold-transition login-page">
		<div class="login-box">

 	 		<div class="login-logo">
				<img src="<?php echo base_url('assets/imgs/logo_kumon_login.png'); ?>" alt="Kumon" title="Kumon" />
    			<!-- <a href="../../index2.html"><b>Admin</b>LTE</a> -->
  			</div>
			<!-- /.login-logo -->

			<div class="login-box-body">
				<p class="login-box-msg">Acessar sistema</p>
				 
				<?php echo Notificacao::getNotificacao(); ?>

				<form action="<?php echo base_url('login/autenticar'); ?>" method="post">
					<div class="form-group has-feedback">
						<input type="text" name="txtUsuario" class="form-control" placeholder="Usuário">
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" name="txtSenha" class="form-control" placeholder="Senha">
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
			</div>
			<!-- /.login-box-body -->
		</div>
		<!-- /.login-box -->
	</body>
</html>




