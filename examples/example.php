<?php include('../arena.php');
# set the post limit
# Null returns all posts
$per = 3;

#pagination
if (isset($_GET['page'])){
    $page = $_GET['page'];
} else {
    $page = 1;
}

# use this to set the next page number at the bottom page link
$next_page = $page + 1;

# create an arena connection and call for the posts
$arena = new ArenaAPi();

# make a call to the arena api to get the data
$user_string = 'john-michael-boling';
$user_channel = $arena->get_channel($user_string);
$profile_channel = $arena->get_user_channel($user_string);
$nav_channels = $arena->get_channel_channels($profile_channel);

# get the requested channel if one
$request_channel = $_GET['channel'];

if(isset($request_channel)){
    $content_channel= $arena->get_channel($request_channel);
    $content_blocks = $arena->get_channel_blocks($content_channel);
    $connections = $arena->get_channel_connections($content_channel);
} else {
    $content_blocks = $arena->get_channel_blocks($user_channel);
    $connections = $arena->get_channel_connections($user_channel);
}

# get sorted blocks to use as content
$sorted_blocks = $arena->sort_blocks_by_created($content_blocks);

?>

<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <!-- doc title set in js -->
    <title><?php echo($main_channel['user']['username']); ?></title>

    <!-- set client description in content here-->
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <link href="example.css" media="screen" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="wrapper">

        <div id="nav" class="scroll-pane">		
            <div id="nav-header">
                <a href="/"><?php echo($profile_channel['user']['username']); ?></a>
            </div>
            <div id="navigation">
                <ul>
                <?php __::each($nav_channels, function($channel) { ?>
                    <?php// pretty_print_array($channel); ?>

                    <li>
                        <a href="?channel=<?php echo($channel['slug']); ?>" class="results"><?php echo($channel['title']); ?></a>
                    </li>
                <?php }); ?>
                </ul>	
            </div>		
        </div>

        <div id="blocks">	
            <?php __::each($sorted_blocks, function($block) { ?>
                <div id="block">
                    <div id='block-title'></div>            
                    
                    <?php if ($block['block_class'] == 'image'){ ?>
                        <div class="entry image">		
                            <div class="entry-title" >
                                <h2> <?php echo($block['title']) ?> </h2>
                            </div>	
                            <div class="entry-content">
                                <a href="<?php echo($block['image_original']) ?>">
                                    <img src="<?php echo($block['image_display']) ?>">
                                </a>
                            </div>
                            <div class="entry-description">
                                <?php echo($block['description']) ?>
                            </div>
                        </div>
                    <?php } ?>
                
                    <?php if ($block['block_class'] == 'media'){ ?>
                        <div class="entry media">		
                            <div class="entry-title">
                                <h2> <?php echo($block['title']) ?> </h2>
                            </div>	
                            <div class="entry-content">
                                <?php echo($block['embed_html']) ?>
                            </div>
                            <div class="entry-description">
                                <?php echo($block['description']) ?>
                            </div>
                        </div>	
                    <?php } ?>
                
                    <?php if ($block['block_class'] == 'link'){ ?>
                        <div class="entry link">		
                            <div class="entry-title">
                                <h2> <?php echo($block['title']) ?> </h2>
                            </div>	
                            <div class="entry-content">
                                <a href="<?php echo($block['source_url']) ?>">
                                    <img src="<?php echo($block['image_display']) ?>">
                                </a>
                                <br />
                                <a href="<?php echo($block['source_url']) ?>">
                                    <?php echo($block['source_url']) ?>
                                </a>
                            </div>
                            <div class="entry-description">
                                <?php echo($block['description']) ?>
                            </div>
                        </div>	
                    <?php } ?>
                
                    <?php if ($block['block_class'] == 'text'){ ?>
                        <div class="entry text" >		
                            <div class="entry-title">
                                <h2> <?php echo($block['title']) ?> </h2>
                            </div>	
                            <div class="entry-content">
                                <p><?php echo($block['content']) ?></p>
                            </div>
                            <div class="entry-description">
                                <?php echo($block['description']) ?>
                            </div>
                        </div>
                    <?php } ?>

                </div>	
            <?php }); ?>
        </div>            
    	
        <div id="connections">
            <ul>
            <?php if(isset($connections)){
                 __::each($connections, function($connection) { ?>
                <li class="connection" >		
                    <a target="_blank" href="http://are.na/#/<?php echo($connection['channel']['slug']) ?>" id="connection-box"><?php echo($connection['channel']['title']) ?></a>
                </li>
                <?php });
            } ?>
            </ul>
    	</div>


    </div><!-- end wrapper div-->

</body>
    
</html>


