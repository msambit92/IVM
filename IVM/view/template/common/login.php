<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script defer src="view/javascript/fontawesome-free-5.0.6/svg-with-js/js/fontawesome-all.js"></script>
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href="view/css/login.css" rel="stylesheet" media="screen" />
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div id="login-container">
				<div class="col-sm-4" id="welcome-panel">
					<div id="welcome">
						<div id="welcome-icon"><i class="fas fa-database"></i></div>
						<div id="welcome-header">Inventory Management</div>
						<div id="welcome-text">Enter The Magical Pharse And Open The Mouth Of The Cave.</div>
					</div>
				</div>
				<div class="col-sm-8" id="login-panel">
					<div class="form-group">
				      <label for="username">Username</label>
				      <input type="text" class="form-control" id="username" placeholder="Username" name="username">
				    </div>
				    <div class="form-group">
				      <label for="password">Password</label>
				      <input type="password" class="form-control" id="password" placeholder="Password" name="password">
				    </div>
				    <button class="btn" onclick="formSubmit()">Login</button>
				</div>
			</div>
		</div>
	</div>
</body>
<script>
	function formSubmit() {

		$('.text-danger').remove();

		var error = false;

		if ($('input[name=username]').length == 0) {
			error = true;
			let html = '';
			html += '<div class="text-danger">Please enter your username</div>';
			$('#login-panel').prepend(html);
		}

		if ($('input[name=password]').length == 0) {
			error = true;
			let html = '';
			html += '<div class="text-danger">Please enter your password</div>';
			$('#login-panel').prepend(html);
		}

		if (!error && !$('input[name=username]').val().trim()) {
			error = true;
			let html = '';
			html += '<div class="text-danger">Please enter your username</div>';
		    $('input[name=username]').after(html);
		}

		if (!error && !$('input[name=password]').val().trim()) {
			error = true;
			let html = '';
			html += '<div class="text-danger">Please enter your password</div>';
		    $('input[name=password]').after(html);
		}

		if (!error) {
			$.ajax({
				url: 'index.php?route=common/login/validate',
				method : 'post',
				data: {username : $('input[name=username]').val(), password : $('input[name=password]').val()},
				dataType: 'json',
				success: function(json) {
					if (json['error']) {
						if (json['error']['username']) {
							let html = '';
							html += '<div class="text-danger">' + json['error']['username'] + '</div>';
							$('input[name=username]').after(html);
						}

						if (json['error']['password']) {
							let html = '';
							html += '<div class="text-danger">' + json['error']['password'] + '</div>';
							$('input[name=password]').after(html);
						}

						if (json['error']['not_authenticated']) {
							let html = '';
							html += '<div class="text-danger">' + json['error']['not_authenticated'] + '</div>';
							$('#login-panel').prepend(html);
						}
					}

					if (json['success']) {
						window.location.href = "index.php?route=common/dashboard&token=" + json['success'] + "";
					}
				}
			});
		}
	}
</script>
</html>