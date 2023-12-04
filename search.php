
<form class = "search_box" method="GET">
  <label class="search-label" for="search-term">Search:</label>
  <input type="text" name="search-term" id="search-term" />
  <input type="submit" value="Search" />
</form>

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
  
$result = $db -> query($query);

echo "<table>";
echo "<tr><th>Product ID</th><th>Product Name</th><th>Product Price</th><th>Product Colour</th><th>Product Gender</th><th>Category ID</th><th>Product Category</th><th>Stock Level</th><th>Image URL</th><th>Description</th></tr>";

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
  echo "<tr>";
  echo "<td>" . $row['product_id'] . "</td>";
  echo "<td>" . $row['product_name'] . "</td>";
  echo "<td>" . $row['product_price'] . "</td>";
  echo "<td>" . $row['product_colour'] . "</td>";
  echo "<td>" . $row['product_gender'] . "</td>";
  echo "<td>" . $row['CategoryID'] . "</td>";
  echo "<td>" . $row['product_category'] . "</td>";
  echo "<td>" . $row['StockLevel'] . "</td>";
  echo "<td>" . $row['ImageURL'] . "</td>";
  echo "<td>" . $row['Description'] . "</td>";
  echo "</tr>";
}
echo "</table>";
?>

