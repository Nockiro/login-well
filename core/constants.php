<?php

define("SECURE", FALSE);
define("CONST_PROJNAME", "LoginWell");
define("CONST_DefaultPage", "overview");
define("DATABASE_VER", "7");
include_once("language.php");

class constant {

    private static $accessableNotLoggedin = array("about", "overview", "logout", "register", "register_failed", "register_success", "manual_activation");

    public static function GetPermittedNotLoggedInPage($key) {
        return in_array($key, @self::$accessableNotLoggedin);
    }

    public static function getExamplePageValues() {
        return array
            (
            array('page' => "github.com",
                'time' => 156123,
                'points' => 18,
                'multiplicator' => 4,
                'rate' => 5),
            array('page' => "waitinginline3d.de",
                'time' => 1235635,
                'points' => 13,
                'multiplicator' => 2,
                'rate' => 2),
            array('page' => "klamm.de",
                'time' => 156312,
                'points' => 2,
                'multiplicator' => 2,
                'rate' => 5),
            array('page' => "jetztspielen.de",
                'time' => 1531,
                'points' => 15,
                'multiplicator' => 2,
                'rate' => 0)
        );
    }

}

?>