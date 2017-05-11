<div class="content">
    <h3>Einstellungen</h3>
    <hr>
    <p>
        Hier kannst du ein paar Einstellungen vornehmen, die deine Nutzungsweise dieser Plattform beeinflussen.<br>
    </p>

    <?php
    /* After warning: Check for actions */
    if (isset($_GET["action"])) {
        $action = htmlspecialchars($_GET["action"]);

        if ($action == "activatenm") {
            setcookie("setting[nightmode]", true);
            header('Location: /?cp=settings');
        }

        if ($action == "deactivatenm") {
            setcookie("setting[nightmode]", false);
            header('Location: /?cp=settings');
        }
        
        if ($action == "activatew") {
            $name = htmlspecialchars($_GET["name"]);
            setcookie("widget[$name]", true);
            header('Location: /?cp=settings&e');
        }
        
        if ($action == "deactivatew") {
            $name = htmlspecialchars($_GET["name"]);
            setcookie("widget[$name]", false);
            header('Location: /?cp=settings&e');
        }
    }

    $nightmode = $_COOKIE["setting"]["nightmode"];
    $setWidgets = $_COOKIE["widget"];


    include_once file_build_path("content", "widgets", "widgets.php");
    $allwidgets = \loginwell_widgets\widgetCategories::getClasses();

    foreach ($allwidgets as $widgetFile)
        $Widgets["$widgetFile"] = \loginwell_widgets\widgetCategories::getWidgetName($widgetFile);
    ?>
    <div class="content">
        <h3>Design</h3>
        <hr>
        <a href="/index.php?cp=settings&action=<?php if ($nightmode) {  echo "de"; } ?>activatenm">
            <input type="button" value="Nachtmodus <?php if ($nightmode) { echo "de"; } ?>aktivieren">
        </a>
    </div>

    <div class="content">
        <h3>Widgets</h3>
        <hr>
        <?php foreach ($Widgets as $file => $DisplayName) { ?>
        <a href="/index.php?cp=settings&action=<?php if ($setWidgets["$file"]) {  echo "de"; } ?>activatew&name=<?php echo $file; ?>">
            <input type="button" value="<?php echo "$DisplayName"; ?> <?php if ($setWidgets["$file"]) { echo "de"; } ?>aktivieren">
            </a>
<?php } ?>
    </div>
</div>