<?php

define("SECURE", FALSE);
define("CONST_PROJNAME", "LoginWell");
define("CONST_DefaultPage", "overview");
define("DATABASE_VER", "6");
include_once("language.php");

class constant {
    
    private static $accessableNotLoggedin = array( "about", "overview", "logout", "register", "register_failed", "register_success", "manual_activation");
    
     public static function GetPermittedNotLoggedInPage($key) {
        return in_array($key, @self::$accessableNotLoggedin);
    }
}

?>