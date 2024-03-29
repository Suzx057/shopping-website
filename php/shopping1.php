<!DOCTYPE html>
<html lang="en">
<?php include './connect.php'; 
 session_start();?>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/shop1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<script>
function send() {
    request = new XMLHttpRequest();
    request.onreadystatechange = show1;
    var keyword = document.getElementById("search1").value;
    var url = "search.php?keyword=" + keyword;
    request.open("GET", url, true);
    request.send(null);
}
function show1(){
    if(request.readyState == 4 ){
        if (request.status == 200) {
            document.getElementById("list").innerHTML = request.responseText;
        }
        
    }
}
</script>
<body>
        <div class="shopping">
            <div class="header">
                <a class="logo" href="../php/main.php"><i class="ri-cactus-line"></i><span>My Cactus</span></a>
                <div class="search" >
                    <input type="text" placeholder="Search..." id="search1" name="search1" onkeyup="send()">
                </div>
                <div class="to_cart">
                    <a class="cart" href="./cart.php"><i class="fa-solid fa-cart-shopping"></i><p>Cart</p></a>
                </div>
            </div>
            <h2>ALL PRODUCT</h2>

            <div class="img-head">
                <img src='../image/sl1.jpg'>
                <!-- <img src="img/1.jpg"> -->
            </div>
            <?php include './config.php';
            unset($_SESSION['specise_id']); 
            if (!empty($_GET["pdetail"])&&!empty($_GET["counter"])) {
                $pname = $_GET["pdetail"];
                    $stmt = $pdo->prepare("SELECT *,specise.specise_id,specise.sname FROM product JOIN specise ON specise.specise_id = product.specise_id WHERE product.pdetail = ?;");
                    $stmt->execute([$pname]); 
            }else{
            $stmt = $pdo->prepare("SELECT *,specise.specise_id,specise.sname FROM product JOIN specise ON specise.specise_id = product.specise_id ");
                        $stmt->execute(); 
                        
            }
            ?>
           <div class="list" id="list">
                <?php $counter = 1; 
                
                while($row = $stmt->fetch()):?> 
                <div class="item" data-key="<?= $counter ?>">
                    <form method="get" action="./cart.php" >
                        <div class="img">
                            <img src='../image/img_product/<?=$row["pname"]?>.jpg'>
                            <!-- <img src="img1.png" alt=""> -->
                        </div>
                        <div class="content"> 
                            
                            <div class="title">
                                <?=$row["pname"]?>
                            </div>

                            <div class="des">
                                <?=$row["pdetail"]?>
                            </div>
                            <div class="price">
                                <?=$row["price"]?> บาท
                            </div>
                            <input type="number" class="count" min="1" value="1"><br>
                            <a href="cart.php?action=add&product_id=<?= $row['product_id']?>&qty=1">Add to cart</a>
                        
                        </div>
                    </form>
                </div>
                <?php  $counter++; endwhile;?>    

            </div>

        </div>

        


    <script src="../js/js2.js"></script>
</body>
</html>