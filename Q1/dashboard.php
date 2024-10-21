<?php
session_start();
require './Admin/db.php'; 

$categories = $conn->query("SELECT * FROM category"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    .category-btn {
        padding: 15px 30px;
        font-size: 18px;
        border-radius: 5px;
    }
    
    .pagination-link {
        margin: 0 5px;
        cursor: pointer;
    }

    .card {
        width: 100%;
        height: 350px; 
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-img-top {
        width: 100%;
        height: 200px; 
        object-fit: contain; 
        background-color: #f5f5f5; 
    }

    .card-body {
        flex-grow: 1; 
    }
</style>


</head>
<body>
<div class="container mt-5">
    <h3 class="text-center">Categories</h3>
    <div class="d-flex flex-wrap justify-content-center">
        <?php while ($category = $categories->fetch_assoc()): ?>
            <button class="btn btn-primary m-2 category-btn" data-id="<?php echo $category['id']; ?>">
                <?php echo $category['categoryName']; ?>
            </button>
        <?php endwhile; ?>
    </div>

    <div class="container mt-5">
        <h3 class="text-center">Products</h3>
        <div id="products-list" class="row"></div>
        <div id="pagination-controls" class="mt-4 text-center"></div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.category-btn').on('click', function() {
        var categoryId = $(this).data('id');
        
        $('.category-btn').removeClass('active');
        $(this).addClass('active');
        
        loadProducts(categoryId, 1); 
    });

    function loadProducts(categoryId, page) {
        $.ajax({
            url: 'fetch_products.php',
            method: 'GET',
            data: { category_id: categoryId, page: page },
            dataType: 'json',  
            success: function(response) {
                $('#products-list').html(response.products);
                $('#pagination-controls').html(response.pagination);
            }
        });
    }

    $(document).on('click', '.pagination-link', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        var categoryId = $('.category-btn.active').data('id');
        loadProducts(categoryId, page);
    });
});
</script>
</body>
</html>
