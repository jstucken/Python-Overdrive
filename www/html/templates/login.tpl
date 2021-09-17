
<header>
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
			
				<!--<form action="login_make_new_pass.php" method="POST" class="form-signin">-->
				<form action="login.php" method="POST" class="form-signin">
					<h2 class="form-signin-heading">Please sign in</h2>
					<br>
					
					<label for="email" class="sr-only">Email address</label>
					<input type="text" name="email" id="email" class="form-control" placeholder="Username" required autofocus maxlength="100">
					
					
					<label for="password" class="sr-only">Password</label>
					<input type="password" name="password" id="password" class="form-control" placeholder="Password" required maxlength="20">
					
					
					<div class="checkbox">
					  <label>
						Forgot Password
					  </label>
					</div>
					
					<button class="btn btn-lg btn-primary btn-block text-center" type="submit">Sign in</button>
				  </form>
			</div>
		</div>
	</div>
</header>
