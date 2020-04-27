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
            //function call for testing place in main loop later when called reduce turns by 1
            command_checker();

        ?> 
      
    
</html> 