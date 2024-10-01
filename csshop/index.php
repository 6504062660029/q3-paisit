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
        table {
            margin: auto;
        }

        .logout {
            border: 1px black solid;
            border-radius: 2px;
            color: red;
            position: relative;
            top: 20px;
            left: 700px;
            display: inline-block;
            text-align: center;
            padding: 10px;
            background: red;
            color: white;
            text-decoration: none;
            border: none;
        }

        .order {
            color: blue;
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
            <h1>Welcome</h1>

            <?php
            session_start();

            // Check if the user is logged in
            if (!isset($_SESSION['username'])) {
                // If not logged in, redirect to login page
                header("Location: ./cart/login-form.php"); // Redirect to your login page
                exit();
            }

            // Fetch the logged-in username
            $username = $_SESSION['username'];

            // Check user permissions
            $stmt = $pdo->prepare("SELECT type FROM member WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch();

            // Check if 'view_orders' parameter is passed (for Admin viewing orders)
            $view_orders_of = isset($_GET['view_orders']) ? $_GET['view_orders'] : null;

            if ($user['type'] == 'admin' && $view_orders_of) {
                // Admin viewing specific user's orders
                $stmt = $pdo->prepare("SELECT o.ord_id, o.username, o.ord_date, p.pname, i.quantity, p.price 
                                    FROM orders o
                                    JOIN item i ON o.ord_id = i.ord_id
                                    JOIN product p ON i.pid = p.pid
                                    WHERE o.username = :username");
                $stmt->execute(['username' => $view_orders_of]);
                $orders = $stmt->fetchAll();
            } elseif ($user['type'] == 'admin') {
                // Admin fetching all users' order counts
                $stmt = $pdo->prepare("SELECT username, COUNT(ord_id) as order_count 
                                    FROM orders 
                                    GROUP BY username");
                $stmt->execute();
                $orders = $stmt->fetchAll();
            } else {
                // Regular user fetching their own orders
                $stmt = $pdo->prepare("SELECT o.ord_id,o.username, o.ord_date, p.pname, i.quantity, p.price 
                                    FROM orders o
                                    JOIN item i ON o.ord_id = i.ord_id
                                    JOIN product p ON i.pid = p.pid
                                    WHERE o.username = :username");
                $stmt->execute(['username' => $username]);
                $orders = $stmt->fetchAll();
            }
            ?>

            <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                <h1 style="text-align:center; color: #333;">Welcome, <?= htmlspecialchars($username) ?>!</h1>

                <?php if ($user['type'] == 'admin' && !$view_orders_of): ?>
                    <h2 style="color: #333;">Order Counts by User</h2>
                    <table style="width: 100%; margin: 20px 0; border-collapse: collapse;">
                        <tr style="background-color: #f2f2f2;">
                            <th style="padding: 10px; border: 1px solid #ddd;">Username</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Order Count</th>
                        </tr>
                        <?php if (count($orders) > 0): ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($order['username']) ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;">
                                        <a class="order" href="?view_orders=<?= htmlspecialchars($order['username']) ?>" style="color: blue; text-decoration: underline; cursor: pointer;">
                                            <?= $order['order_count'] ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" style="padding: 10px; border: 1px solid #ddd; text-align:center;">No order data available</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                <?php elseif ($user['type'] == 'admin' && $view_orders_of): ?>
                    <h2 style="color: #333;">Orders of User: <?= htmlspecialchars($view_orders_of) ?></h2>
                    <table style="width: 100%; margin: 20px 0; border-collapse: collapse;">
                        <tr style="background-color: #f2f2f2;">
                            <th style="padding: 10px; border: 1px solid #ddd;">Order ID</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Username</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Date</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Product Name</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Quantity</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Price</th>
                        </tr>
                        <?php if (count($orders) > 0): ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $order['ord_id'] ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $order['username'] ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $order['ord_date'] ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $order['pname'] ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $order['quantity'] ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $order['price'] * $order['quantity'] ?> บาท</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="padding: 10px; border: 1px solid #ddd; text-align:center;">No orders available</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                <?php else: ?>
                    <h2 style="color: #333;">Your Orders</h2>
                    <table style="width: 100%; margin: 20px 0; border-collapse: collapse;">
                        <tr style="background-color: #f2f2f2;">
                            <th style="padding: 10px; border: 1px solid #ddd;">Order ID</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Username</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Date</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Product Name</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Quantity</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Price</th>
                        </tr>
                        <?php if (count($orders) > 0): ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $order['ord_id'] ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $order['username'] ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $order['ord_date'] ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $order['pname'] ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $order['quantity'] ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= $order['price'] * $order['quantity'] ?> บาท</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="padding: 10px; border: 1px solid #ddd; text-align:center;">No orders available</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                <?php endif; ?>

                <a class="logout" href="./cart/logout.php">ล็อกเอาท์</a>
            </div>
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
