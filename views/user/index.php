
    <?php
    // Header
    include_once('layout/header.php');
    ?>
    <!-- Content -->
     <div class="container-fuild mx-auto">
        <?php foreach($products as $product){ ?>
            <li><?php echo $product['productName'] ?></li>
        <?php } ?>
     </div>
    <?php
    // Footer
    include_once('layout/footer.php');
    ?>