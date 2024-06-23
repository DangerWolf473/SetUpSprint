<?php
    include "../includes/database.php" ; 
    // selecting all orders for the current user
    $sql = "SELECT * FROM Orders WHERE ClientID = ?" ;
    $stm = $connect->prepare($sql);
    $stm->execute([$_SESSION['ClientID']]);
    $orders = $stm->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($orders as $order) {
            // selecting all products from order
            $query = "SELECT P.ProductName ,P.ImageURL,OD.Subtotal,OD.Quantity FROM OrderDetail AS OD, Product AS P WHERE OrderID = ? AND P.ProductID = OD.ProductID";
            $stt = $connect->prepare($query);
            $stt->execute([$order['OrderID']]);
            $products = $stt->fetchAll(PDO::FETCH_ASSOC);
            
            // displaying all products from the current order
            foreach($products as $product){ ?>
                <tr>
                <td class="pr-i"><img src="../assets/images/<?php echo $product['ProductName']?>.jpg" alt="<?php echo $product['ProductName']?>" class="prd-img" style="width: 50px; height: 50px;"></td>
                    <td><?php echo $product['ProductName']?></td>
                    <td><?php echo $product['Quantity']?></td>
                    <td><?php echo $product['Subtotal']?> DT</td>
                    <td><?php echo $order['OrderDate']?></td>
                    <td><?php echo $order['OrderStatus']?></td>
                </tr>
            <?php } ?>
            <!-- order detail: total money -->
                <tr class="line">
                    <td>Total : </td>
                    <td><?php echo $order['TotalAmount']?> PKR</td>
                </tr>
    <?php } ?>
