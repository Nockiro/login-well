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

    /* Start with E? Is error. I? Information */

    public static function get_msg($errcode) {
        switch ($errcode) {
            case "E000":
                return "Couldn't execute query. Is there a valid database?";
            case "E001":
                return "Wrong Password/Name";
            case "E002":
                return "No user with this name registered!";
            case "E003":
                return "Your account is locked due to five wrong login attempts!";
            case "E004":
                return "Your account is locked due to an unactivated e-mail-adress!";
            case "E005":
                return "The activation code is not valid. Maybe you already activated your account?";
            case "E404":
                return "Your previous tried page could not be found.";
            case "I001":
                return "Thank you for your registration. The activation process is done.";
        }
    }

}

?>