<div class="container-fluid">
	<form action="" id="forgot-frm">
		<div class="form-group">
			<label for="email_or_phone" class="control-label">Enter your Email or Phone Number</label>
			<input type="text" name="email_or_phone" required class="form-control">
		</div>
		<button class="button btn btn-dark btn-sm">Send Reset Link</button>
	</form>
</div>

<script>
	$('#forgot-frm').submit(function(e){
		e.preventDefault();
		$('#forgot-frm button[type="submit"]').attr('disabled', true).html('Sending reset link...');
		if ($(this).find('.alert-danger').length > 0)
			$(this).find('.alert-danger').remove();
		$.ajax({
			url: 'admin/ajax.php?action=forgot_password',
			method: 'POST',
			data: $(this).serialize(),
			error: err => {
				console.log(err);
				$('#forgot-frm button[type="submit"]').removeAttr('disabled').html('Send Reset Link');
			},
			success: function(resp) {
				if (resp == 1) {
					$('#forgot-frm').prepend('<div class="alert alert-success">A reset link has been sent to your email or phone number.</div>');
					$('#forgot-frm button[type="submit"]').removeAttr('disabled').html('Send Reset Link');
				} else {
					$('#forgot-frm').prepend('<div class="alert alert-danger">Account not found.</div>');
					$('#forgot-frm button[type="submit"]').removeAttr('disabled').html('Send Reset Link');
				}
			}
		});
	});
</script>
