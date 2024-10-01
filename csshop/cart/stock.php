
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
      table {
        margin: auto;
        margin-top: 20px;
      }
      .btc {
        position: relative;
        bottom: 300px;
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
        <h1>รายละเอียดสินค้า</h1>
        <div >
		<?php session_start(); 
	
            if (!isset($_SESSION['username'])) {
                // หากยังไม่ได้ล็อกอิน, เปลี่ยนเส้นทางไปยังหน้า login
                header("Location: login-form.php");
                exit();
            }
            
            // ดึงชื่อผู้ใช้ที่ล็อกอิน
            $username = $_SESSION['username'];
            
            // ตรวจสอบสิทธิ์ของผู้ใช้
            $stmt = $pdo->prepare("SELECT type FROM member WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch();
            
            // หากผู้ใช้ไม่ใช่ admin ให้เปลี่ยนเส้นทางไปยังหน้าอื่น
            if ($user['type'] != 'admin') {
                echo "คุณไม่มีสิทธิ์เข้าถึงหน้านี้";
                exit();
            }
            
            // ดึงข้อมูลสินค้าทั้งหมดจากฐานข้อมูล
            $stmt = $pdo->prepare("SELECT pid, pname, price, stock FROM product");
            $stmt->execute();
            $products = $stmt->fetchAll();
		?>
        
        <div>
         
            <h2>สินค้าคงเหลือ</h2>
            <table border="1">
                <tr>
                    <th>รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>ราคา</th>
                    <th>จำนวนคงเหลือ</th>
                </tr>
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['pid']) ?></td>
                            <td><?= htmlspecialchars($product['pname']) ?></td>
                            <td><?= htmlspecialchars($product['price']) ?> บาท</td>
                            <td><?= htmlspecialchars($product['stock']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">ไม่มีข้อมูลสินค้า</td>
                    </tr>
                <?php endif; ?>
            </table>

            <a class="btc" href="./cart.php">กลับไปที่หน้า Cart</a>
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










