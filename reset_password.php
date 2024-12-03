<?php
if (isset($_GET['token'])) {
	$token = $_GET['token'];
	$user = $conn->query("SELECT * FROM users WHERE reset_token = '$token'");
	if ($user->num_rows == 0) {
		echo "Invalid token.";
		exit();
	}
} else {
	echo "No token provided.";
	exit();
}
?>

<div class="container-fluid">
	<form action="" id="reset-frm">
		<div class="form-group">
			<label for="password" class="control-label">New Password</label>
			<input type="password" name="password" required class="form-control">
		</div>
		<button class="button btn btn-dark btn-sm">Reset Password</button>
	</form>
</div>

<script>
	$('#reset-frm').submit(function(e){
		e.preventDefault();
		$('#reset-frm button[type="submit"]').attr('disabled', true).html('Resetting password...');
		$.ajax({
			url: 'admin/ajax.php?action=reset_password',
			method: 'POST',
			data: { password: $('input[name="password"]').val(), token: '<?php echo $token; ?>' },
			error: err => {
				console.log(err);
				$('#reset-frm button[type="submit"]').removeAttr('disabled').html('Reset Password');
			},
			success: function(resp) {
				if (resp == 1) {
					alert("Password successfully reset. You can now login.");
					location.href = 'login.php';
				} else {
					$('#reset-frm').prepend('<div class="alert alert-danger">Failed to reset password.</div>');
					$('#reset-frm button[type="submit"]').removeAttr('disabled').html('Reset Password');
				}
			}
		});
	});
</script>
