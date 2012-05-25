<?php 
include('./arena.php');
$test = new ArenaAPi();
?>

<html>

    <head>
    </head>

    <body>
        <div>
            <?php echo(var_dump($test->get_channel('paperweight'))); ?>
        </div>
    </body>
</html>

