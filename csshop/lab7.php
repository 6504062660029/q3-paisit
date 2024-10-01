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
    </style>
  </head>

  <body>

    <header>
      <div class="logo">
        <img src="cslogo.jpg" width="200" alt="Site Logo">
      </div>
      <h1 style="margin :auto">Lab7 SQL</h1>
    </header>

    <div class="mobile_bar">
      <a href="#"><img src="responsive-demo-home.gif" alt="Home"></a>
      <a href="#" onClick='toggle_visibility("menu"); return false;'><img src="responsive-demo-menu.gif" alt="Menu"></a>
    </div>

    <main>
    <article>
    <?php
    // Display product information
    $stmt = $pdo->prepare("SELECT * FROM product");
    $stmt->execute();
    echo "<h2>สินค้าทั้งหมด</h2>";
    echo "<table border='1px solid black'>";
    echo "<tr>
            <th>รหัสสินค้า</th>
            <th>ชื่อสินค้า</th>
            <th>รายละเอียดสินค้า</th>
            <th>ราคา</th>
          </tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>".
            "<td>".$row["pid"]."</td>".
            "<td>".$row["pname"]."</td>".
            "<td>".$row["pdetail"]."</td>".
            "<td>".$row["price"]."</td>".
            "</tr>";
    }
    echo "</table>";  

    // Display member information
    echo "<h2>ข้อมูลสมาชิก</h2>";
    $stmt = $pdo->prepare("SELECT name, mobile, email FROM member");
    $stmt->execute();
    echo "<table border='1px solid black'>";
    echo "<tr>
            <th>ชื่อ</th>
            <th>เบอร์โทรศัพท์</th>
            <th>อีเมล</th>
          </tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>".
            "<td>".$row["name"]."</td>".
            "<td>".$row["mobile"]."</td>".
            "<td>".$row["email"]."</td>".
            "</tr>";
    }
    echo "</table>"; // Correct table closure
    echo "<h2>สินค้าราคา 500 - 1000 บาท</h2>";
    $stmt = $pdo->prepare("SELECT * FROM product WHERE price >= 500 AND price <= 1000");
    $stmt->execute();
    echo "<table border='1px solid black'>";
    echo "<tr>
            <th>รหัสสินค้า</th>
            <th>ชื่อสินค้า</th>
            <th>รายละเอียดสินค้า</th>
            <th>ราคา</th>
          </tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>".
            "<td>".$row["pid"]."</td>".
            "<td>".$row["pname"]."</td>".
            "<td>".$row["pdetail"]."</td>".
            "<td>".$row["price"]."</td>".
            "</tr>";
    }
    echo "</table>"; 
    echo "<h2>สมาชิกที่มีชื่อขึ้นต้นด้วย 'บ'</h2>";
    $stmt = $pdo->prepare("SELECT * FROM member WHERE name LIKE 'บ%'");
    $stmt->execute();
    echo "<table border='1px solid black'>";
    echo "<tr>
            <th>ชื่อ</th>
            <th>เบอร์โทรศัพท์</th>
            <th>อีเมล</th>
          </tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>".
            "<td>".$row["name"]."</td>".
            "<td>".$row["mobile"]."</td>".
            "<td>".$row["email"]."</td>".
            "</tr>";
    }
    echo "</table>"; 
    echo "<h2>สมาชิกที่มีอีเมลเป็น 'gmail'</h2>";
    $stmt = $pdo->prepare("SELECT * FROM member WHERE email LIKE '%gmail%' ORDER BY username DESC");
    $stmt->execute();
    echo "<table border='1px solid black'>";
    echo "<tr>
            <th>ชื่อ</th>
            <th>เบอร์โทรศัพท์</th>
            <th>อีเมล</th>
            <th>ชื่อผู้ใช้</th>
          </tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>".
            "<td>".$row["name"]."</td>".
            "<td>".$row["mobile"]."</td>".
            "<td>".$row["email"]."</td>".
            "<td>".$row["username"]."</td>". 
            "</tr>";
    }
    echo "</table>"; 
    echo "<h2>ข้อมูลการสั่งซื้อ</h2>";
    $stmt = $pdo->prepare("SELECT member.name, orders.ord_date FROM member JOIN orders ON member.username = orders.username");
    $stmt->execute();
    echo "<table border='1px solid black'>";
    echo "<tr>
            <th>ชื่อสมาชิก</th>
            <th>วันที่สั่งซื้อ</th>
          </tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>".
            "<td>".$row["name"]."</td>".
            "<td>".$row["ord_date"]."</td>".
            "</tr>";
    }
    echo "</table>"; 
    echo "<h2>จาก w7 +ยอดรวมแต่ละรายการสั่งซื้อ(order)</h2>";
    $stmt = $pdo->prepare("
        SELECT 
            member.name, 
            orders.ord_date, 
            SUM(item.quantity) AS total_quantity, 
            SUM(product.price * item.quantity) AS total_price
        FROM 
            member 
        JOIN 
            orders ON member.username = orders.username 
        JOIN 
            item ON orders.ord_id = item.ord_id 
        JOIN 
            product ON product.pid = item.pid 
        GROUP BY 
            member.name, orders.ord_date
    ");
    $stmt->execute();
    echo "<table border='1px solid black'>";
    echo "<tr>
            <th>ชื่อ</th>
            <th>วันที่สั่งซื้อ</th>
            <th>จำนวนรวม</th>
            <th>ราคารวม</th>
          </tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>".
            "<td>".$row["name"]."</td>".
            "<td>".$row["ord_date"]."</td>".
            "<td>".$row["total_quantity"]."</td>".
            "<td>".$row["total_price"]." บาท</td>".
            "</tr>";
    }
    echo "</table>";
    echo "<h2>ข้อมูลจำนวนสินค้าที่ขาย</h2>";
    $stmt = $pdo->prepare("
        SELECT 
            product.pname, 
            SUM(item.quantity) AS total_quantity 
        FROM 
            product 
        JOIN 
            item ON product.pid = item.pid 
        GROUP BY 
            product.pname
    ");
    $stmt->execute();
    echo "<table border='1px solid black'>";
    echo "<tr>
            <th>ชื่อสินค้า</th>
            <th>จำนวนที่ขาย</th>
          </tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>".
            "<td>".$row["pname"]."</td>".
            "<td>".$row["total_quantity"]."</td>".
            "</tr>";
    }
    echo "</table>";
    echo "<h2>วันที่สั่งซื้อของแต่ละชนิดสินค้า</h2>";
    $stmt = $pdo->prepare("
        SELECT product.pname, orders.ord_date 
        FROM product 
        JOIN item ON product.pid = item.pid 
        JOIN orders ON item.ord_id = orders.ord_id 
        ORDER BY product.pname, orders.ord_date
    ");
    $stmt->execute();
    
    // Create a table to display results
    echo "<table border='1px solid black'>";
    echo "<tr>
            <th>ชื่อสินค้า</th>
            <th>วันที่สั่งซื้อ</th>
          </tr>";
    
    while ($row = $stmt->fetch()) {
        echo "<tr>".
            "<td>".$row["pname"]."</td>".
            "<td>".$row["ord_date"]."</td>".
            "</tr>";
    }
    
    echo "</table>";
    echo "<h2>ราคารวมของแต่ละชนิดสินค้า</h2>";
    $stmt = $pdo->prepare("
        SELECT product.pname, SUM(item.quantity * product.price) AS total_price
        FROM product 
        JOIN item ON product.pid = item.pid 
        GROUP BY product.pname
    ");
    $stmt->execute();
    
    
    echo "<table border='1px solid black'>";
    echo "<tr>
            <th>ชื่อสินค้า</th>
            <th>ราคารวม</th>
          </tr>";
    
    while ($row = $stmt->fetch()) {
        echo "<tr>".
            "<td>".$row["pname"]."</td>".
            "<td>".$row["total_price"]." บาท</td>".
            "</tr>";
    }
    
    echo "</table>";
    echo "<h2>รายได้รวมจากการสั่งซื้อของแต่ละสมาชิก</h2>";
    $stmt = $pdo->prepare("
        SELECT member.name, SUM(item.quantity * product.price) AS total_revenue
        FROM member 
        JOIN orders ON member.username = orders.username 
        JOIN item ON orders.ord_id = item.ord_id 
        JOIN product ON item.pid = product.pid 
        GROUP BY member.name
    ");
    $stmt->execute();
    
    // Create a table to display results
    echo "<table border='1px solid black'>";
    echo "<tr>
            <th>ชื่อสมาชิก</th>
            <th>รายได้รวม</th>
          </tr>";
    
    while ($row = $stmt->fetch()) {
        echo "<tr>".
            "<td>".$row["name"]."</td>".
            "<td>".$row["total_revenue"]." บาท</td>".
            "</tr>";
    }
    
    echo "</table>";
    echo "<h2>รายได้รวมตามวันที่สั่งซื้อ</h2>";
    $stmt = $pdo->prepare("
        SELECT orders.ord_date, SUM(item.quantity * product.price) AS total_revenue
        FROM orders 
        JOIN item ON orders.ord_id = item.ord_id 
        JOIN product ON item.pid = product.pid 
        GROUP BY orders.ord_date 
        ORDER BY orders.ord_date
    ");
    $stmt->execute();
    
    
    echo "<table border='1px solid black'>";
    echo "<tr>
            <th>วันที่สั่งซื้อ</th>
            <th>รายได้รวม</th>
          </tr>";
    
    while ($row = $stmt->fetch()) {
        echo "<tr>".
            "<td>".$row["ord_date"]."</td>".
            "<td>".$row["total_revenue"]." บาท</td>".
            "</tr>";
    }
    
    echo "</table>";
    echo "<h2>ข้อมูลนักเรียน (เรียงตามชื่อ) Lab7_1</h2>";
    $stmt = $pdo->prepare("SELECT * FROM student ORDER BY std_name ASC");
    $stmt->execute();
    echo "<table border='1px solid black'>";
    echo "<tr><th>รหัสนักเรียน</th><th>ชื่อ</th><th>จังหวัด</th></tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr><td>".$row["std_id"]."</td><td>".$row["std_name"]."</td><td>".$row["province"]."</td></tr>";
    }
    echo "</table>";

    
    echo "<h2>รหัสนักเรียนและชื่อ Lab7_2</h2>";
    $stmt = $pdo->prepare("SELECT std_id, std_name FROM student");
    $stmt->execute();
    echo "<table border='1px solid black'>";
    echo "<tr><th>รหัสนักเรียน</th><th>ชื่อ</th></tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr><td>".$row["std_id"]."</td><td>".$row["std_name"]."</td></tr>";
    }
    echo "</table>";

    
    echo "<h2>นักเรียนจากขอนแก่น Lab7_3</h2>";
    $stmt = $pdo->prepare("SELECT * FROM student WHERE province = 'ขอนแก่น'");
    $stmt->execute();
    echo "<table border='1px solid black'>";
    echo "<tr><th>รหัสนักเรียน</th><th>ชื่อ</th><th>จังหวัด</th></tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr><td>".$row["std_id"]."</td><td>".$row["std_name"]."</td><td>".$row["province"]."</td></tr>";
    }
    echo "</table>";

   
    echo "<h2>ข้อมูลวิชาสำหรับนักเรียนที่รหัส 5001100348 Lab7_4</h2>";
    $stmt = $pdo->prepare("SELECT course.course_id, course.title, course.credit 
                            FROM student 
                            JOIN register ON student.std_id = register.std_id 
                            JOIN course ON register.course_id = course.course_id 
                            WHERE student.std_id = '5001100348'");
    $stmt->execute();
    echo "<table border='1px solid black'>";
    echo "<tr><th>รหัสวิชา</th><th>ชื่อวิชา</th><th>หน่วยกิต</th></tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr><td>".$row["course_id"]."</td><td>".$row["title"]."</td><td>".$row["credit"]."</td></tr>";
    }
    echo "</table>";

    
    echo "<h2>รวมหน่วยกิตต่อคน Lab7_5</h2>";
    $stmt = $pdo->prepare("SELECT student.std_id, SUM(course.credit) AS total_credits 
                            FROM student 
                            JOIN register ON student.std_id = register.std_id 
                            JOIN course ON register.course_id = course.course_id 
                            GROUP BY student.std_id");
    $stmt->execute();
    echo "<table border='1px solid black'>";
    echo "<tr><th>รหัสนักเรียน</th><th>รวมหน่วยกิต</th></tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr><td>".$row["std_id"]."</td><td>".$row["total_credits"]."</td></tr>";
    }
    echo "</table>";

    ?>

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
     
  </body>
</html>