<?php

# include the are.na api library 
include('../arena.php');

# create a new arena connection object
$api = new ArenaAPi();

#get the channel you want to show
$page_channel = $api->get_channel('paperweight-publishers');

$channel_content = $api->filter_channel_content($page_channel);
?>

<html>

    <head>
        <title><?php echo ($page_channel['title']); ?>: An Arena Channel</title>
        <meta charset='utf-8' />
        <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible' />
        <link href="example.css" media="screen" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div id="channel">
            <h1 id="channel-title"><?php echo ($page_channel['title']); ?>: An Arena Channel</h1>
            <div id="channel-blocks">
                <?php __::each($channel_content, function($block) { ?>

                    <? if ($block['type'] == "block") { ?>
                    <div class="block" style="margin: 15px 10px;"> 
                        <h2 class="block-title">
                            <a href="<?php echo($block['source_url']); ?>"><?php echo($block['title']); ?></a>
                        </h2>
                        
                            <div class="block-meta">
                                By <?php echo($block['username']); ?> 
                                on <?php echo($block['readable_updated_at']); ?>
                            </div>
 
                        <div class="block-content">
                        
                            <?php if ($block['image_display']){ ?>
                                <img class = "block-display-image" src="<?php echo($block['image_display']); ?>" />
                            <?php } ?>

                            <?php if ($block['description']){ ?>
                                <div class="block-description"><?php echo($block['description']); ?>" </div>
                            <?php } ?>

                        </div>
                        <?php if (!empty($block['connections'])) { ?>
                        <div id="block-connections">
                        <h2>Connections</h2>
                            <?php __::each($block['connections'], function($connection) { ?>
                                <div class="connection">
                                    This <?php echo($connection['connectable_type']);?> is part of the channel 
                                        <a target="_blank" href="http://are.na/#<?php echo($connection['channel']['slug']); ?>">
                                            <?php echo($connection['channel']['title']); ?>
                                        </a>
                                </div>
                            <?php }); ?>
                        </div>
                        <?php } ?>  
                
                </div>
                    <?php } ?> <!--end block-->  
                <?php }); // end underscore loop ?> 
            </div>
        </div>
    </body>

</html>
