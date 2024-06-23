<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SetUpSprint</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../assets/images/SetUpSprint.svg" type="image/icon type">
    <script src="../assets/js/scripts.js"></script>
    <style>
        .prd-img {
            width: 150px;
            height: auto; /* Maintain aspect ratio */
        }

        .product-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin: 10px;
        }

        .pr-name {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }

        .pr-price {
            color: #b12704;
            font-size: 14px;
            margin: 5px 0;
        }

        .shop-products-list ul {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 0;
            list-style: none;
        }

        .shop-products-list li {
            flex: 0 1 calc(25% - 20px);
            margin: 10px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

<?php include "../includes/header.php" ?>

<!-- SHOP -->
<section class="container main-shop">
    <!-- Filter Products -->
    <div class="filters-card">
        <div style="display:flex;justify-content:space-between;">
            <h2 class="fliter-text">Filters</h2>
            <img src="../assets/images/filter.svg">
        </div>
        <hr>
        <!-- Filters form -->
        <form action="shopPage.php" method="post">
            <!-- applied filters -->
            <div class="filter-detail">
                <label class="main">ALL
                    <input type="checkbox" checked>
                    <span class="checkbox-container"></span>
                </label>
            </div>
            <!-- brand filter -->
            <h2 class="fliter-text">Brands</h2>
            <hr>
            <div class="filter-detail">
                <?php 
                    include_once "../includes/database.php";
                    $query = "SELECT * FROM brand_logos";
                    $stmt = $connect->prepare($query);
                    $stmt->execute();
                    $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($brands as $brand) {
                        echo "<label class='main'>".$brand['BrandName']."
                        <input type='checkbox' name='brands[]' value='".$brand['BrandName']."'>
                        <span class='checkbox-container'></span>
                        </label>";
                    }
                ?>
            </div>
            <!-- category filter -->
            <h2 class="fliter-text">Categories</h2>
            <hr>
            <div class="filter-detail">
                <?php 
                    $query = "SELECT DISTINCT Category FROM Product";
                    $stmt = $connect->prepare($query);
                    $stmt->execute();
                    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($categories as $category) {
                        echo "<label class='main'>".$category['Category']."
                        <input type='checkbox' name='categories[]' value='".$category['Category']."'>
                        <span class='checkbox-container'></span>
                        </label>";
                    }
                ?>
            </div>
            <hr>
            <input class="filter-btn" value="Apply filters" type="submit">
        </form>
    </div>

    <!-- Shop products -->
    <div class="shop-right">
        <div class="shop-products-list">
            <div>
                <h2 class="medium-title">Shop</h2>
            </div>
            <ul>
                <!-- loading products -->
                <?php 
                    // Check if filters are applied
                    $brands = isset($_POST['brands']) ? $_POST['brands'] : [];
                    $categories = isset($_POST['categories']) ? $_POST['categories'] : [];

                    // Initialize the base query
                    $filter_query = " WHERE 1=1"; // This ensures that additional conditions can be safely appended

                    if (!empty($brands)) {
                        $brand_list = implode("', '", $brands);
                        $filter_query .= " AND Brand IN ('$brand_list')";
                    }

                    if (!empty($categories)) {
                        $category_list = implode("', '", $categories);
                        $filter_query .= " AND Category IN ('$category_list')";
                    }

                    // Construct the final query
                    $query = "SELECT * FROM product $filter_query";

                    $stmt = $connect->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach($result as $row): ?>
                        <li>
                            <a href="../pages/productDetailPage.php?ID=<?php echo $row["ProductID"] ?>">
                                <div class="product-item">
                                    <div><img src="../assets/images/<?php echo $row["ProductName"] ?>.jpg" alt="product" class="prd-img"/></div>
                                    <p class="pr-name"><?php echo $row["ProductName"] ?></p>
                                    <img src="../assets/images/rating.svg" alt="rating">
                                    <p class="pr-price"><?php echo $row["OldPrice"] ?> PKR</p>  
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
            </ul>
        </div>
        <hr style="width: 90%;">

        <!-- Pages footer -->
        <div class="page-footer">
            <!-- previous button -->
            <?php  
                if (isset($_GET["page"])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                if ($page > 1) {
                    $page--;
                }

                echo "<a class='btn-p' href='shopPage.php?page=".$page."'>"; ?>
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:1dvw">
                        <img src="../assets/images/left-arrow.svg"><div>Previous</div>
                    </div>
                </a>
            <!-- displaying page items -->
            <?php
                $prod_per_page = 16;
                $sql = "SELECT COUNT(ProductID) AS total FROM product $filter_query";
                $stm = $connect->query($sql);
                $row = $stm->fetch(PDO::FETCH_ASSOC);

                $total_pages = ceil($row["total"] / $prod_per_page);
                ?>
            <div class="pages">
                <?php
                if (isset($_GET["page"])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i <= 3 || $i > $total_pages - 3 || ($i >= $page-1 && $i <= $page + 1)) {
                        echo "<div class='page-item'>".$i."</div>";
                    }
                }
                ?>
            </div>
            <!-- Next button -->
            <?php  
            if ($page < $total_pages) {
                $page++;
            }
            echo "<a class='btn-p' href='shopPage.php?page=".$page."'>"; ?>
                <div style="display:flex;justify-content:space-between;align-items:center;gap:1dvw">
                    <div>Next</div><img src="../assets/images/right-arrow.svg"> 
                </div>  
            </a>
        </div>
    </div>
</section>

<?php include "../includes/footer.php" ?>

</body>
</html>
