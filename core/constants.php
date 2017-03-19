<?php

define("SECURE", FALSE);
define("CONST_PROJNAME", "LoginWell");
define("CONST_DefaultPage", "overview");

class constant {

    private static $pages = array(
        "overview" => "Übersicht",
        "logout" => "Logout",
        "register" => "Registrierung",
    );

    public static function GetPageTitle($key) {
        if ($key === "")
            return "Willkommen!";
        else
            return @self::$pages[$key];
    }

}

?>