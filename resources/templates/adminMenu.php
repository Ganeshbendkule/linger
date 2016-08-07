<nav class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed"
				data-toggle="collapse" data-target="#menu-navbar-collapse"
				aria-expanded="false">
				<span class="sr-only">Toggle navigation</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo $baseURL;?>">The Linger</a>
			<a class="navbar-brand" href="<?php echo $baseURL;?>admin">Admin</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="menu-navbar-collapse">
			<ul class="nav navbar-nav navbar-left">
				<li><a href="<?php echo $baseURL;?>admin/events/">Events</a></li>
				<li><a href="<?php echo $baseURL;?>admin/photos/">Photos</a></li>
				<li><a href="<?php echo $baseURL;?>admin/menu/">Menu</a></li>
				<li><a href="<?php echo $baseURL;?>admin/users/">Users</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown" >
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hello <?php if(!empty($_SESSION['user'])){echo $_SESSION['user']['username'];}?> <span class="caret"></span></a>
		          <ul class="dropdown-menu" style="background-color:foralwhite;">
			        <li><a href="<?php echo $baseURL;?>admin/login/logout.php">Sign out</a></li>
		          </ul>
		        </li>
	        </ul>
		</div>
			
		<!--this is all the options in the dropdown menu-->
	</div>

</nav>