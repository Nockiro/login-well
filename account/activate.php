<?php

include_once '../core/functions.php';

if ((isset($_REQUEST['ID']) && isset($_REQUEST['Aktivierungscode'])) || (isset($_POST['ID']) && isset($_POST['Aktivierungscode']))) {

    if ($_REQUEST['ID'] && $_REQUEST['Aktivierungscode']) {
        $_REQUEST['ID'] = mysqli_real_escape_string($mysqli, $_REQUEST['ID']);
        $_REQUEST['Aktivierungscode'] = mysqli_real_escape_string($mysqli, $_REQUEST['Aktivierungscode']);
    } else if ((isset($_POST['ID']) && isset($_POST['Aktivierungscode']))) {
        $_REQUEST['ID'] = mysqli_real_escape_string($mysqli, $_POST['ID']);
        $_REQUEST['Aktivierungscode'] = mysqli_real_escape_string($mysqli, $_POST['Aktivierungscode']);
    }
    $ResultPointer = $mysqli->query("SELECT ID, user_id FROM email_ver WHERE ID = '" . $_REQUEST['ID'] . "' AND Aktivierungscode = '" . $_REQUEST['Aktivierungscode'] . "'");

    if ($ResultPointer->num_rows > 0) {
        $mysqli->query("UPDATE email_ver SET Aktiviert = 'Ja' WHERE ID = '" . $_REQUEST['ID'] . "'");
        $row = mysqli_fetch_object($ResultPointer);
        $mysqli->query("UPDATE members SET verified = '1' WHERE username = '" . $row->user_id . "'");
        $mysqli->query("DELETE FROM email_ver WHERE ID = '" . $_REQUEST['ID'] . "'");
        $ResultPointer->Close();

        header('Location: /index.php?msg=I001');
    } else {
        header('Location: /index.php?msg=E005');
    }
} else {
    header('Location: /index.php?cp=manual_activation');
}
?>