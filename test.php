<?php 
include('./arena.php');
include('./lib/Underscore.php/underscore.php');

$api = new ArenaAPi();
$my_channel = $api->get_channel($api->get_username());

?>

<html>

    <head>
    </head>

    <body>
        <div>
            <?php echo(var_dump($my_channel)); ?>
        </div>
    </body>
</html>

