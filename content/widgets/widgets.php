<?php

namespace loginwell_widgets;

interface widgets {

    public static function getName();

    public static function getCode();
}

class widgetCategories {

    /**
     * Returns all available widget categories
     * @return mixed array of class names
     */
    public static function getClasses() {
        $files = array();
        foreach (glob(file_build_path("content", "widgets", "*.php")) as $file) {
            $files[] = basename($file, ".php");
        }
        // delete main class (this) from list
        array_pop($files);
        return $files;
    }

    /**
     * Gets name of widget
     * @param string $className raw classname without 'w' prefix
     * @return string widget name
     */
    public static function getWidgetName($className) {
        include_once $className . ".php";
        return call_user_func(array("w" . $className, 'getName'));
    }

    /**
     * Gets html from widget
     * @param string $className raw classname without 'w' prefix
     * @return string html code
     */
    public static function getWidgetCode($className) {
        include_once $className . ".php";
        return call_user_func(array("w" . $className, 'getCode'));
    }

}

?>