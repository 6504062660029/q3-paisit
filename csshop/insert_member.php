
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
        <h1>Members</h1>
        <div style="display:flex">
        <?php
        try {
            
            $stmt = $pdo->prepare("INSERT INTO member (username, password, name, address, mobile, email) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $_POST["username"]);
            $stmt->bindParam(2, $_POST["password"]);
            $stmt->bindParam(3, $_POST["name"]);
            $stmt->bindParam(4, $_POST["address"]);
            $stmt->bindParam(5, $_POST["mobile"]);
            $stmt->bindParam(6, $_POST["email"]);
            $stmt->execute();

            
            $username = $_POST["username"];

            
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                $upload_dir = './memberphoto/';  
                $file_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $allowed_extensions = ['jpg', 'jpeg', 'png'];  

            
                if (in_array(strtolower($file_extension), $allowed_extensions)) {
                    
                    $new_filename = $username . '.' . $file_extension;
                    $destination = $upload_dir . $new_filename;  

                    
                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                        echo "เพิ่มสมาชิกสำเร็จ username คือ " . $username;
                        echo "<br> รูปภาพถูกอัปโหลดเรียบร้อยแล้ว";
                    } else {
                        echo "มีข้อผิดพลาดในการอัปโหลดรูปภาพ";
                    }
                } else {
                    echo "รูปภาพไม่ถูกต้อง รองรับเฉพาะไฟล์ประเภท JPG หรือ PNG";
                }
            } else {
                echo "เพิ่มสมาชิกสำเร็จ แต่ไม่มีการอัปโหลดรูปภาพ";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
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


