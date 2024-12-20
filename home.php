<!-- <?php
session_start();
?>
<!-- Masthead -->
<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-10 align-self-center mb-4 page-title">
                <h1 class="text-white">Welcome to <?php echo isset($_SESSION['setting_name']) ? $_SESSION['setting_name'] : 'Our Website'; ?></h1>
                <hr class="divider my-4 bg-dark" />
                <a class="btn btn-dark bg-black btn-xl js-scroll-trigger" href="#menu">Order Now</a>
            </div>
        </div>
    </div>
</header>


<section class="page-section" id="menu">
        <h1 class="text-center text-cursive" style="font-size:3em"><b>Menu</b></h1>
        <div class="d-flex justify-content-center">
            <hr class="border-dark" width="5%">
        </div>

 <div class="container">
        <div class="row">
            <!-- Category Tabs -->
            <div class="col-lg-3 mb-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-all-tab" data-toggle="pill" href="#v-pills-all" role="tab"
                        aria-controls="v-pills-all" aria-selected="true" onclick="loadMenu('all')">All</a>

                    <?php 
                        include 'admin/db_connect.php';
                        $categories = $conn->query("SELECT * FROM category_list ORDER BY name ASC");
                        while ($category = $categories->fetch_assoc()):
                    ?>
                        <a class="nav-link" id="v-pills-<?php echo strtolower($category['name']); ?>-tab" 
                           data-toggle="pill" href="#v-pills-<?php echo strtolower($category['name']); ?>" 
                           role="tab" aria-controls="v-pills-<?php echo strtolower($category['name']); ?>" 
                           aria-selected="false" onclick="loadMenu('<?php echo $category['id']; ?>')">
                            <?php echo $category['name']; ?>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Products Section -->
            <div id="menu-field" class="col-lg-9 mt-7">
                <div class="row" id="product-grid">
                    <!-- Products will be loaded here dynamically -->
                </div>

                <!-- Pagination -->
                <div class="w-100 d-flex justify-content-center mt-4">
                    <div class="btn-group paginate-btns">
                        <button class="btn btn-default border border-dark" id="prev-btn" disabled>Prev.</button>
                        <div id="pagination-links"></div>
                        <button class="btn btn-default border border-dark" id="next-btn">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<style>
.card-img-top {
    width: 100%; 
    height: 100px; /* Fixed height for all product images */
    object-fit: cover; /* Ensures the image fills the space without distortion */
}

.modal-img {
    width: 100%; /* Ensure the image takes the full width */
    height: 100px; /* Adjust based on your modal design */
    object-fit: cover; /* Keep aspect ratio while filling the space */
}

.card-img-top {
    width: 100%;
    height: auto;
}

</style>

<script>

// Function to update pagination buttons
function updatePagination(categoryId) {
    $.ajax({
        url: 'get_pagination.php', // Create a PHP file to handle pagination logic
        type: 'GET',
        data: { category_id: categoryId },
        success: function(data) {
            $('#pagination-links').html(data); // Update pagination links
        }
    });
}
</script>


<!-- Start Gallery -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
<section class="gallery-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading-title text-center">
                    <h2>Gallery</h2>
                    <p>Delicious food for REDD WINGS Restaurant Listed Here</p>
                </div>
            </div>
        </div>
        <div class="tz-gallery">
            <div class="row">
                <?php
                    $s = mysqli_query($conn, "SELECT * FROM gallery ORDER BY id DESC LIMIT 20");
                    while ($r = mysqli_fetch_array($s)):
                ?>
                    <div class="col-sm-30 col-md-30 col-lg-30">
                        <a data-fancybox="gallery" href="<?php echo "admin/" . $r['image']; ?>">
                            <img class="img-fluid" src="<?php echo "admin/" . $r['image']; ?>" alt="Gallery Images" style="width: 350px; height: 250px;">
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript for AJAX Menu Loading -->
<script>
$(document).ready(function() {
    // Load products for the selected category
    function loadMenu(category) {
        console.log("Selected Category:", category); // Log the category ID for debugging

        $.ajax({
            url: 'fetch_products.php', // Ensure this file exists in the same directory
            method: 'GET',
            data: { category: category }, // Send the selected category
            success: function(data) {
                // Clear previous products
                $('#menu-field .row').empty(); // Clear existing product cards

                // Append new product cards
                $('#menu-field .row').html(data);
            },
            error: function(xhr, status, error) {
                console.error("Error: " + xhr.status + " - " + error);
            }
        });
    }

    // Handle tab click for category filtering
    $('.nav-link').click(function() {
        var category = $(this).attr('onclick').split("'")[1]; // Parse category from the onclick attribute
        loadMenu(category); // Load menu items for the selected category
    });

    // Initial load for all products
    loadMenu('all'); // Load all products on page load
});
</script>


<!-- Fancybox -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
<script>
  Fancybox.bind('[data-fancybox="gallery"]', {
    // Optional custom settings
    infinite: true, // Infinite looping of images
    buttons: ["close"],
  });
</script>

<!-- Product View Modal -->
<script>
$(document).on('click', '.view_prod', function() {
    // Fetch product details and open modal
    uni_modal_right('Product Details', 'view_prod.php?id=' + $(this).attr('data-id'));
});

</script>

<!-- Scroll to menu section on page load -->
<?php if (isset($_GET['_page'])): ?>
<script>
$(function() {
    document.querySelector('html').scrollTop = $('#menu').offset().top - 100;
});
</script>
<?php endif; ?>
