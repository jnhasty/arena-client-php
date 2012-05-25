<?php
/*
 * TODO 
 * + add try/catch to all methods
 *
 * 
 */ 

include('./settings.php');

class ArenaAPI {

    public $username = USERNAME;
    public $arena_api_url = "http://are.na/api/v1/";

    function get_username(){    
        /* returns username as set in settings */ 
        return $this->username;
    }

    function get_user_channels(){    
        /* returns all channels for a given user */ 
        $user_channel_json = file_get_contents($this->arena_api_url.'channels?user='.$this->username);
        $user_channel = json_decode($user_channel_json, true);
        return $user_channel;
    }

    function get_channel($channel_name){    
        /* returns all data for a given channel */ 
        $channel_json = file_get_contents($this->arena_api_url.'channels/'.$channel_name);
        $channel = json_decode($channel_json, true);
        return $channel;
    }

    function get_all_blocks_for_channel($channel_id){    
        /* returns all blocks for a given channel */
        /* ???? is this diff than get_channel ???*/ 
        $block_json = file_get_contents($this->arena_api_url.'blocks?channel='.$channel_id);
        $blocks = json_decode($block_json, true);
        return $blocks;
    }

}

?>

