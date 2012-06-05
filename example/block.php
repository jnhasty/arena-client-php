<?php

# include the are.na api library 
include('../arena.php');

# create a new arena connection object
$api = new ArenaAPi();

#get the channel you want to show
$block = $api->get_block_by_id(635);
$block_type = key($block);

?>

<html>
    <head>
        <title><?php echo($block[$block_type]['title']); ?></title>
        <meta charset='utf-8' />
        <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible' />
        <link href="example.css" media="screen" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div class="block" style="margin: 15px;"> 
            <h2 class="block-title">
                <a href="<?php echo($block[$block_type]['source_url']); ?>"><?php echo($block[$block_type]['title']); ?></a>
            </h2>
            <div class="block-content">
            
                <?php if ($block[$block_type]['image_display']){ ?>
                    <img class = "block-display-image" src="<?php echo($block[$block_type]['image_display']); ?>" />
                <?php } ?>

                <?php if ($block[$block_type]['description']){ ?>
                    <div class="block-description"><?php echo($block[$block_type]['description']); ?>" </div>
                <?php } ?>

            </div>
        </div>  
    </body>

</html>

