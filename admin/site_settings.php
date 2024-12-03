<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * from system_settings limit 1");
if($qry->num_rows > 0){
	foreach($qry->fetch_array() as $k => $val){
		$meta[$k] = $val;
	}
}
?>
<div class="container-fluid">
	<div class="card col-lg-12">
		<div class="card-body">
			<form action="" id="manage-settings">
				<!-- System Name -->
				<div class="form-group">
					<label for="name" class="control-label">System Name</label>
					<input type="text" class="form-control" id="name" name="name" value="<?php echo isset($meta['name']) ? $meta['name'] : '' ?>" required>
				</div>

				<!-- Email -->
				<div class="form-group">
					<label for="email" class="control-label">Email</label>
					<input type="email" class="form-control" id="email" name="email" value="<?php echo isset($meta['email']) ? $meta['email'] : '' ?>" required>
				</div>

				<!-- Contact -->
				<div class="form-group">
					<label for="contact" class="control-label">Contact</label>
					<input type="text" class="form-control" id="contact" name="contact" value="<?php echo isset($meta['contact']) ? $meta['contact'] : '' ?>" required>
				</div>

				<!-- About Content -->
				<div class="form-group">
					<label for="about" class="control-label">About Content</label>
					<textarea name="about" class="text-jqte"><?php echo isset($meta['about_content']) ? $meta['about_content'] : '' ?></textarea>
				</div>

				<!-- System Logo Upload -->
				<div class="form-group">
					<label for="system_logo" class="control-label">System Logo</label>
					<input type="file" class="form-control" name="system_logo" onchange="displayImg(this,'#logo_img')">
				</div>

				<!-- System Logo Preview -->
				<div class="form-group">
					<!-- System Logo Preview -->
<div class="form-group">
    <img src="<?php echo isset($meta['logo_img']) && !empty($meta['logo_img']) ? '../assets/img/'.$meta['logo_img'] : '' ?>" alt="Logo Preview" id="logo_img">
</div>


				</div>

				<!-- Website Cover Upload -->
				<div class="form-group">
					<label for="website_cover" class="control-label">Website Cover</label>
					<input type="file" class="form-control" name="website_cover" onchange="displayImg(this,'#cover_img')">
				</div>

				<!-- Website Cover Preview -->
				<div class="form-group">
					<img src="<?php echo isset($meta['cover_img']) ? '../assets/img/'.$meta['cover_img'] :'' ?>" alt="Cover Preview" id="cover_img">
				</div>

				<!-- Save Button -->
				<center>
					<button class="btn btn-info btn-primary btn-block col-md-2">Save</button>
				</center>
			</form>
		</div>
	</div>

	<style>
		/* Adjust image preview size */
		img#logo_img, img#cover_img {
			max-height: 10vh;
			max-width: 6vw;
		}
	</style>

	<script>
		// Function to preview selected image
		function displayImg(input, imgSelector) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        reader.onload = function (e) {
		        	$(imgSelector).attr('src', e.target.result);
		        }
		        reader.readAsDataURL(input.files[0]);
		    }
		}

		// jQuery text editor initialization
		$('.text-jqte').jqte();

		// Form submission with AJAX
		$('#manage-settings').submit(function(e){
			e.preventDefault();
			start_load();
			$.ajax({
				url:'ajax.php?action=save_settings',
				data: new FormData($(this)[0]),
			    cache: false,
			    contentType: false,
			    processData: false,
			    method: 'POST',
			    type: 'POST',
				error: function(err){
					console.log(err);
				},
				success: function(resp){
					if(resp == 1){
						alert_toast('Data successfully saved.','success');
						setTimeout(function(){
							location.reload();
						}, 1000);
					}
				}
			});
		});
	</script>
</div>
