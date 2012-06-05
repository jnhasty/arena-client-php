<?php
/*
 * TODO 
 * + add try/catch to all methods
 *
 */ 

#bring in api settings
include(dirname(__FILE__).'/settings.php');

# include the underscore library for robust data handling
include(dirname(__FILE__).'/lib/Underscore.php/underscore.php');

class ArenaAPI {

    public $username = USERNAME;
    public $arena_api_url = 'http://are.na/api/v1/';

    # USER CHANNEL SPECIFIC FUNCTIONS
    
    function get_username(){    
        /* returns username as set in settings */ 
        if (!$this->username){
            throw new Exception('Please provide a username slug in settings.php.');
        }    
        return $this->username;
    }

    function get_user_channels(){    
        /* returns all channels for a given user as array */
        if (!$this->username){
            throw new Exception('Please provide a username slug in settings.php.');
        }        
        $user_channels_json = file_get_contents($this->arena_api_url.'channels?user='.$this->username);
        $user_channels = json_decode($user_channels_json, true);   
        return $user_channels;
    }

    # CHANNEL SPECIFIC FUNCTIONS

    function get_channel_by_slug($channel_slug){    
        /* returns metadata and blocks for a given channel as array */ 
        $channel_json = file_get_contents($this->arena_api_url.'channels/'.$channel_slug);
        $channel = json_decode($channel_json, true);
        return $channel;
    }

    function get_channel_by_id($channel_id){    
        /* returns metadata and blocks for a given channel as array */ 
        $channel_json = file_get_contents($this->arena_api_url.'channels/'.$channel_slug);
        $channel = json_decode($channel_json, true);
        return $channel;
    }

    # BLOCK SPECIFIC FUNCTIONS

    function get_all_blocks_for_channel($channel_id){    
        /* returns all blocks for a given channel as array */
        $block_json = file_get_contents($this->arena_api_url.'blocks?channel='.$channel_id);
        $blocks = json_decode($block_json, true);
        return $blocks;
    }

    function get_block_by_id($block_id){    
        /* returns all data for a given block as array */ 
        $block_json = file_get_contents($this->arena_api_url.'blocks/'.$block_id);
        $block = json_decode($block_json, true);
        return $block;
    }


} # END ARENA API CLASS

?>

