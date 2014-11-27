    <?php if($environment == 'development'): ?>
        <pre>debug:</pre>
        <pre><?php print_r($this); ?></pre>
    <?php endif; ?>

    <!-- Le javascript -->
    <script src="<?php echo $base_url.$assets ?>js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo $base_url.$assets ?>js/jquery.velocity.min.js"></script>
    <script src="<?php echo $base_url.$assets ?>js/velocity.ui.js"></script>
    <script src="<?php echo $base_url.$assets ?>js/bootstrap.js"></script>
    <script src="<?php echo $base_url.$assets ?>js/main.js"></script>
</body>
</html>

