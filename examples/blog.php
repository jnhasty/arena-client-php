<?php
/*
 * Arena Blog Example 
 */

# include the are.na api library 
include('../arena.php');

# set the post limit
# Null returns all posts
$per = 3;

#pagination
if (isset($_GET['page'])){
    $page = $_GET['page'];
} else {
    $page = 1;
}

#use this to set the next page number at the bottom page link
$next_page = $page + 1;

# create an arena connection and call for the posts
$api = new ArenaAPi();

#make a call to the arena api to get the data
$blog = $api->get_channel('paperweight-publishers');

#use filtering method to separate out blog metadata
$blog_meta = $api->filter_channel_meta($blog);

#use filtering method to separate out blog content
$blog_content= $api->filter_channel_content($blog);

# separate the blocks and sort them by updated date
# ideally, sorting like this would be done by the api
$contents = __::sortBy($blog['blocks'], function($block) { return -$block['readable_updated_at']; });

?>

<html>

    <head>
        <title><?php echo ($blog_meta['title']); ?>: A Blog</title>
        <meta charset='utf-8' />
        <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible' />
        <link href="example.css" media="screen" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div id="channel">
            <h1 id="channel-title">
                <a href = "blog.php">
                    <?php echo ($blog_meta['title']); ?>: A Blog
                </a>
            </h1>
            <div id="channel-blocks">
                <?php __::each($blog_content, function($content) { ?>
                    

                    <div class="block" style="margin: 15px 10px;"> 
                        <h2 class="block-title">
                            <a href="<?php echo($content['source_url']); ?>"><?php echo($content['title']); ?></a>
                        </h2>
                        <div class="block-meta">By <?php echo($content['username']); ?> on <?php echo($content['readable_updated_at']); ?></div>
                        <div class="block-content">
                            <?php if ($content['image_display']){ ?>
                                <img class = "block-display-image" src="<?php echo($content['image_display']); ?>" />
                            <?php } ?>

                            <?php if ($content['description']){ ?>
                                <div class="block-description"><?php echo($content['description']); ?>" </div>
                            <?php } ?>
                        </div>
                    
                        <?php if (!empty($content['connections'])) { ?>
                            <div id="block-connections">
                            <?php __::each($content['connections'], function($connection) { 
                            global $content; //bring content var into this function's scope 
                            ?>
                            <div class="connection">
                                This <?php echo($connection['connectable_type']);?> is also featured in: 
                                    <?php if( $connection['channel']['title'] != $content['channel']['title'] ) { ?>
                                        <a target="_blank" href="http://are.na/#<?php echo($connection['channel']['slug']); ?>">
                                            <?php echo($connection['channel']['title']); ?>
                                        </a>
                                    <?php } ?>
                            </div>
                            <?php }); ?>
                       <?php } ?>
                </div>
            </div>  
        <?php }); ?>
        </div>

        </div>
        <div id="blog-navigation">
            <?php if (isset($next_page)){ ?>
                <a href = "?page=<?php echo($next_page) ?>">Next >></a>
            <?php } else { ?>
                <a href = "blog.php">Home</a>
            <?php } ?>


    </body>
</html>
