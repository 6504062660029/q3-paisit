
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
	
			// 1. กำหนดคำสั่ง SQL ให้ดึงสินค้าตามรหัสสินค้า
            $stmt = $pdo->prepare("SELECT * FROM product WHERE pid = ?");
            $stmt->bindParam(1, $_GET["pid"]);  // 2. นำค่า pid ที่ส่งมากับ URL กำหนดเป็นเงื่อนไข        
            $stmt->execute(); 	// 3. เริ่มค้นหา
            $row = $stmt->fetch();	// 4. ดึงผลลัพธ์ (เนื่องจากมีข้อมูล 1 แถวจึงเรียกเมธอด fetch เพียงครั้งเดียว)
		?>
		<a href="cart.php?action=">สินค้าในตะกร้า (<?=sizeof($_SESSION['cart'])?>)</a>
            <div style="display:flex">
            <div>
                <img src='../propho/<?=$row["pid"]?>.jpg' width='200'>
            </div>
            <div style="padding: 15px">
                <h2><?=$row["pname"]?></h2>
                รายละเอียดสินค้า: <?=$row["pdetail"]?><br>
                ราคาขาย <?=$row["price"]?> บาท<br>
                <form method="post" action="cart.php?action=add&pid=<?=$row["pid"]?>&pname=<?=$row["pname"]?>&price=<?=$row["price"]?>">
                    <input type="number" name="qty" value="1" min="1" max="9">
                    <input type="submit" value="ซื้อ">	   
                </form>
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























