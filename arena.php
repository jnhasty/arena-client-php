<?php
/*
 * TODO 
 * + add try/catch to all methods
 * + get person who connected the block
 * + show other channels a block used in
 * + templates for list view etc
 *
 */ 

#bring in api settings
include(dirname(__FILE__).'/settings.php');

# include the underscore library for robust data handling (optional)
include(dirname(__FILE__).'/lib/Underscore.php/underscore.php');

class ArenaAPI {
    /*
     * A Simple Class for abstracting common calls to the Arena API.
     */ 

    #Global settings from settings.php
    public $username = USERNAME;
    public $extended_depth = EXTENDED_DEPTH;
    
    #the base arena api url
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
    function get_channel($channel){    
        /* returns metadata and blocks for a given channel as array */ 
        $call_url = $this->arena_api_url . 'channels/' . $channel;
        if ($this->extended_depth == True){
             $call_url = $call_url . '?depth=extended';
        }
        $channel_json = file_get_contents($call_url);
        $channel = json_decode($channel_json, true);
        return $channel;
    }

    # BLOCK SPECIFIC FUNCTIONS
    function get_blocks_for_channel($channel, $page = Null, $per = Null){    
        /* returns blocks for a given channel
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

    function get_block_by_id($block_id){    
        /* returns all data for a specific block as array */ 
        $call_url = $this->arena_api_url . 'blocks/' . $block_id;
        if ($this->extended_depth == True){
             $call_url = $call_url . '?depth=extended';
        }
        $block_json = file_get_contents($call_url);
        $block = json_decode($block_json, true);
        return $block;
    }


} # END ARENA API CLASS 

#debug tools
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
