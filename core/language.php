<?php

class language {

    private static $pages = array(
        "overview" => "Übersicht",
        "logout" => "Logout",
        "register" => "Registrierung",
        "register_success" => "Registrierung erfolgreich",
        "register_failed" => "Registrierung fehlgeschlagen",
    );

    public static function GetPageTitle($key) {
        if ($key === "")
            return "Willkommen!";
        else
            return @self::$pages[$key];
    }

}

?>