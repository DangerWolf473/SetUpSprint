<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="admin.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../assets/images/SetUpSprint.svg" type="image/icon type">
  <title>SetUpSprint</title>
</head>
<body>

<?php
// Include database connection
include_once 'db_connect.php';

// Function to fetch all customers
function getAllCustomers($conn) {
    $sql = "SELECT * FROM clients";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return []; // Return an empty array if no customers found
    }
}

// Function to fetch all orders
function getAllOrders($conn) {
    $sql = "SELECT * FROM orders";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return []; // Return an empty array if no orders found
    }
}

// Function to fetch all products
function getAllProducts($conn) {
    $sql = "SELECT * FROM product";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return []; // Return an empty array if no products found
    }
}

// Function to get total sales
function getTotalSales($conn) {
    $sql = "SELECT SUM(Subtotal) as TotalSales FROM orderdetail";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['TotalSales'];
}

// Function to get the most sold product
function getMostSoldProduct($conn) {
    $sql = "SELECT product.ProductName, SUM(orderdetail.Quantity) as TotalSold 
            FROM orderdetail 
            JOIN product ON orderdetail.ProductID = product.ProductID 
            GROUP BY orderdetail.ProductID 
            ORDER BY TotalSold DESC 
            LIMIT 1";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

// Fetch all customers
$customers = getAllCustomers($conn);

// Fetch all orders
$orders = getAllOrders($conn);

// Fetch all products
$products = getAllProducts($conn);

// Get total sales
$totalSales = getTotalSales($conn);

// Get the most sold product
$mostSoldProduct = getMostSoldProduct($conn);
?>

<nav>
  <div>
    <img src="../assets/images/SetUpSprint.svg" class="logo"></img>
  </div>
  <div style="flex-basis: auto;">
    <form class="search-form">
      <input type="text" class="search-input" placeholder="Search...">
      <button type="submit" class="submit-btn">Submit</button>
    </form>
  </div>
  <div class="logout-btn-container">
    <a href="../config/logout.php" class="logout-btn">Logout</a>
  </div>
</nav> 

<style>
nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
}

.logout-btn-container {
  margin-right: 10px;
}

.logout-btn {
  background-color: #d9534f; /* red color */
  color: #ffffff; /* white text color */
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  border-radius: 5px;
}

.logout-btn:hover {
  background-color: #c9302c; /* darker red color on hover */
}
</style>

<div class="mpage">
  <div class="lfttable">
    <div class="tablrow">
        <div class="tablecol"> <img src="../assets/images/dashboard.png" >      </div>
        <div class="tablecol"> <a href="adminDashboard.php"> Dashboard </a>   </div>
    </div>
    <div class="tablrow">
        <div class="tablecol"> <img src="../assets/images/costumers.png" >      </div>
        <div class="tablecol"> <a href="adminCustomers.php">Customers (<?php echo count($customers); ?>)</a></div>
    </div>
    <div class="tablrow">
        <div class="tablecol"> <img src="../assets/images/orders.png" >      </div>
        <div class="tablecol"><a href="adminOrders.php"> Orders (<?php echo count($orders); ?>)</a>    </div>
    </div>
    <div class="tablrow">
        <div class="tablecol"> <img src="../assets/images/products.png" >      </div>
        <div class="tablecol"> <a href="adminProducts.php">Products (<?php echo count($products); ?>)</a>   </div>
    </div>
  </div>
  
  <div class="rgtcontent">
    <div class="tbl1">
      <div class="col1"> 
        <div class="ll">
          <img src="../assets/images/reseauu.png">
        </div>
        <div class="rr">
          <p>Total Earnings</p>
          <h1><?php echo $totalSales; ?> PKR</h1>
        </div>
      </div>
      <div class="col1"> 
        <div class="ll">
          <img src="../assets/images/money.png">
        </div>
        <div class="rr">
          <p>This month</p>
          <h1>642.39 PKR</h1>
        </div>
      </div>
      <div class="col2">
        <p> Sales</p>
        <h1>574.34 PKR</h1>
        <div class="perc">
          <h3 id="a">+23% </h3>
          <h3 id="b"> since last month </h3>
        </div>
      </div>
      <div class="col2">
        <p> Customers </p>
        <h1><?php echo count($customers); ?></h1>
        <div class="perc">
          <h3 id="a">+15% </h3>
          <h3 id="b"> since last month </h3>
        </div>
      </div>
      <div class="col2">
        <p> Orders this month</p>
        <h1><?php echo count($orders); ?></h1>
        <div class="perc">
          <h3 id="a">+15% </h3>
          <h3 id="b"> since last month </h3>
        </div>
      </div>
    </div>
    <div class="tbl2">
      <img src="../assets/images/Earnings Chart.png" width='100%'>
    </div>
    <table class="tbl3">
      <th colspan="2">Most Sold Product</th>
      <tr>
        <td><?php echo $mostSoldProduct['ProductName']; ?></td>
        <td><?php echo $mostSoldProduct['TotalSold']; ?> sales</td>
      </tr>
    </table>
  </div>
</div>

</body>
</html>
