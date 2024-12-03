<?php
include 'admin/db_connect.php';

$category = isset($_GET['category']) ? $_GET['category'] : 'all'; // Get category from the request

if ($category == 'all') {
    $qry = $conn->query("SELECT * FROM product_list ORDER BY name ASC");
} else {
    $qry = $conn->query("SELECT * FROM product_list WHERE category_id = $category ORDER BY name ASC");
}

while ($row = $qry->fetch_assoc()):
?>
    <!-- Product Card -->
    <div class="col-lg-3 col-md-9 mb-9">
        <div class="card menu-item rounded-0 h-100">
            <div class="position-relative overflow-hidden" id="item-img-holder">
                <img src="assets/img/<?php echo $row['img_path']; ?>" class="card-img-top" alt="Product Image">
            </div>
            <div class="card-body rounded-0">
                <h5 class="card-title"><?php echo $row['name']; ?></h5>
                <p class="card-text truncate"><?php echo $row['description']; ?></p>
				<p> <b><small>Unit Price :<?php echo number_format($row['price'],2) ?></small></b></p>
                <div class="text-center">
                    <button class="btn btn-sm btn-outline-dark view_prod btn-block" data-id="<?php echo $row['id']; ?>">
                        <i class="fa fa-eye"></i> View
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>


<style>
/* Ensure the card layout remains consistent */
.card {
    margin: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: hidden;
    height: 100%;
}

/* Image container and image styling */
#item-img-holder {
    height: 200px; /* Set a fixed height for all images */
    width: 100%;
    overflow: hidden;
}

.card-img-top {
    width: 100%;
    height: 100%; /* Ensure images take up the full container height */
    object-fit: cover; /* Crop the image to fill the container without distortion */
}

.card-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.truncate {
    max-height: 60px; /* Limit description height */
    overflow: hidden;
    text-overflow: ellipsis;
}

@media (max-width: 768px) {
    .col-md-4 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

@media (max-width: 576px) {
    .col-sm-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}
</style>
