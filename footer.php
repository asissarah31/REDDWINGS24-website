<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add metadata, title, and any other head elements -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Example</title>
    
    <!-- Your inline CSS should be placed within a style tag -->
    <style>
        /* Footer Styles */
        .footer-area {
            background-color: #222; /* Dark background */
            color: #fff; /* White text */
            padding: 50px 0; /* Padding for top and bottom */
        }

        .footer-area h3 {
            color: #f4b41a; /* Bright yellow-orange for headings */
            margin-bottom: 20px;
        }

        .footer-area p,
        .footer-area a {
            color: #aaa; /* Light grey for text */
            font-size: 15px;
            line-height: 1.8;
        }

        .footer-area a:hover {
            color: #f4b41a; /* Hover color for links */
            text-decoration: none;
        }

        .footer-area .lead {
            font-size: 16px;
            font-weight: 500;
        }

        .footer-links {
            list-style-type: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links li a {
            color: #aaa;
            text-decoration: none;
        }

        .footer-links li a:hover {
            color: #f4b41a;
        }

        .footer-area .text-color {
            color: #f4b41a; /* Same yellow-orange for emphasis */
        }

        .copyright {
            background-color: #111; /* Even darker background */
            padding: 15px 0;
            color: #666;
            font-size: 14px;
            text-align: center;
        }

        .company-name {
            color: #f4b41a;
        }

        .company-name a {
            color: #f4b41a;
            font-weight: bold;
            text-decoration: none;
        }

        .company-name a:hover {
            color: #fff;
        }

        @media (max-width: 767px) {
            .footer-area {
                text-align: center;
            }

            .footer-area .col-md-6 {
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>

<!-- Start Footer -->
<footer class="footer-area bg-f">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <h3>About Us</h3>
                <p>We love food and serving people with delicious meals.</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <h3>Useful Links</h3>
                <ul class="footer-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Food Menu</a></li>
                    <li><a href="#">Gallery</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h3>Contact Information</h3>
                <p class="lead">Capiz - Caidquid, 5807</p>
                <p class="lead"><a href="tel:+639924042799">+63 992 4042 799</a></p>
                <p><a href="mailto:reddwings@gmail.com">reddwings@gmail.com</a></p>
            </div>
            <div class="col-lg-3 col-md-6">
                <h3>Opening Hours</h3>
                <p><span class="text-color">MONDAY:</span> CLOSED</p>
                <p><span class="text-color">TUESDAY - SUNDAY</span>  <br>9:00 AM - 8:00 PM</p>
              
            </div>
        </div>
    </div>

    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p class="company-name"> 2024 <a href="#">REDD WINGS Restaurant</a>. .</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->
 <script>
 	$('.datepicker').datepicker({
 		format:"yyyy-mm-dd"
 	})
 	 window.start_load = function(){
    $('body').prepend('<di id="preloader2"></di>')
  }
  window.end_load = function(){
    $('#preloader2').fadeOut('fast', function() {
        $(this).remove();
      })
  }

 	window.uni_modal = function($title = '' , $url=''){
    start_load()
    $.ajax({
        url:$url,
        error:err=>{
            console.log()
            alert("An error occured")
        },
        success:function(resp){
            if(resp){
                $('#uni_modal .modal-title').html($title)
                $('#uni_modal .modal-body').html(resp)
                $('#uni_modal').modal('show')
                end_load()
            }
        }
    })
}
  window.uni_modal_right = function($title = '' , $url=''){
    start_load()
    $.ajax({
        url:$url,
        error:err=>{
            console.log()
            alert("An error occured")
        },
        success:function(resp){
            if(resp){
                $('#uni_modal_right .modal-title').html($title)
                $('#uni_modal_right .modal-body').html(resp)
                $('#uni_modal_right').modal('show')
                end_load()
            }
        }
    })
}
window.alert_toast= function($msg = 'TEST',$bg = 'success'){
      $('#alert_toast').removeClass('bg-success')
      $('#alert_toast').removeClass('bg-danger')
      $('#alert_toast').removeClass('bg-info')
      $('#alert_toast').removeClass('bg-warning')

    if($bg == 'success')
      $('#alert_toast').addClass('bg-success')
    if($bg == 'danger')
      $('#alert_toast').addClass('bg-danger')
    if($bg == 'info')
      $('#alert_toast').addClass('bg-info')
    if($bg == 'warning')
      $('#alert_toast').addClass('bg-warning')
    $('#alert_toast .toast-body').html($msg)
    $('#alert_toast').toast({delay:3000}).toast('show');
  }
  window.load_cart = function(){
    $.ajax({
      url:'admin/ajax.php?action=get_cart_count',
      success:function(resp){
        if(resp > -1){
          resp = resp > 0 ? resp : 0;
          $('.item_count').html(resp)
        }
      }
    })
  }
  $('#login_now').click(function(){
    uni_modal("LOGIN",'login.php')
  })
  $(document).ready(function(){
    load_cart()
  })
 </script>
 <!-- Bootstrap core JS-->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
</body>
</html>
