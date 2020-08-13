<?php


function redirect($location){
    header("Location: $location");
}

function query($sql){
    global $connection;
    return mysqli_query($connection, $sql);
}

function confirm($result){
    global $connection;
    if(!$result){
        die ("QUERY FAILED: " . mysqli_error($connection));
    }
}

function escape_string($string){
    global $connection;
    return mysqli_real_escape_string($connection, $string);
}

function fetch_array($result){
    return mysqli_fetch_array($result);
}


//************************* FRONT END FUNCTION start ************************************

// GET PRODUCTS
function get_product(){
    $query = query("SELECT * FROM products");
    confirm($query);
    while($row = fetch_array($query)){
        $product = <<<DELIMITER
        <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <a href="item.php?id={$row['product_id']}"><img src="{$row['product_image']}" alt=""></a>
                            <div class="caption">
                                <h4 class="pull-right">{$row['product_price']}</h4>
                                <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a></h4>
                                <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                                    <a class="btn btn-primary" href="cart.php?add={$row['product_id']}">Add to cart</a>
                            </div>
                            <div class="ratings">
                                <p class="pull-right">15 reviews</p>
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                </p>
                            </div>
                        </div>
            </div>
        DELIMITER;
        echo $product;
    }
}

function get_category(){
    $query = query("SELECT * FROM categories");
    confirm($query);
    while($row = fetch_array($query)){
        $categories_links = <<<DELIMITER
            <a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>
        DELIMITER;
        echo $categories_links;
    }
}

//GET CATEGORY WISE PRODUCTS
function get_products_in_cat_page(){
    $query = query("SELECT * FROM products WHERE product_category_id = " . escape_string($_GET['id']) . " ");
    confirm($query);

    while($row = fetch_array($query)){
        $categorisedProduct = <<<DELIMITER
        <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="thumbnail">
                <a href="category.php?id={$row['product_id']}"><img src="{$row['product_image']}" alt=""></a>
                    <div class="caption">
                        <h4 class="pull-right">{$row['product_price']}</h4>
                        <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a></h4>
                        <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                        <a class="btn btn-primary" href="cart.php?add={$row['product_id']}">Add to cart</a>
                    </div>
                    <div class="ratings">
                    <p class="pull-right">15 reviews</p>
                    <p>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                    </p>
                </div>
            </div>
        </div>
        DELIMITER;

        echo $categorisedProduct;
    }
}

//GET PRODUCTS ACROSS SHOP
function get_products_in_shop_page(){
    $query = query("SELECT * FROM products");
    confirm($query);

    while($row = fetch_array($query)){
        $shopProducts = <<<DELIMITER
        <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="thumbnail">
                <a href="category.php?id={$row['product_id']}"><img src="{$row['product_image']}" alt=""></a>
                    <div class="caption">
                        <h4 class="pull-right">{$row['product_price']}</h4>
                        <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a></h4>
                        <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                        <a class="btn btn-primary" href="cart.php?add={$row['product_id']}">Add to cart</a>
                    </div>
                    <div class="ratings">
                    <p class="pull-right">15 reviews</p>
                    <p>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                    </p>
                </div>
            </div>
        </div>
        DELIMITER;

        echo $shopProducts;
    }
}

//************************* FRONT END FUNCTION stop ************************************

//************************* LOGIN FUNCTION start ************************************
// Generates message if wrong inputs given
function set_message($msg){
    if(!empty($msg)) {
        $_SESSION['message'] = $msg;
    }
}

// Displays message if wrong inputs given
function display_message(){
    if(isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

// Logs in the user
function login_user(){
    if(isset($_POST['submit'])){
        $username = escape_string($_POST['username']);
        $password = escape_string($_POST['password']);

        $query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}'");
        confirm($query);
    
        if(mysqli_num_rows($query) == 0){
            set_message("Username/Password doesn't exists");
            redirect("login.php");
        } else {
            redirect("admin");
        }
    }
}

//************************* LOGIN FUNCTION end ************************************

//************************* CONTACT FUNCTION start ************************************
function send_message(){
    if(isset($_POST['submit'])){

        $to = "mohittomar13@gmail.com";
        $from_name = $_POST['name'];
        $subject = $_POST['subject'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $headers = "From: {$from_name} - {$email}: {$subject}";

        $result = mail($to, $subject, $message, $headers);

        if(!$result){
            echo "ERROR";
        } else {    
            echo "SENT";
        }
    } 
}
//************************* CONTACT FUNCTION end ************************************

?>