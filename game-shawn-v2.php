<!DOCTYPE html>
<html>
    <bodystyle = "text-align:center;">
        <form method="post">
            <input type="text" name="command">
            <input type="submit" name="commandSubmit"
            value="command"/>
        </form>
        <?php
$door_investigated = false;
$drawer_investigated = false;
$plant_investigated = false;
$painting_investigated = false;
$safe_investigated = false;
$drawer_locked = true;
$safe_locked = true;
$door_locked = true;
$player_timeLeft = 30;
$player_hand = "nothing";
//acceptable words
$player_inventory = array();
$player_commands = array("search", "use", "combine", "investigate", "hold", "help");
$items_player_can_hold = array("drawer_key", "office_key", "screwdriver", "toothpick", "pliers", "tweezers", "lockpick");
$objects_player_can_investigate = array("white_board", "door", "drawer", "painting", "plant", "safe");
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
function decrementTimer(){ $player_timeLeft -= 1;}
function use_item($item){
    if(inarray($item, $objects_player_can_investigate)){
        switch($item){
            case "white_board":
            echo "You can't use the white board";
            case "door":
            if($door_investigated){
                if($player_hand == "door_key"){
                    $door_locked = false;
                    echo "You use your key on the door!";
                }else{
                    echo "Using that did nothing, except waste time";
                }
            }else{
                echo "You can't open the door";
            }
            case "drawer":
            if($drawer_investigated){
                if($player_hand == "drawer_key"){
                    $drawer_locked = false;
                    echo "You use your key on the drawer";
                }else{
                    echo "Using that did nothing, except waste time";
                }
            }else{
                echo "You can't open the drawer";
            }
            case "plant":
            echo "You can't really find a use for the plant, other than making your office look slightly more bland somehow";
            case "painting":
            echo "You use the painting to motivate yourself to get out of the office quicker so you can live to see such a beautiful landscape in person";
            case "safe":
            if($safe_investigated){
                if($player_hand == "lockpick"){
                    $safe_locked = false;
                    echo "You use your lockpick on the safe and successfully pick it open after some considerable time";
                    decrementTimer(); decrementTimer(); decrementTimer();
                }else{
                    echo "Using that did nothing, except waste time";
                }
            }else{
                echo "You can't remember the combination to this safe at all";
            }
        }
        decrementTimer();
    }else{
        echo "You can't do that!";
    }
}
function search($item){
    if(inarray($item, $items_player_can_search)){
        switch($item){
            case "white_board":
            echo "You can't search the white board";
            case "door":
            echo "Why are you searching a door?";
            case "drawer":
            if(!$drawer_locked){
                echo "Inside your drawer you find a pair of pliers, a pair of tweezers, a toothpick, and a screwdriver";
                $player_inventory[] = "pliers";
                $player_inventory[] = "tweezers";
                $player_inventory[] = "toothpick";
                $player_inventory[] = "screwdriver";
            }else{
                echo "The drawer is locked and you can't search it";
            }
            case "plant":
            if($plant_investigated){
                echo "You find your spare drawer key under your plant";
                $player_inventory[] = "drawer_key";
            }else{
                echo "You aren't quite sure where to look, and making a mess in the dirt wouldn't help your case";
            }
            case "painting":
            echo "Searching the painting reveals a tiny duck, a happy little tree, and some rocks you never noticed before, but nothing else";
            case "safe":
            if($painting_investigated){
                if(!$safe_locked){
                    echo "You find your spare key in your safe!";
                    $player_inventory[] = "office_key";
                }else{
                    echo "You can't search your safe without getting it opened somehow!";
                }
            }else{
                echo "You can't reach your safe at the moment";
            }
            case "pocket":
            echo "You find your spare key in your pocket!";
            $player_inventory[] = "office_key";
        }
        decrementTimer();
    }else{
        echo "You can't do that!";
    }
}
function investigate($item){
    if(inarray($item, $objects_player_can_investigate)){
        switch($item){
            case "white_board":
            echo "w46uuuuuusr6t  Thursday the 12th usre6us4e65u4seu6s46u4\n5u5e08iksruj sertgzsrfhxyjgvhckm,vhjlugiyuilfujytftfyjdrtyjdrj\nsrxyjrdfxykjftcgukyctgvukjvtcg ujctjhrdsuytjrdsujrdyuq324 57ei75eit7fyui\nkfytiftiuftregr987ayr  g9awr   g978hthwrgs9hzw          sr9hsethszwpryj9zwrg9jhegr 4381 easrt\ngjhaesrg Dont forget to keep a jhawrtjlkerhsethsrehesr\nthresthrestghsedrtghsethsehaweflkh spare in your pocket! 245srsrhseths\n134etghset    hsretrthsehgsehgsehe         Shaaron's birthday on the 9th   shesthstehsethserhgsehsethtser   tryjkrtdfjresuj PR meeting (help) r6es4rewyrt";
            case "door":
            echo "Your door is locked, and with a VERY high security lock, you're going to have to find a spare key somewhere...";
            $door_investigated = true;
            case "drawer":
            echo "You think there might be something in the drawer that you can use later";
            $drawer_investigated = true;
            case "plant":
            echo "There must be a key underneath the plant!";
            $plant_investigated = true;
            case "drawers":
            case "painting":
            echo "Upon further inspection of the painting you remember you keep your safe behind here, so you lower the painting off the wall to reach it";
            $painting_investigated = true;
            case "safe":
            echo "This safe is pretty crappy, so you're sure you can pick it open if you had a set of lockpicks, perhaps you can make some";
            $safe_investigated = true;
            case "pocket":
            echo "You've just remembered you carry a spare key around in your pocket for just such an occasion";
        }
        decrementTimer();
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
            decrementTimer();
            switch($combineList[1]){
                case "pliers":
                if($combineList[2] == "tweezers"){
                    $index = array_search("tweezers", $player_inventory);
                    if($index !== FALSE){ unset($player_inventory[$index]); }
                    $index = array_search("pliers", $player_inventory); 
                    if($index !== FALSE){ unset($player_inventory[$index]); }
                    array_push($player_inventory, "lockpick");
                }else{
                    echo "You can't combine those!";
                }
                case "tweezers":
                if($combineList[2] == "pliers"){
                    $index = array_search("tweezers", $player_inventory); 
                    if($index !== FALSE){ unset($player_inventory[$index]); }
                    $index = array_search("pliers", $player_inventory); 
                    if($index !== FALSE){ unset($player_inventory[$index]); }
                    array_push($player_inventory, "lockpick");
                }else{
                    echo "You can't combine those!";
                    decrementTimer();
                }
                default:
                echo "You can't combine those!";
                decrementTimer();
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
    echo "In this room you see a white board, your office door, the drawer to your desk, and your fake plant";
    echo "You're carrying: ";
    echo "You're holding " . $player_hand . " in your hand";
    if(empty($player_inventory)){echo "nothing";}
    else{foreach($objects_player_can_investigate as $value){
        echo $value . "<br>";}
        }
    echo "Use commands: use, search, combine, investigate, hold, help";
}
//function call for testing place in main loop later when called reduce turns by 1
command_checker();
        ?>
    </html>