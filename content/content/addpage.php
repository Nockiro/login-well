<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
<div class="content info" id="infobox">
    Suche unten deine gewünschte Seite. Ist sie noch nicht aufgeführt, <a href="/?cp=requestPage">kontaktiere uns und fordere die Seite an!</a>
</div>

<div class="content" style="max-height: 214px;">
    <h3>Possible websites</h3>
    <hr/>

    <table style="border-collapse: collapse;">
        <tr>
            <th style="width: 60%">Seite</th>
            <th>Hinzufügen</th>
        </tr>       
        <?php printPageTable(getAllPossiblePages($mysqli)); ?>
    </table>

</div>

<!-- TOOD: Only show if webpage added -->
<div class="content" style="max-height: 230px;">
    <h3>Add website</h3>
    <hr/>

    <form id="addpageform" method="post">

        <div>
            <label for="page">Seite</label>
            <input type="text" name="url" id="url" value="" readonly />
        </div>

        <div>
            <label for="user">Nutzername</label>
            <input type="text" name="user" id="user" value="" placeholder="(username)" required/>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="" placeholder="(password)" required />
        </div>
        <input type="hidden" name="pid" id="pid" value="" />

        <div>
            <input type="submit" id="addpage" value="Add page"/>
        </div>

        </ul>

    </form>

</div>

<script>

    // this is the id of the form
    $("#addpageform").on('submit', function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.
        var url = "/api/addUserPage.php"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: $("#addpageform").serialize(), // serializes the form's elements.
            success: function (data)
            {
                document.getElementById("infobox").innerHTML = data;
            }
        });

    });
    function addPage(pid, url) {
        document.getElementById("url").value = url;
        document.getElementById("pid").value = pid;

    }
</script>