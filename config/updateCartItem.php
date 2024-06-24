<?php
session_start();

// Update the cart quantity
if (isset($_GET['productID']) && isset($_GET['action'])) {
    $productId = $_GET['productID'];
    $action = $_GET['action'];

    if ($action == 'inc') {
        $_SESSION['cart'][$productId]++;
    } elseif ($action == 'dec' && $_SESSION['cart'][$productId] > 1) {
        $_SESSION['cart'][$productId]--;
    }

    // Redirect back to the cart page
    header('Location: ../pages/cartPage.php');
    exit;
}
?>