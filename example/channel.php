<?php

# include the are.na api library 
include('../arena.php');

# create a new arena connection object
$api = new ArenaAPi();

#get the channel you want to show
$page_channel = $api->get_channel_by_slug('experimental-interface');

?>

<html>

    <head>
        <title><?php echo ($page_channel['title']); ?></title>
        <meta charset='utf-8' />
        <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible' />
        <link href="example.css" media="screen" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div id="channel">
            <h1 id="channel-title"><?php echo ($page_channel['title']); ?></h1>
            <div id="channel-blocks">
                <?php __::each($page_channel['blocks'], function($block) { ?>
                    <div class="block" style="margin: 15px 10px;"> 
                        <h2 class="block-title">
                            <a href="<?php echo($block['source_url']); ?>"><?php echo($block['title']); ?></a>
                        </h2>
                        <div class="block-content">
                        
                            <?php if ($block['image_display']){ ?>
                                <img class = "block-display-image" src="<?php echo($block['image_display']); ?>" />
                            <?php } ?>

                            <?php if ($block['description']){ ?>
                                <div class="block-description"><?php echo($block['description']); ?>" </div>
                            <?php } ?>

                        </div>
                    </div>  
                <?php }); ?>
            </div>
        </div>
    </body>

</html>
