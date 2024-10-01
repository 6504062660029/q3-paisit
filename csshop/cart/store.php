<?php include "../connect.php" ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CS Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="../mcss.css" rel="stylesheet" type="text/css" />
    <script src="../mpage.js"></script>
    <style>
        article a {
            color: blue;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }

        .product-item {
            width: 200px;
            margin: 15px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .product-item:hover {
            transform: scale(1.05);
        }

        .product-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .product-item p {
            font-size: 16px;
            color: #333;
        }

        .product-item form {
            margin-top: 10px;
        }

        .product-item input[type="number"] {
            width: 50px;
            padding: 5px;
            margin-right: 10px;
        }

        .product-item input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .product-item input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">
            <img src="../cslogo.jpg" width="200" alt="Site Logo">
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
            <h1>Products</h1>
            <div>
                <?php session_start(); 
                if (!isset($_SESSION['username'])) {
                    // หากยังไม่ได้ล็อกอิน, เปลี่ยนเส้นทางไปยังหน้า login
                    header("Location: login-form.php");
                    exit();
                } 
                ?>
                <?php
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = array();
                }
                ?>

                <a href="cart.php?action=">สินค้าในตะกร้า (<?= sizeof($_SESSION['cart']) ?>)</a>
                <div class="product-container">
                    <?php
                    $stmt = $pdo->prepare("SELECT * FROM product");
                    $stmt->execute();
                    while ($row = $stmt->fetch()) {
                    ?>
                        <div class="product-item">
                            <a href="detail.php?pid=<?= $row["pid"] ?>">
                                <img src='../propho/<?= $row["pid"] ?>.jpg' alt="<?= $row["pname"] ?>">
                            </a>
                            <p><?= $row["pname"] ?></p>
                            <p><?= $row["price"] ?> บาท</p>
                            <form method="post" action="cart.php?action=add&pid=<?= $row["pid"] ?>&pname=<?= $row["pname"] ?>&price=<?= $row["price"] ?>">
                                <input type="number" name="qty" value="1" min="1" max="9">
                                <input type="submit" value="ซื้อ">
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </article>

        <nav id="menu">
            <h2>Navigation</h2>
            <ul class="menu">
                <li class="dead"><a href="../index.php">Home</a></li>
                <li><a href="../display_product.php">All Products</a></li>
                <li><a href="../table_product.php">Table of All Products</a></li>
                <li><a href="./store.php">Buy Products</a></li>
                <li><a href="./cart.php">Cart</a></li>
                <li><a href="../member.php">All Member</a></li>
                <li><a href="../insert_product.html">Insert Products</a></li>
                <li><a href="../insert_member.html">Insert Member</a></li>
                <li><a href="../edit_member.php">Delete/edit Member</a></li>
                <li><a href="../edit_product.php">Delete/edit product</a></li>
                <li><a href="../workshop/ws1.php">Workshop1</a></li>
                <li><a href="../workshop/ws2.php">Workshop2</a></li>
                <li><a href="../workshop/ws3.php">Workshop3</a></li>
                <li><a href="../workshop/ws4.php">Workshop4</a></li>
                <li><a href="../workshop/ws5.php">Workshop5</a></li>
                <li><a href="../workshop/ws6.php">Workshop6</a></li>
                <li><a href="../workshop/ws7.php">Workshop7</a></li>
                <li><a href="../workshop/ws8.php">Workshop8</a></li>
                <li><a href="../workshop/ws9.php">Workshop9</a></li>
                <li><a href="../lab7.php">Lab7</a></li>
            </ul>
        </nav>

        <aside>
            <h2>Aside</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed blandit libero sit amet nunc ultricies, eu feugiat diam placerat. Phasellus tincidunt nisi et lectus pulvinar, quis tincidunt lacus viverra. Phasellus in aliquet massa. Integer iaculis massa id dolor venenatis scelerisque.
                <br><br>
            </p>
        </aside>
    </main>

    <footer>
        <a href="#">Sitemap</a>
        <a href="#">Contact</a>
        <a href="#">Privacy</a>
    </footer>

</body>

</html>
