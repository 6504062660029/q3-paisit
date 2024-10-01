<?php include "connect.php" ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CS Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="mcss.css" rel="stylesheet" type="text/css" />
    <script src="mpage.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .product-details {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background-color: #f9f9f9;
            margin: 20px auto;
            width: 80%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .product-image img {
            max-width: 300px;
            border-radius: 8px;
        }

        .product-info {
            max-width: 60%;
        }

        .product-info h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .product-info p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .product-info p strong {
            color: #4CAF50;
        }

        .product-info .price {
            font-size: 20px;
            font-weight: bold;
            color: #e74c3c;
        }

        .back-link {
            display: block;
            margin: 20px 0;
            text-decoration: none;
            font-size: 16px;
            color: #007BFF;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #0056b3;
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">
            <img src="cslogo.jpg" width="200" alt="Site Logo">
        </div>
        <div class="search">
            <form>
                <input type="search" placeholder="Search the site...">
                <button>Search</button>
            </form>
        </div>
    </header>

    <div class="mobile_bar">
        <a href="#"><img src="responsive-demo-home.gif" alt="Home"></a>
        <a href="#" onClick='toggle_visibility("menu"); return false;'><img src="responsive-demo-menu.gif" alt="Menu"></a>
    </div>

    <main>
        <article>
            <?php
            if (isset($_GET['pid'])) {
                $stmt = $pdo->prepare("SELECT * FROM product WHERE pid = ?");
                $stmt->bindParam(1, $_GET['pid']);
                $stmt->execute();
                $row = $stmt->fetch();
            }
            ?>

            <?php if ($row): ?>
                <div class="product-details">
                    <div class="product-image">
                        <?php
                        $image_extensions = ['jpg', 'jpeg', 'png'];
                        $image_found = false;
                        foreach ($image_extensions as $ext) {
                            if (file_exists("./propho/{$row['pid']}.$ext")) {
                                echo "<img src='./propho/{$row['pid']}.$ext' alt='Product Image'>";
                                $image_found = true;
                                break;
                            }
                        }
                        if (!$image_found) {
                            echo "<img src='./propho/default.png' alt='Default Product Image'>";
                        }
                        ?>
                    </div>

                    <div class="product-info">
                        <h2>Product Details</h2>
                        <p><strong>Product Name:</strong> <?= htmlspecialchars($row["pname"]) ?></p>
                        <p><strong>Description:</strong> <?= htmlspecialchars($row["pdetail"]) ?></p>
                        <p class="price">Price: <?= htmlspecialchars($row["price"]) ?> บาท</p>
                    </div>
                </div>
            <?php else: ?>
                <p>Product details not found.</p>
            <?php endif; ?>

            <a href="./display_product.php" class="back-link">&lt; Back to Products</a>
        </article>

        <nav id="menu">
            <h2>Navigation</h2>
            <ul class="menu">
                <li class="dead"><a href="./index.php">Home</a></li>
                <li><a href="./display_product.php">All Products</a></li>
                <li><a href="./table_product.php">Table of All Products</a></li>
                <li><a href="./cart/store.php">Buy Products</a></li>
                <li><a href="./cart/cart.php">Cart</a></li>
                <li><a href="./member.php">All Member</a></li>
                <li><a href="./insert_product.html">Insert Products</a></li>
                <li><a href="./insert_member.html">Insert Member</a></li>
                <li><a href="./edit_member.php">Delete/edit Member</a></li>
                <li><a href="./edit_product.php">Delete/edit product</a></li>
                <li><a href="./workshop/ws1.php">Workshop1</a></li>
          <li><a href="./workshop/ws2.php">Workshop2</a></li>
          <li><a href="./workshop/ws3.php">Workshop3</a></li>
          <li><a href="./workshop/ws4.php">Workshop4</a></li>
          <li><a href="./workshop/ws5.php">Workshop5</a></li>
          <li><a href="./workshop/ws6.php">Workshop6</a></li>
          <li><a href="./workshop/ws7.php">Workshop7</a></li>
          <li><a href="./workshop/ws8.php">Workshop8</a></li>
          <li><a href="./workshop/ws9.php">Workshop9</a></li>
          <li><a href="./lab7.php">Lab7</a></li>
            </ul>
        </nav>

        <aside>
            <h2>Aside</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed blandit libero sit amet nunc ultricies, eu feugiat diam placerat. Phasellus tincidunt nisi et lectus pulvinar, quis tincidunt lacus viverra. Phasellus in aliquet massa. Integer iaculis massa id dolor venenatis scelerisque.</p>
        </aside>
    </main>

    <footer>
        <a href="#">Sitemap</a>
        <a href="#">Contact</a>
        <a href="#">Privacy</a>
    </footer>

</body>

</html>
