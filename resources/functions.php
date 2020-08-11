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

function get_product(){
    $query = query("SELECT * FROM products");
    confirm($query);
    while($row = fetch_array($query)){
        $product = <<<DELIMITER
        <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <a href="item.php?id={$row['produt_id']}"><img src="{$row['product_image']}" alt=""></a>
                            <div class="caption">
                                <h4 class="pull-right">{$row['product_price']}</h4>
                                <h4><a href="product.html">{$row['product_title']}</a>
                                </h4>
                                <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                                    <a class="btn btn-primary" target="_blank" href="http://maxoffsky.com/code-blog/laravel-shop-tutorial-1-building-a-review-system/">Add to cart</a>
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

?>
