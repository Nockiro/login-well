<div class="content info">
    Suche unten deine gewünschte Seite. Ist sie noch nicht aufgeführt, <a href="/?cp=requestPage">kontaktiere uns und fordere die Seite an!</a>
</div>

<div class="content" style="max-height: 214px;">
    <h3>Possible websites</h3>
    <hr/>

    <table>
        <tr>
            <th style="width: 60%">Seite</th>
            <th>Hinzufügen</th>
        </tr>       
        <?php printPageTable(getAllPossiblePages($mysqli)); ?>
    </table>

</div>

<!-- TOOD: Only show if webpage added -->
<div class="content" style="max-height: 214px;">
    <h3>Add website</h3>
    <hr/>

    <table>
        <tr>
            <th style="width: 60%">Seite</th>
            <th>Hinzufügen</th>
        </tr>       
    </table>

</div>
