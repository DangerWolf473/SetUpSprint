<?php
// Include database connection
include_once 'db_connect.php';

// Function to fetch all customers
function getAllCustomers($conn) {
    $sql = "SELECT ClientID, FirstName, LastName, Email FROM clients";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return []; // Return an empty array if no customers found
    }
}

// Fetch all customers
$customers = getAllCustomers($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Admin Dashboard - Customers</title>
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        /* Navigation bar styles */
        nav {
            background-color: #333;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            height: 50px;
            width: auto;
        }

        .search-form {
            display: flex;
            align-items: center;
        }

        .search-input {
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .submit-btn {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        /* Main content styles */
        .mpage {
            display: flex;
            justify-content: space-between;
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .lfttable {
            flex: 1;
            padding-right: 20px;
            border-right: 1px solid #ccc;
        }

        .rgtcontent {
            flex: 3;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        /* Responsive adjustments */
        @media only screen and (max-width: 768px) {
            .mpage {
                flex-direction: column;
            }

            .lfttable {
                border-right: none;
                padding-right: 0;
                margin-bottom: 20px;
            }
        }
    </style>
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
            <div class="tablecol"> <a href="adminDashboard.php"> Dashboard </a> </div>
        </div>
        <div class="tablrow">
            <div class="tablecol"> <img src="../assets/images/costumers.png" > </div>
            <div class="tablecol"> <a href="adminCustomers.php"> Customers (<?php echo count($customers); ?>) </a> </div>
        </div>
        <div class="tablrow">
            <div class="tablecol"> <img src="../assets/images/orders.png" > </div>
            <div class="tablecol"> <a href="adminOrders.php"> Orders </a> </div>
        </div>
        <div class="tablrow">
            <div class="tablecol"> <img src="../assets/images/products.png" > </div>
            <div class="tablecol"> <a href="adminProducts.php"> Products </a> </div>
        </div>
    </div>

    <div class="rgtcontent">
        <!-- Displaying customers table -->
        <h2>Customers</h2>
        <table>
            <tr><th>Customer ID</th><th>Name</th><th>Email</th></tr>
            <?php foreach ($customers as $customer) { ?>
                <tr>
                    <td><?php echo $customer['ClientID']; ?></td>
                    <td><?php echo $customer['FirstName'] . ' ' . $customer['LastName']; ?></td>
                    <td><?php echo $customer['Email']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>
