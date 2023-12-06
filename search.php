<!DOCTYPE html>
<html lang = "en">
         
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Products </title>
        <link rel="stylesheet" href="product-style.css">
    </head>
        
    <body>
        <main>

            <h1>
                Products
            </h1>




            <div id="shopBar">
                <div class="sortBy">
                    <h4>SORT BY</h4>
                    <select>
                        <option>Most Popular</option>
                        <option>Price (Lowest to Highest)</option>
                        <option>Price (Highest to Lowest)</option>
                        <option>Name (A to Z)</option>
                    </select>

                </div>
            </div>
            

<form class = "search_box" method="GET">
  <label class="search-label" for="search-term">Search:</label>
  <input type="text" name="search-term" id="search-term" />
  <input type="submit" value="Search" />
</form>

</html>
              
<?php

require_once("connectdb.php");

if (isset($_GET['search-term'])) {
  
    // sanitize user input to prevent SQL injection
    $search_term = filter_input(INPUT_GET, 'search-term', FILTER_SANITIZE_STRING);

  //Validating input:
  //so basicallu this stops person from inputting anything numbers or symbols.

    $invalid_input = "/[^a-zA-Z\s]/";
    if (preg_match($invalid_input, $search_term)){
      //error message
      echo "<div style=
              '
              border: 2px solid #000000; 
              background-color: #f0f0f0; 
              padding: 10px; 
              margin: 10px 350;
              text-align: center;
              color: #ff0000              
              '>";
      
      echo " <b> Invalid input </b>";
      echo "</div>";
    
    }
    // srching the table to find like terms to show results
    $query = "SELECT * FROM products WHERE product_name LIKE '%{$search_term}%' OR product_category LIKE '%{$search_term}%'";


    
  } else {
    $query = "SELECT * FROM products";
  }
  

$results = $db->query($query); 
                        foreach($results as $product) {
                        ?>
                            <div class="product-card" id="<?=$product["product_id"]?>"> <?= $product["product_name"] ?> 
                                <div>
                                <img src="product_img/<?= $product["ImageURL"] ?>" style="height: 100%; width: 100%; object-fit: contain";>
                                </div>
                                <div class="product-card-info">
                                <p class="product-card-name"> <?= $product["product_name"] ?> </p>
                                <p class="product-card-gender"> <?= $product["product_gender"] ?> </p>
                                <p class="product-card-price">£<?= $product["product_price"] ?> </p>
                                </div>
                            <!-- Add basket functionality here -->


                            <!-- ----------------------------- -->
                            </div>
                        <?php
                        }



// echo "<table>";
// echo "<tr><th>Product Name</th><th>Product Price</th><th>Product Colour</th><th>Product Gender</th><th>Product Category</th></tr>";

// while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//   echo "<tr>";

//   echo "<td>" . $row['product_name'] . "</td>";
//   echo "<td>" . $row['product_price'] . "</td>";
//   echo "<td>" . $row['product_colour'] . "</td>";
//   echo "<td>" . $row['product_gender'] . "</td>";
//   echo "<td>" . $row['CategoryID'] . "</td>";
//   echo "<td>" . $row['product_category'] . "</td>";

// }
// echo "</table>";
?>

