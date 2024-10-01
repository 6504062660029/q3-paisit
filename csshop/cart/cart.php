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
        /* Add your styles here */
        .cart-container {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        .cart-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-container table th,
        .cart-container table td {
            padding: 12px 15px;
            text-align: center;
        }

        .cart-container table th {
            background-color: #f2f2f2;
            color: #333;
        }

        .cart-container table td {
            border-bottom: 1px solid #ddd;
        }

        .cart-container input[type="number"] {
            width: 60px;
            padding: 5px;
        }

        .cart-container .btn {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .cart-container .btn:hover {
            background-color: #45a049;
        }

        .cart-container .total {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            padding: 20px 0;
        }

        .cart-container .action-links {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .cart-container .action-links a {
            text-decoration: none;
            color: #007BFF;
            transition: color 0.3s;
        }

        .cart-container .action-links a:hover {
            color: #0056b3;
        }
    </style>
    <script>
        function update(pid) {
            const qty = document.getElementById(pid).value;
            window.location.href = `?action=update&pid=${pid}&qty=${qty}`;
        }
    </script>
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
            <h1>Cart</h1>
            <div class="cart-container">
                <?php
                session_start();

                if (!isset($_SESSION['username'])) {
                    header("Location: login-form.php");
                    exit();
                }

                $username = $_SESSION['username'];
                $stmt = $pdo->prepare("SELECT type FROM member WHERE username = :username");
                $stmt->execute(['username' => $username]);
                $user = $stmt->fetch();

                if ($_GET["action"] == "add") {
                    $pid = $_GET['pid'];
                    $stmt = $pdo->prepare("SELECT stock FROM product WHERE pid = :pid");
                    $stmt->execute(['pid' => $pid]);
                    $product = $stmt->fetch();
                    $stock = $product['stock'];
                    $qty = $_POST['qty'];

                    $cart_item = array(
                        'pid' => $pid,
                        'pname' => $_GET['pname'],
                        'price' => $_GET['price'],
                        'qty' => $_POST['qty']
                    );

                    if (empty($_SESSION['cart'])) {
                        $_SESSION['cart'] = array();
                    }

                    if (array_key_exists($pid, $_SESSION['cart'])) {
                        $_SESSION['cart'][$pid]['qty'] += $_POST['qty'];
                        if ($_SESSION['cart'][$pid]['qty'] > $stock) {
                            echo "จำนวนสินค้าที่เลือกมากกว่าสินค้าคงเหลือ!";
                            exit();
                        }
                    } else {
                        $_SESSION['cart'][$pid] = $cart_item;
                    }
                } else if ($_GET["action"] == "update") {
                    $pid = $_GET["pid"];
                    $qty = $_GET["qty"];
                    $stmt = $pdo->prepare("SELECT stock FROM product WHERE pid = :pid");
                    $stmt->execute(['pid' => $pid]);
                    $product = $stmt->fetch();
                    $stock = $product['stock'];

                    if ($qty > $stock) {
                        echo "จำนวนที่เลือกมากกว่าสินค้าคงเหลือ!";
                        exit();
                    }

                    $_SESSION['cart'][$pid]['qty'] = $qty;
                } else if ($_GET["action"] == "delete") {
                    $pid = $_GET['pid'];
                    unset($_SESSION['cart'][$pid]);
                }
                ?>
                <form>
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sum = 0;
                            foreach ($_SESSION["cart"] as $item) {
                                $sum += $item["price"] * $item["qty"];
                                $stmt = $pdo->prepare("SELECT stock FROM product WHERE pid = :pid");
                                $stmt->execute(['pid' => $item['pid']]);
                                $product = $stmt->fetch();
                                $stock = $product['stock'];
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($item["pname"]) ?></td>
                                    <td><?= htmlspecialchars($item["price"]) ?> บาท</td>
                                    <td>
                                        <input type="number" id="<?= htmlspecialchars($item["pid"]) ?>" value="<?= htmlspecialchars($item["qty"]) ?>" min="1" max="<?= htmlspecialchars($stock) ?>">
                                    </td>
                                    <td><?= htmlspecialchars($item["price"] * $item["qty"]) ?> บาท</td>
                                    <td>
                                        <a href="#" class="btn" onclick="update(<?= htmlspecialchars($item['pid']) ?>)">Update</a>
                                        <a href="?action=delete&pid=<?= htmlspecialchars($item["pid"]) ?>" class="btn" style="background-color: #e74c3c;">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <div class="total">
                        Total: <?= $sum ?> บาท
                    </div>
                </form>

                <div class="action-links">
                    <a href="./store.php">&lt; Continue Shopping</a>
                    <?php if ($user['type'] == 'admin') : ?>
                        <a href="stock.php">View Stock</a>
                    <?php endif; ?>
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
