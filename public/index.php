<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php")?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php include(TEMPLATE_FRONT . DS . "side_nav.php")?>

            <div class="col-md-9">

                <div class="row carousel-holder">
                    <?php include(TEMPLATE_FRONT . DS . "slider.php")?>
                </div>
<!------------------------------------------------------------------------------>
                <h1><?php echo $_SESSION['product_1']?></h1>
<!------------------------------------------------------------------------------>

                <div class="row">
                    <?php get_product()?>
                </div> <!--ROW ENDS-->
            </div>

        </div>

    </div>
    <!-- /.container -->
    
    <?php include(TEMPLATE_FRONT . DS . "footer.php")?>

   
