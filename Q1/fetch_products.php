<?php
require './Admin/db.php'; 

$category_id = $_GET['category_id'];
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 4; 
$offset = ($page - 1) * $limit;

$products_query = $conn->prepare("SELECT * FROM product WHERE category = ? LIMIT ?, ?");
$products_query->bind_param("iii", $category_id, $offset, $limit);
$products_query->execute();
$products_result = $products_query->get_result();

$total_query = $conn->prepare("SELECT COUNT(*) as total FROM product WHERE category = ?");
$total_query->bind_param("i", $category_id);
$total_query->execute();
$total_result = $total_query->get_result();
$total_products = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_products / $limit);

$products_html = '';
while ($product = $products_result->fetch_assoc()) {
    $image_path = './Admin/uploads/' . $product['image']; 

    $products_html .= '
    <div class="col-md-3 mb-4">
        <div class="card">
            <img src="' . $image_path . '" class="card-img-top" alt="' . $product['productName'] . '">
            <div class="card-body">
                <h5 class="card-title">' . $product['productName'] . '</h5>
                <p class="card-text">' . $product['description'] . '</p>
            <p class="card-text">' . $product['price'] . '$</p>

            </div>
        </div>
    </div>';
}

$pagination_html = '';
for ($i = 1; $i <= $total_pages; $i++) {
    $pagination_html .= '<a href="#" class="pagination-link" data-page="' . $i . '">' . $i . '</a> ';
}

echo json_encode(['products' => $products_html, 'pagination' => $pagination_html]);
?>
