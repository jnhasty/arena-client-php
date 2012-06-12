<?php
/*
 * This is the arena php api interface. 
 * 
 * MODIFYING THIS PAGE COULD LEAD TO INCOMPATIBILITIES WITH FUTURE RELEASES
 *
 * Integration examples are  in examples/ directory
 *
 * TODO 
 * + get person who connected the block
 * + templates for list view etc
 * + channels within channels example
 * + example to find blocks position and neighbors within channel
 */ 

#bring in api settings
include(dirname(__FILE__).'/settings.php');

# include the underscore library for robust data handling (optional)
include(dirname(__FILE__).'/lib/underscore.php');

class ArenaAPI {
    /*
     * A Simple Class for abstracting common calls to the Arena API
     * and data manipulation tasks.
     * Returns values as associative arrays when possible
     *
     */ 

    #settings from settings.php
    var $username = MY_USERNAME;
    var $extended_depth = EXTENDED_DEPTH;
    
    #the base arena api url
    var $arena_api_url = 'http://are.na/api/v1/';

    ####
    # USER CHANNEL SPECIFIC FUNCTIONS
    ####
    function get_my_username(){    
        /* 
         * returns username as set in settings 
         */ 
        if (!$this->username){
            throw new Exception('Please provide a username slug in settings.php.');
        }    
        return $this->username;
    }

    function get_my_channels(){    
        /* 
         * returns all channels for the settings defined user as array 
         */
        if (!$sername){
            throw new Exception('Please provide a username slug in settings.php.');
        }        
        $user_channels_json = file_get_contents($this->arena_api_url.'channels?user='.$this->username);
        $user_channels = json_decode($user_channels_json, true);   
        return $user_channels;
    }

    function get_user_channel($user){
        /* 
         * returns all channels for an arena user 
         */  
        $user_channels_json = file_get_contents($this->arena_api_url.'channels?user='.$user);
        $user_channels = json_decode($user_channels_json, true);   
        return $user_channels;
    }
    
    ####
    # CHANNEL SPECIFIC FUNCTIONS
    ####
    function get_channel($channel){    
        /* 
         * returns metadata, blocks and channels for a given channel 
         */ 
        $call_url = $this->arena_api_url . 'channels/' . $channel;
        if ($this->extended_depth == True){
             $call_url = $call_url . '?depth=extended';
        }
        $channel_json = file_get_contents($call_url);
        $channel = json_decode($channel_json, true);
        return $channel;
    }

    function get_channel_meta($channel){    
        /* 
         * calls arena, returns metadata only for a given channel 
         */ 
        $call_url = $this->arena_api_url . 'channels/' . $channel;
        if ($this->extended_depth == True){
             $call_url = $call_url . '?depth=extended';
        }
        $channel_json = file_get_contents($call_url);
        $channel = json_decode($channel_json, true);
        #flatten the array, filter out all sub arrays
        function flatten($value) { return !is_array($value); }
        $channel_meta = array_filter($channel , 'flatten'); 
        return $channel_meta;
    }

    function filter_channel_meta($channel_array){    
        /* 
         * returns metadata for an existing channel array 
         */ 
        function flatten($value) { return !is_array($value); }
        $channel_meta = array_filter($channel_array , 'flatten'); 
        return $channel_meta;
    }

    function get_channel_content($channel, $page = Null, $per = Null){ 
        /* 
         * returns a channel's merged blocks and sub-channels merged 
         * NOTE: page and per doesn't work. 
         * arena api being built to accommodate
         *
         */ 
        $call_url = $this->arena_api_url . 'channels/' . $channel;
        if ($this->extended_depth == True){
             $call_url = $call_url . '?depth=extended';
        }
        if(isset($per)){
            $call_url = $call_url . '&per=' . $per;
        }
        if(isset($page)){
            $call_url = $call_url . '&page=' . $page;            
        }
        $channel_json = file_get_contents($call_url);
        $channel = json_decode($channel_json, true);
        $content = array_merge($channel['blocks'], $channel['channels']);
        return $content;
    }

     function filter_channel_content($channel_array){ 
         /*
          *  returns an existing channel array's blocks and sub-channels merged 
          */ 
        $content = array_merge($channel_array['blocks'], $channel_array['channels']);
        return $content;
    }

    function get_blocks_for_channel($channel, $page = Null, $per = Null){ 
        /*   
         * $channel = slug or id
         * $per = number of blocks to return
         * $page = page of results to return 
         */ 
        $call_url = $this->arena_api_url . 'blocks?channel=' . $channel;
        if(isset($per)){
            $call_url = $call_url . '&per=' . $per;
        }
        if(isset($page)){
            $call_url = $call_url . '&page=' . $page;            
        }
        if ($this->extended_depth == True){
             $call_url = $call_url . '&depth=extended';
        }
        $channel_json = file_get_contents($call_url);
        $channel = json_decode($channel_json, true);
        return $channel;
    }
    
    ####
    # BLOCK SPECIFIC FUNCTIONS
    ####

    function get_block_by_id($block_id){
        /* 
         * returns all data for a specific block as array
         */ 
        $call_url = $this->arena_api_url . 'blocks/' . $block_id;
        if ($this->extended_depth == True){
             $call_url = $call_url . '?depth=extended';
        }
        $block_json = file_get_contents($call_url);
        $block = json_decode($block_json, true);
        return $block;
    }

    function get_connections_for_block($block){
        /* 
         * takes a block as an array from an api call OR takes a block id 
         */
        if (gettype($block) == "array"){
            return($block['connections']);
        } else {
            $requested_block = $this->get_block_by_id($block);
            $block_key = key($requested_block);
            return $requested_block[$block_key]['connections'];
        }
    }

} # END ARENA API CLASS 

# debug stuff
function pretty_print_array($array){
    /*
     * Print out an array for easily seeing keys/values 
     */
    __::each($array, function($key, $value) {
        $key_type = (gettype($key));
        $val_type = (gettype($value));
        echo('<div style="text-align:left;">');
        
        if($key_type == "array"){
            echo ('<b>[' . $value . ']</b>');
            echo ('<div style="margin-left:25px;">');
            pretty_print_array($key); 
            echo ('</div>');    
        } else {
            echo ('<div>');
                echo ('<b>[' . $value . ']</b>');
                echo (': ');
                echo ($key);
                echo ('<br />');
            echo ('</div>');    
        }    
        echo("</div>");
    
    });
}


?>
