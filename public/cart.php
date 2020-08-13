<?php require_once("../resources/config.php"); ?>


<?php

if(isset($_GET['add'])){
    $query = query("SELECT * FROM products WHERE product_id = " . escape_string($_GET['add'] . " "));
    confirm($query);

    while($row = fetch_array($query)){
        if($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]){
            $_SESSION['product_' . $_GET['add']] += 1;
            redirect("checkout.php");
        } else {
            set_message("We only have {$row['product_quantity']} quantity available of: {$row['product_title']}");
            redirect("checkout.php");
        }
    }
}

if(isset($_GET['remove'])){
    $_SESSION['product_' . $_GET['remove']]--;
    if ($_SESSION['product_' . $_GET['remove']] < 1) {
        redirect("checkout.php");
    } else {
        redirect("checkout.php");
    }
}


if(isset($_GET['delete'])){
    $_SESSION['product_' . $_GET['delete']] = '0';                                                                                                                                                             ;
    redirect("checkout.php");
}

function cart(){
    $total = 0;
    $totalQty = 0;
    foreach($_SESSION as $name => $value){
        if($value > 0){    
            if(substr($name, 0, 8) == "product_"){
                $length = strlen($name) - 8;
                $id = substr($name, 8, $length);

                $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id) . " ");
                confirm($query);
            
                while($row = fetch_array($query)){
                    $sub = $row["product_price"] * $value;
                    $totalItems = 0;
                    $product = <<<DELIMITER
                    <tr>
                    <td>{$row["product_title"]}</td>
                    <td>{$row["product_price"]}</td>
                    <td>{$value}</td>
                    <td>$sub</td>
                    <td><a href="cart.php?add={$row['product_id']}">Add</a></td>
                    <td><a href="cart.php?remove={$row['product_id']}">Remove</a></td>
                    <td><a href="cart.php?delete={$row['product_id']}">Delete</a></td>
                    </tr>
                    DELIMITER;
            
                    echo $product;
                    $_SESSION['item_total'] = $total += $sub;
                    $_SESSION['item_quantity'] = $totalQty += $value;
                }
            }
        }
    }
    //$query = query("SELECT * FROM products WHERE product_id = " . $_SESSION[$_GET['add']] . " ");
}

?>
