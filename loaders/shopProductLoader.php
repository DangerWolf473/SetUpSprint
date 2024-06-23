<?php
include_once "../includes/database.php" ;

$prod_per_page = 16 ;
if (isset($_GET["page"])) {
    $page = $_GET['page'];
} else $page=1;

$start_from = ($page-1)*$prod_per_page ;


// check if filter form is submitted
if (isset($_POST['brands']) && isset($_POST['categories'])) {
    $brands = $_POST['brands'];
    $categories = $_POST['categories'];
} else {
    $brands = array();
    $categories = array();
}

// constructing filter query
$filter_query = "";
if (!empty($brands)) {
    $filter_query .= " AND Brand IN ('".implode("', '", $brands)."')";
}
if (!empty($categories)) {
    if (!empty($filter_query)) {
        $filter_query .= " AND ";
    } else {
        $filter_query .= " WHERE ";
    }
    $filter_query .= " Category IN ('".implode("', '", $categories)."')";
}

// selecting products with filter applied
$quer = "SELECT * FROM product $filter_query LIMIT $start_from , $prod_per_page";
$stm = $connect->query($quer) ;
$result = $stm->fetchAll(PDO::FETCH_ASSOC);

foreach($result as $row) { ?>
    <!-- displaying product card -->
    <li><a href="../pages/productDetailPage.php?ID=<?php echo $row["ProductID"] ?>">
    <div class="product-item">
        <div><img src="../assets/images/<?php echo $row["ProductName"] ?>.jpg" alt="product" class="prd-img"/></div>
        <p class="pr-name"><?php echo $row["ProductName"] ?></p>
        <img src="../assets/images/rating.svg" alt="rating">
        <p class="pr-price"><?php echo $row["OldPrice"] ?> DT</p>  
    </div>
    </a></li>

<?php } ?>