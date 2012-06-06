<?php

# include the are.na api library 
include('../arena.php');

#pass block id either by get variable or hardcoded
if (isset($_GET['block'])){
    $block_id = $_GET['block'];
} else {
    $block_id = 635;
}

# create a new arena connection object 
# and get the specified block
$api = new ArenaAPi();
$block = $api->get_block_by_id($block_id);

# what content type is the block
$block_type = key($block);

#separate block data into own array
$block_info = $block[$block_type];

//pretty_print_array($block_info);
?>

<html>
    <head>
        <title><?php echo($block[$block_type]['title']); ?>: An Arena Block</title>
        <meta charset='utf-8' />
        <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible' />
        <link href="example.css" media="screen" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div class="block" style="margin: 15px;"> 
            <h2 class="block-title">
                <a href="<?php echo($block_info['source_url']); ?>"><?php echo($block[$block_type]['title']); ?>: A Arena Block</a>
            </h2>
            <div class="block-meta">By <?php echo($block_info['username']); ?> on <?php echo($block_info['readable_updated_at']); ?></div>
            <div class="block-content">
            
                <?php if ($block_info['image_display']){ ?>
                    <img class = "block-display-image" src="<?php echo($block_info['image_display']); ?>" />
                <?php } ?>

                <?php if ($block_info['description']){ ?>
                    <div class="block-description"><?php echo($block_info['description']); ?>" </div>
                <?php } ?>

            </div>

            <?php if (!empty($block_info['connections'])) { ?>
                <div id="block-connections">
                <h2>Connections</h2>
                <?php __::each($block_info['connections'], function($connection) { ?>
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
    </body>

</html>
