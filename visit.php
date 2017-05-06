<html>
    <?php
    include_once 'core/functions.php';
    sec_session_start();
    $pid = htmlspecialchars($_GET["pid"]);
    $url = getURLFromPID($mysqli, $pid);

    if (isset($_COOKIE["setting"]))
        $nightmode = $_COOKIE["setting"]["nightmode"];

    $ssl = checkForSSL($url);
    
    /* open session, we store the opening time to find the correct dataset later without echoing the pid as it could be used to manipulate another entry */
    $openTime = openPageSession($mysqli, $pid);
    
    $_SESSION["sNR" . ($openTime * $pid)] = array($openTime, $pid);
    ?>

    <head>
        <meta charset="UTF-8">
        <title><?php echo CONST_PROJNAME ?></title>
        <link rel="stylesheet" href="<?php if ($nightmode) { echo "nm"; } ?>style.css" />
        <script>
            window.onload = function () {
                startTime(Date.now());
            };
            
            window.onunload = window.onbeforeunload = (function(){
                closeSession();
             })

            function startTime(StartFrom) {
                start = StartFrom;
                countTo = new Date();
                difference = (countTo - start);

                days = Math.floor(difference / (60 * 60 * 1000 * 24) * 1);
                hours = Math.floor((difference % (60 * 60 * 1000 * 24)) / (60 * 60 * 1000) * 1);
                mins = Math.floor(((difference % (60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) / (60 * 1000) * 1);
                secs = Math.floor((((difference % (60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) % (60 * 1000)) / 1000 * 1);

                days = days < 10 ? "0" + days : days;
                hours = hours < 10 ? "0" + hours : hours;
                mins = mins < 10 ? "0" + mins : mins;
                secs = secs < 10 ? "0" + secs : secs;

                document.getElementById('uptime').innerHTML = (days > 0 ? days + "d, " : "") + hours + ":" + mins + ":" + secs;

                clearTimeout(startTime.to);
                startTime.to = setTimeout(function () { startTime(StartFrom); }, 1000);
            }

            function closeSession() {
                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", "api/closePage.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("spid=" + <?php echo $openTime * $pid; ?>);
            }

        </script>
    </head>

    <body>
        <a style="font-size: 14px; float: left;" href="/">◄ Zurück zu LoginWell </a>
        <div style="float: right;">Online-Zeit: &nbsp;<div id="uptime" style="float: right;"></div> </div>
        <br/>
        <div class="content">
            <iframe src="<?php
            if ($ssl) {
                echo "https";
            } else {
                echo "http";
            }
            ?>://<?php echo $url; ?>" width="100%" height="100%">

            </iframe>
        </div>
    </body>
</html>