<?php
/*
 * TODO 
 * + add try/catch to all methods
 * + underscore.php only works php > 5.3, when include test for php version
 *
 * 
 */ 


include('./settings.php');
include('./lib/Underscore.php/underscore.php');


class ArenaAPI {

    public $username = USERNAME;
    public $arena_api_url = "http://are.na/api/v1/";

    function get_username(){    
        return $this->username;
    }

    function get_user_channels(){    
        $user_channel_json = file_get_contents($this->arena_api_url.'channels?user='.$this->username);
        $user_channel = json_decode($user_channel_json, true);
        return $user_channel;
    }

    function get_all_blocks_for_channel($channel_id){    
        $block_json = file_get_contents($this->arena_api_url.'blocks?channel='.$channel_id);
        $blocks = json_decode($block_json, true);
        return $blocks;
    }

    function get_channel($channel_name){    
        $block_json = file_get_contents($this->arena_api_url.'blocks?channel='.$channel_name);
        $blocks = json_decode($block_json, true);
        return $blocks;
    }


}

?>

