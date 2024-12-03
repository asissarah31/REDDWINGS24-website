<?php
include 'admin/db_connect.php';


// Get the category ID and page number from the GET request
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 'all';
// Correctly limit the number of results returned per page:
$limit = 10; // Number of products per page
$offset = ($page - 1) * $limit; // Calculate the offset based on the current page number

// Determine the total number of products for the category
if ($category_id === 'all') {
    $total_products_query = $conn->query("SELECT COUNT(*) as count FROM product_list");
} else {
    $total_products_query = $conn->query("SELECT COUNT(*) as count FROM product_list WHERE category_id = " . intval($category_id));
}

$total_products = $total_products_query->fetch_assoc()['count'];
$page_btn_count = ceil($total_products / $limit);

// Generate pagination buttons
$output = '';
if ($page_btn_count > 1) {
    // Previous Page Button
    $output .= '<button class="btn btn-default border border-dark" id="prev-btn" ' . ($page == 1 ? 'disabled' : '') . ' onclick="loadMenu(\'' . $category_id . '\', ' . ($page - 1) . ')">Prev.</button>';

    // Page Buttons
    for ($i = 1; $i <= $page_btn_count; $i++) {
        if ($page_btn_count > 10) {
            if ($i == $page_btn_count && !in_array($i, range($page - 3, $page + 3))) {
                $output .= '<span class="btn btn-default border border-dark ellipsis">...</span>';
            }

            if ($i == 1 || $i == $page_btn_count || in_array($i, range($page - 3, $page + 3))) {
                $output .= '<button class="btn btn-default border border-dark ' . ($i == $page ? 'active' : '') . '" onclick="loadMenu(\'' . $category_id . '\', ' . $i . ')">' . $i . '</button>';
                if ($i == 1 && !in_array($i, range($page - 3, $page + 3))) {
                    $output .= '<span class="btn btn-default border border-dark ellipsis">...</span>';
                }
            }
        } else {
            $output .= '<button class="btn btn-default border border-dark ' . ($i == $page ? 'active' : '') . '" onclick="loadMenu(\'' . $category_id . '\', ' . $i . ')">' . $i . '</button>';
        }
    }

    // Next Page Button
    $output .= '<button class="btn btn-default border border-dark" id="next-btn" ' . ($page == $page_btn_count ? 'disabled' : '') . ' onclick="loadMenu(\'' . $category_id . '\', ' . ($page + 1) . ')">Next</button>';
}

// Output the pagination HTML
echo $output;

$conn->close();
?>
