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
$blog_info = $api->get_blocks_for_channel('experimental-interface', $page, $per);

# separate the blocks and sort them by updated date
# ideally, sorting like this would be done by the api
$blocks = __::sortBy($blog_info['blocks'], function($block) { return -$block['readable_updated_at']; });

# if we get to the end of the blog, send them back home
# super hacky. 
if (empty($blog_info['blocks'])){
    header('location: blog.php');
}

?>

<html>

    <head>
        <title><?php echo ($blog_info['channel']['title']); ?>: A Blog</title>
        <meta charset='utf-8' />
        <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible' />
        <link href="example.css" media="screen" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div id="channel">
            <h1 id="channel-title">
                <a href = "blog.php">
                    <?php echo ($blog_info['channel']['title']); ?>: A Blog
                </a>
            </h1>
            <div id="channel-blocks">
                <?php __::each($blocks, function($block) { ?>
                    <div class="block" style="margin: 15px 10px;"> 
                        <h2 class="block-title">
                            <a href="<?php echo($block['source_url']); ?>"><?php echo($block['title']); ?></a>
                        </h2>
                        <div class="block-meta">By <?php echo($block['username']); ?> on <?php echo($block['readable_updated_at']); ?></div>
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
        <div id="blog-navigation">
            <?php if (isset($next_page)){ ?>
                <a href = "?page=<?php echo($next_page) ?>">Go to page <?php echo($next_page) ?></a>
            <?php } else { ?>
                <a href = "blog.php">Home</a>
            <?php } ?>
        </div>
    </body>

</html>
