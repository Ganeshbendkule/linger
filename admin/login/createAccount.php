<?php
include_once '../../config/config.php';
include_once $serverPath.'utils/db_post.php';
include_once $serverPath.'utils/db_get.php';

$stopFirewall = 'true';
$table = 'users';
if(empty($_GET['inviteKey'])){
	header("Location: ". $baseURL);
}
$users = runQuery("SELECT email FROM ".getTableQuote('invitations')." WHERE inviteKey='".$_GET['inviteKey']."';");
if(count($users) > 0){
	$email = $users[0]['email'];
}else{
	header("Location: ". $baseURL);
}

if(!empty($_POST)){
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if(!empty($email) && !empty($username) && !empty($password)){
		$query = "SELECT username FROM ".getTableQuote($table)." WHERE `username`='$username' OR `email`='$email';";
		if(count(runQuery($query)) == 0){
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){die("Invalid E-Mail Address");}
			
			$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
			$password = hash('sha256', $_POST['password'] . $salt);
			
			for($round = 0; $round < 65536; $round++){
				$password = hash('sha256', $password . $salt);
			}
			
			
			$data = [
					'email' => $email,
					'password' => $password,
					'salt' => $salt,
					'username' => $username
			];
			insert($table, $data);
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers .= 'From:'.$webmasterMail.' <'.$webmasterMail.'>' . "\r\n";
			
			$message = "
			<html>
			<body>
			<p>Your account has been created for the Linger Martini Bar.</p>
					
			<p>Username: $username</p>
			
			</body>
			
			</html>
			";
			
			$subject = "Your account has been created for The Linger Martini Bar";
			mail($email, $subject, $message, $headers);
			
			header("Location: ". $baseURL."admin/login/index.php");
			
		}else{
			die("Username or email already in use");
		}
		
		
	}else{
		die("Not all required fields present.");
	}
	
}
include_once $serverPath.'resources/templates/adminHead.php';


?>

<div ng-controller="CreateAccountController">
	<div class="container-fluid">
		<form action="createAccount.php?inviteKey=<?php echo $_GET['inviteKey'];?>" method="post">
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">Create Account {{username}}</div>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label for="email">Email</label>
								<p><?php echo $email;?></p>
							</div>
							<div class="form-group">
								<label for="username">Username</label>
								<input class="form-control" id='username' pattern=".{3,}" title="3 characters minimum" type="text" name='username' ng-model='username' required="required" placeholder="Username">
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input class="form-control" id='password' type="password" pattern=".{5,}" title="5 characters minimum" name='password' ng-model='password' required="required" placeholder="Password">
							</div>
							<div class="form-group">
								<label for="password_confirm">Confirm Password</label>
								<input class="form-control" id='password_confirm'  pattern=".{5,}" title="5 characters minimum" type="password" name='password_confirm' ng-model='password_confirm' required="required" placeholder="Confirm Password">
							</div>
														
							<div class="form-group">
								<button class="btn btn-primary" type="submit" ng-disabled="vaildForm()">Send</button>
								<a class="btn btn-danger" href="index.php">Cancel</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
app.controller('CreateAccountController', ['$scope', "$controller" , function($scope, $controller){
	angular.extend(this, $controller('LingerUtilsController', {$scope: $scope}));

	$scope.email = getUrlValueByParam('email');

	$scope.vaildForm = function(){
		return !($scope.password && $scope.password_confirm && $scope.password_confirm == $scope.password);
	}	
	
}]);

</script>
