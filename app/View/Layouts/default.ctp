<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>

	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('kickstart');
		echo $this->Html->css('style');

		echo $this->Html->script('jquery');
		echo $this->Html->script('kickstart');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>

</head>
<body>
<div id="container" class="grid">
	<header>
		<div class="col_4 column">
			<h1><a href="<?php echo $this->webroot; ?>"><strong>Get</strong>Hired</a></h1>
		</div>

		<div class="col_6 column right welcome">
					<?php if(AuthComponent::user('id')): ?>
						<h6>Welcome <strong><?php echo $userData['username']; ?></strong></h6>
						<a href="<?php echo $this->webroot; ?>users/logout">Logout</a>
					<?php endif; ?>
		</div>


		<div class="col_2 column right">
			<form id="add_job_link" action="<?php echo $this->webroot; ?>jobs/add">
				<button class="large green"><i class="icon-plus"></i>Add Job</button>
			</form>
		</div>
	</header>
	
	<div class="col_12 column">
		<!-- Menu Horizontal -->
		<ul class="menu">
		<li <?php echo ($this->here == '/gethired/' || $this->here == '/gethired/jobs') ? 'class="current"' : '' ?>><a href="<?php echo $this->webroot; ?>"><i class="icon-home"></i> Home</a></li>
		<li <?php echo ($this->here == '/gethired/jobs/browse') ? 'class="current"' : '' ?>><a href="<?php echo $this->webroot; ?>jobs/browse"><i class="icon-desktop"></i> Browse Jobs</a></li>
		<li <?php echo ($this->here == '/gethired/users/register') ? 'class="current"' : '' ?>><a href="<?php echo $this->webroot; ?>users/register"><i class="icon-user"></i> Register</a></li>
		<li <?php echo ($this->here == '/gethired/users/login') ? 'class="current"' : '' ?>><a href="<?php echo $this->webroot; ?>users/login"><i class="icon-key"></i> Login</a></li>
		</ul>
	</div>
	
	
		
		<div class="col_12 column">

			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>

		</div>
		
		<div class="clearfix"></div>
		<footer>
			<p>Copyright @copy; 2014, JobFinds, All Rights Reserved</p>
		</footer>
</div> <!-- End Grid -->
</body>
</html>
