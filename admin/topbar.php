<?php
// Assuming you already have the logo stored in the session or retrieved via query
// Example session data for the logo:
// $_SESSION['logo_img'] = '../assets/img/logo.png';
?>

<style>
	.logo {
    	margin: auto;
    	font-size: 20px;
    	background: gray;
    	padding: 0; /* Remove padding for the logo image */
    	border-radius: 50%;
    	overflow: hidden; /* Make sure the logo stays inside the circle */
    	width: 50px;
    	height: 50px;
	}

	.logo img {
    	width: 100%; /* Make the image fit the div */
    	height: 100%;
    	object-fit: cover; /* Ensure the image covers the entire area without distortion */
	}
</style>

<nav class="navbar navbar-light bg-light fixed-top" style="padding:0;height:3.4em">
  <div class="container-fluid mt-2 mb-2">
  	<div class="col-lg-12">
  		<div class="col-md-1 float-left" style="display: flex;">
  			<div class="logo">
  				<!-- Display the logo -->
  				<!-- System Logo Preview -->
<div class="form-group">
    <img src="<?php echo isset($meta['logo_img']) && !empty($meta['logo_img']) ? '../assets/img/'.$meta['logo_img'] : '' ?>" alt="Logo Preview" id="logo_img">
</div>


  			</div>
  		</div>
      <div class="col-md-4 float-left">
        <large style="font-family: 'Dancing Script', cursive !important;">
          <b><?php echo isset($_SESSION['setting_name']) ? $_SESSION['setting_name'] : 'System Name'; ?> - Admin Site</b>
        </large>
      </div>
	  	<div class="col-md-2 float-right">
	  		<a href="ajax.php?action=logout" class="text-dark">
	  			<?php echo $_SESSION['login_name']; ?> <i class="fa fa-power-off"></i>
	  		</a>
	    </div>
    </div>
  </div>
</nav>
