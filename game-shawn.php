<!DOCTYPE html>
<html>
    <bodystyle = "text-align:center;">
        <form method="post">
            <input type="text" name="command">
            <input type="submit" name="commandSubmit"
            value="command"/>
        </form>
        <?php
//acceptable words
$player_inventory = array();
$player_commands = array("search", "use", "combine", "investigate", "hold", "help");
$items_player_can_hold = array("drawer_key", "door_key", "screwdriver", "note", "toothpick", "pliers", "tweezers", "lockpick");
$objects_player_can_investigate = array("white_board", "door", "drawer", "plant");
$list_of_containers = array("drawers", "painting", "plant", "safe"); // "pockets" gets added when you remember you can search them
$list_of_combinable_items = array("pliers", "tweezers");
$combined_items = array("lockpick");
//get the player input and verifies it then asks for correct input by calling help or calls the command with appropriate argument
function command_checker() {
    if (isset($_POST['commandSubmit'])) { 
        $player_input = $_POST["command"];
        $word_break = strpos($player_input, " ");
    }
    // breaks the input into two seperate words at the space and assigns the words to variables
    $word1 = substr($player_input, 0, $word_break);
    $word2 = substr($player_input, $word_break);
    //format for commands is (verb object)
    //checks if the first word is in the list of acceptable command words 
    $check_word1 = in_array($word1, $player_commands);
}
function use_item($item){
    if(inarray($item, $items_player_can_use)){
    }else{
        echo "You can't do that!";
    }
}
function search($item){
    if(inarray($item, $items_player_can_search)){
    }else{
        echo "You can't do that!";
    }
}
function investigate($item){
    if(inarray($item, $objects_player_can_investigate)){
    }else{
        echo "You can't do that!";
    }
}
function combine($item){
    $combineList = array(null, null);
    if($combineList[1] == null){
        $combineList[1] = $item;
    }else{
        $combineList[2] = $item;
        if(inarray($combineList[1], $player_inventory) and inarray($combineList[2], $player_inventory)){
            switch($combineList[1]){
                case “pliers”:
                if($combineList[2] == “tweezers”){
                    $index = array_search(“tweezers”, $player_inventory); 
                    if($index !== FALSE){ unset($player_inventory[$index]); }
                    $index = array_search(“pliers”, $player_inventory); 
                    if($index !== FALSE){ unset($player_inventory[$index]); }
                    array_push($player_inventory, “lockpick”);
                }else{
                    echo "You can't combine those!";
                }
                case “tweezers”:
                if($combineList[2] == “pliers”){
                    $index = array_search(“tweezers”, $player_inventory); 
                    if($index !== FALSE){ unset($player_inventory[$index]); }
                    $index = array_search(“pliers”, $player_inventory); 
                    if($index !== FALSE){ unset($player_inventory[$index]); }
                    array_push($player_inventory, “lockpick”);
                }else{
                    echo "You can't combine those!";
                }
                default:
                echo "You can't combine those!";
            }
            $combineList[1] = $combineList[2] = null;
        }else{
            echo "You don't have those items!";
        }
    }
}
function hold($item){
    if(inarray($item, $items_player_can_hold)){
        if(inarray($item, $player_ionventory)){
            $player_hand = $item;
        }else{
            echo "You don't have that!";
        }
    }else {
        echo "You can't hold that!";
    }
}
function help(){ 
    echo "In this room you see: ";
    foreach($objects_player_can_investigate as $value){
        echo $value . "<br>";
    }
    echo "Use commands: use, search, combine, investigate, hold, help";
}
//function call for testing place in main loop later when called reduce turns by 1
command_checker();
        ?>
    </html>