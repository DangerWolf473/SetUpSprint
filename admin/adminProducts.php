<?php
// Include database connection
include_once 'db_connect.php';

// Function to fetch all products
function getAllProducts($conn, $searchTerm = '') {
    $sql = "SELECT * FROM product";
    if ($searchTerm) {
        $sql .= " WHERE ProductName LIKE ? OR Description LIKE ? OR Category LIKE ? OR Brand LIKE ?";
    }
    $stmt = $conn->prepare($sql);
    if ($searchTerm) {
        $likeTerm = "%$searchTerm%";
        $stmt->bind_param('ssss', $likeTerm, $likeTerm, $likeTerm, $likeTerm);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return []; // Return an empty array if no products found
    }
}

// Function to add a new product
function addProduct($conn, $data) {
    $sql = "INSERT INTO product (ProductName, Description, Category, SupplierID, OldPrice, SpecialPrice, QuantityInStock, DateAdded, Discount, ImageURL, Rating, Status, Brand) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssdssissdss",
        $data['ProductName'], $data['Description'], $data['Category'], $data['SupplierID'], $data['OldPrice'], $data['SpecialPrice'],
        $data['QuantityInStock'], $data['DateAdded'], $data['Discount'], $data['ImageURL'],
        $data['Rating'], $data['Status'], $data['Brand']
    );
    return $stmt->execute();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ProductName'])) {
    $newProduct = [
        'ProductName' => $_POST['ProductName'],
        'Description' => $_POST['Description'],
        'Category' => $_POST['Category'],
        'SupplierID' => $_POST['SupplierID'],
        'OldPrice' => $_POST['OldPrice'],
        'SpecialPrice' => $_POST['SpecialPrice'] ?? null,
        'QuantityInStock' => $_POST['QuantityInStock'],
        'DateAdded' => $_POST['DateAdded'],
        'Discount' => $_POST['Discount'] ?? null,
        'ImageURL' => $_POST['ImageURL'],
        'Rating' => $_POST['Rating'] ?? null,
        'Status' => $_POST['Status'],
        'Brand' => $_POST['Brand']
    ];

    if (addProduct($conn, $newProduct)) {
        echo "New product added successfully.";
    } else {
        echo "Error adding product.";
    }
}

// Handle search query
$searchTerm = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

// Fetch all products
$products = getAllProducts($conn, $searchTerm);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Admin Dashboard - Products</title>
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
            padding-right: 10px;
            border-right: 1px solid #ccc;
            max-width: 200px;
        }

        .rgtcontent {
            flex: 3;
            padding-left: 20px;
        }

        .tablrow {
            display: flex;
            align-items: center;
            padding: 5px 0;
        }

        .tablecol img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .tablecol a {
            text-decoration: none;
            color: #333;
        }

        /* Form styles */
        form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        form input, form textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        form input[type="submit"] {
            width: auto;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            margin-top: 20px;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
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
                max-width: 100%;
            }

            .rgtcontent {
                padding-left: 0;
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
        <form class="search-form" method="GET" action="">
            <input type="text" class="search-input" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($searchTerm); ?>">
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
            <div class="tablecol"> <a href="adminCustomers.php"> Customers </a> </div>
        </div>
        <div class="tablrow">
            <div class="tablecol"> <img src="../assets/images/orders.png" > </div>
            <div class="tablecol"> <a href="adminOrders.php"> Orders </a> </div>
        </div>
        <div class="tablrow">
            <div class="tablecol"> <img src="../assets/images/products.png" > </div>
            <div class="tablecol"> <a href="adminProducts.php"> Products (<?php echo count($products); ?>) </a> </div>
        </div>
    </div>

    <div class="rgtcontent">
        <!-- Form for adding new products -->
        <h2>Add New Product</h2>
        <form method="POST" action="">
            <label for="ProductName">Product Name:</label>
            <input type="text" id="ProductName" name="ProductName" required>

            <label for="Description">Description:</label>
            <textarea id="Description" name="Description" required></textarea>

            <label for="Category">Category:</label>
            <input type="text" id="Category" name="Category" required>

            <label for="SupplierID">Supplier ID:</label>
            <input type="text" id="SupplierID" name="SupplierID" required>

            <label for="OldPrice">Old Price:</label>
            <input type="number" id="OldPrice" name="OldPrice" step="0.01" required>

            <label for="SpecialPrice">Special Price:</label>
            <input type="number" id="SpecialPrice" name="SpecialPrice" step="0.01">

            <label for="QuantityInStock">Quantity In Stock:</label>
            <input type="number" id="QuantityInStock" name="QuantityInStock" required>

            <label for="DateAdded">Date Added:</label>
            <input type="date" id="DateAdded" name="DateAdded" required>

            <label for="Discount">Discount:</label>
            <input type="number" id="Discount" name="Discount" step="0.01">

            <label for="Image">Image:</label>
            <input type="file" id="Image" name="Image/*" required>

            <label for="Rating">Rating:</label>
            <input type="number" id="Rating" name="Rating" step="0.1">

            <label for="Status">Status:</label>
            <input type="text" id="Status" name="Status" required>

            <label for="Brand">Brand:</label>
            <input type="text" id="Brand" name="Brand" required>

            <input type="submit" value="Add Product">
        </form>

        <!-- Display the list of products -->
        <h2>Product List</h2>
        <?php if (count($products) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Supplier ID</th>
                        <th>Old Price</th>
                        <th>Special Price</th>
                        <th>Quantity In Stock</th>
                        <th>Date Added</th>
                        <th>Discount</th>
                        <th>Image URL</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Brand</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['ProductName']); ?></td>
                            <td><?php echo htmlspecialchars($product['Description']); ?></td>
                            <td><?php echo htmlspecialchars($product['Category']); ?></td>
                            <td><?php echo htmlspecialchars($product['SupplierID']); ?></td>
                            <td><?php echo htmlspecialchars($product['OldPrice']); ?></td>
                            <td><?php echo htmlspecialchars($product['SpecialPrice']); ?></td>
                            <td><?php echo htmlspecialchars($product['QuantityInStock']); ?></td>
                            <td><?php echo htmlspecialchars($product['DateAdded']); ?></td>
                            <td><?php echo htmlspecialchars($product['Discount']); ?></td>
                            <td><?php echo htmlspecialchars($product['ImageURL']); ?></td>
                            <td><?php echo htmlspecialchars($product['Rating']); ?></td>
                            <td><?php echo htmlspecialchars($product['Status']); ?></td>
                            <td><?php echo htmlspecialchars($product['Brand']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
