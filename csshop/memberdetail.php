
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
      .flex-container {
        display: flex;
        margin: 10px;
        padding: 10px;
      }
      .text-details{
        margin: 10px;
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
        if (isset($_GET['username'])) {
            $stmt = $pdo->prepare("SELECT * FROM member WHERE username = ?");
            $stmt->bindParam(1, $_GET['username']);
            $stmt->execute();
            $row = $stmt->fetch();
        }
        ?>

        <?php if ($row): ?>
          <div class="flex-container">
            <div class="image-container">
                <?php
                $image_extensions = ['jpg', 'jpeg', 'png'];
                foreach ($image_extensions as $ext) {
                    if (file_exists("./memberphoto/{$row['username']}.$ext")) {
                        echo "<img src='./memberphoto/{$row['username']}.$ext' width='200'>";
                        break;
                    }
                }
                ?>
            </div>
            <div class="text-details">
                <h2>รายละเอียด</h2>
                ชื่อ: <?=$row["name"]?><br>
                ที่อยู่: <?=$row["address"]?><br>
                เบอร์โทรศัพท์: <?=$row["mobile"]?> <br>
                Email: <?=$row["email"]?> <br>
            </div>

        </div>
        <?php else: ?>
            <p>ไม่พบรายละเอียดสินค้า</p>
        <?php endif; ?>
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