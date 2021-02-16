<div style="background-color: rgba(0, 0, 0, 0.4); border-radius: 15px 50px">

<?php

//fetch_item.php

include('database_connection.php');

$query = "
SELECT * FROM tbl_product ORDER BY id ASC
";

$statement = $connect->prepare($query);

if($statement->execute())
{
 $result = $statement->fetchAll();
 $output = '';
 foreach($result as $row)
 {
    /**echo $row["name"]."|".$row["price"]." |ID:".$row["id"]; **/
  $output .= '
  <div class="row">
    <div class="col-md-3" style="margin-top:1rem;">  
      <div style="border:1px solid #333; background-color: rgba(201, 76, 76, 0.3); border-radius:5px; padding:16px;" align="center">
        <br />
        <h4 style="color:white;" class="text-info">'.$row["name"].'</h4>
        <h4 class="text-danger">$ '.$row["price"].'</h4>
        <input type="hidden" name="quantity" id="quantity'.$row["id"].'" class="form-control" value="1" />
         
        <input type="hidden" name="hidden_name" id="name'.$row["id"].'" value="'.$row["name"].'" />
        <input type="hidden" name="hidden_price" id="price'.$row["id"].'" value="'.$row["price"].'" />
        <input type="button" name="add_to_cart" id="'.$row["id"].'" style="margin-top:5px;" class="btn btn-success btn-sm add_to_cart" value="Add to Cart" />
      </div>
    </div>

    <div class="col-md-9" style="margin-top:12px;">
      <p>'.$row["description"].'</p>
    </div>
  </div>
  ';
 }
 echo $output;
}
?>
  
</div>