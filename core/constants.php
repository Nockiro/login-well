<?php

define("SECURE", FALSE);
define("CONST_PROJNAME", "LoginWell");
define("CONST_DefaultPage", "overview");
define("DATABASE_VER", "7");
include_once("language.php");

class constant {

    private static $accessableNotLoggedin = array("about", "overview", "logout", "register", "register_failed", "register_success", "manual_activation", "reset_pw");

    public static function GetPermittedNotLoggedInPage($key) {
        return in_array($key, @self::$accessableNotLoggedin);
    }

    public static function getExamplePageValues() {
        return array
            (
            array('page' => "loginwell.rudifamily.de",
                'time' => 156123,
                'points' => 28098,
                'multiplicator' => 18,
                'rate' => 5,
                'pid' => 2),
            array('page' => "github.com",
                'time' => 156123,
                'points' => 17171,
                'multiplicator' => 11,
                'rate' => 5,
                'pid' => 3),
            array('page' => "waitinginline3d.de",
                'time' => 1235635,
                'points' => 12356,
                'multiplicator' => 1,
                'rate' => 3,
                'pid' => 4),
            array('page' => "www.klamm.de",
                'time' => 156312,
                'points' => 1563,
                'multiplicator' => 1,
                'rate' => 5,
                'pid' => 1),
            array('page' => "jetztspielen.de",
                'time' => 1531,
                'points' => 15,
                'multiplicator' => 1,
                'rate' => 0,
                'pid' => 5)
        );
    }

    /**
     * Gets button colors dependant of current night mode usage
     * @param string $type button type (warn, attention, info)
     * @return string color code in hex
     */
    public static function getButtonColor($type) {
        $nightmode = $_COOKIE["setting"]["nightmode"];
        switch ($type) {
            case "warn":
                return $nightmode ? "#bbb761" : "#f2ee7e";
            case "attention":
                return $nightmode ? "#af6363" : "#ec8f8f";
            case "info":
                return $nightmode ? "#578db1" : "#b7e2ff";
            default:
                return "initial";
        }
    }

}

?>
