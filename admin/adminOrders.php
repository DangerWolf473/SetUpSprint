<?php
// Include database connection
include_once 'db_connect.php';

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

// Fetch all orders
$orders = getAllOrders($conn);
?>

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
    <nav>
        <div>
            <img src="../assets/images/SetUpSprint.svg" class="logo" alt="Logo">
        </div>
        <div style="flex-basis: auto;">
            <form class="search-form">
                <input type="text" class="search-input" placeholder="Search...">
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </nav>

    <div class="mpage">
        <div class="lfttable">
            <div class="tablrow">
                <div class="tablecol"> <img src="../assets/images/dashboard.png" > </div>
                <div class="tablecol"> <a href="./adminDashboard.php"> Dashboard </a> </div>
            </div>
            <div class="tablrow">
                <div class="tablecol"> <img src="../assets/images/costumers.png" > </div>
                <div class="tablecol"> <a href="adminCustomers.php"> Customers </a> </div>
            </div>
            <div class="tablrow">
                <div class="tablecol"> <img src="../assets/images/orders.png" > </div>
                <div class="tablecol"> <a href="./adminOrders.php"> Orders </a> </div>
            </div>
            <div class="tablrow">
                <div class="tablecol"> <img src="../assets/images/products.png" > </div>
                <div class="tablecol"> <a href="./adminProducts.php"> Products </a> </div>
            </div>
        </div>

        <div class="rgtcontent2">
            <div class="ttbl4">
                <h3>Latest Orders</h3>
                <table class="tbl4">
                    <tr>
                        <th>Order ID</th>
                        <th>Client ID</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Order Status</th>
                    </tr>
                    <?php foreach ($orders as $order) { ?>
                        <tr>
                            <td><?php echo $order['OrderID']; ?></td>
                            <td><?php echo $order['ClientID']; ?></td>
                            <td><?php echo $order['OrderDate']; ?></td>
                            <td><?php echo $order['TotalAmount']; ?></td>
                            <td><?php echo $order['OrderStatus']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
