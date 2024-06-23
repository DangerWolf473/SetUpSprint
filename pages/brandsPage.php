<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SetUpSprint</title>
    <link rel="stylesheet" href="../assets/css/style1.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../assets/images/SetUpSprint.svg" type="image/icon type">
    <script src="assets/js/scripts.js"></script>
    <style>
      .brand-item {
            width: 200px; /* adjust the width and height to your liking */
            height: 200px;
            border: 1px solid #ddd;
            padding: 10px;
            display: inline-block;
            margin: 20px;
            background-color: black; /* Set a default background color */
        }
        .brand-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
    </style>
</head>
<body>
    <?php include "../includes/header.php"; ?>

    <section class="brands-list">
        <?php
        require_once "../includes/database.php";

        $query ="SELECT * FROM brand_logos";
        $stm = $connect->prepare($query);
        $stm->execute();

        $brands = $stm->fetchAll(PDO::FETCH_ASSOC);

        foreach($brands as $brand) {
            echo "<div class='brand-item'>
                    <img src='../assets/images/".$brand['LogoURL']."' alt='".$brand['BrandName']."' />
                    <h1>".$brand['BrandName']."</h1>
                  </div>";
        }
        ?>
    </section>

    <?php include "../includes/footer.php"; ?>
</body>
</html>
