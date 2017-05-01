<style>
    /* original source by http://codepen.io/maxds/pen/DcveB, colors and margins modified */
    blockquote{
        display:block;
        padding: 15px 20px 15px 45px;
        margin: 10px 6px 20px;
        position: relative;
        background-color: #b0e69e;

        /*Borders - (Optional)*/
        border-left: 15px solid  #20c70c;
        border-right: 2px solid #20c70c;

        /*Box Shadow - (Optional)*/
        -moz-box-shadow: 2px 2px 15px #ccc;
        -webkit-box-shadow: 2px 2px 15px #ccc;
        box-shadow: 2px 2px 15px #ccc;
    }

    blockquote::before{
        content: "\201C"; /*Unicode for Left Double Quote*/

        /*Font*/
        font-family: Georgia, serif;
        font-size: 60px;
        font-weight: bold;
        color: #999;

        /*Positioning*/
        position: absolute;
        left: 10px;
        top:5px;
    }

    blockquote::after{
        /*Reset to make sure*/
        content: "";
    }
    
    div {
        overflow: hidden !important;
    }
    
    p {
        margin: 6px;
    }
</style>

<div class="content">
    <h2>Wer sind wir?</h2>
    <hr/>
    <h3>Wir sind ein paar junge Menschen, die versuchen, ein &Uuml;bungsprojekt auf die Beine zu stellen.</h3>
    <p>Unser Team ist eine sehr, sehr freiwillig zusammengestellte Gruppe, in der jeder einen Teil Arbeit übernimmt, sodass am Ende etwas sinnvolles herauskommt. (Soweit der Plan.)</p>

    <div class="content info" style="float: left;">
        <h3>Robin Freund</h3>
        <hr/>
        <p><i> &#8658; Chief Executive Officer (CEO und Protokollant)</i></p>
        <p>Github: <a href="https://github.com/nockiro">Nockiro</a></p>
        <blockquote>CEO? "Es ist was schiefgegangen, Robin ist verantwortlich!"</blockquote>
    </div>
    <div class="content info" style="float: left;">
        <h3>Daniel Mowitz</h3>
        <hr/>
        <p><i> &#8658; Chief Technology Officer (CTO, auch bekannt als Chef-Retard)</i></p>
        <p>Github: <a href="https://github.com/TheLie0">TheLie0</a></p>
        <blockquote>SQL WHY U DO THIS?</blockquote>
    </div>
    <div class="content info" style="float: left;">
        <h3>Bärbel Kluba</h3>
        <hr/>
        <p><i> &#8658; Chief Content Officer (CCO und Protokollantin)</i></p>
        <p>Github: <a href="https://github.com/BaerbelsHub">BaerbelsHub</a></p>
        <blockquote>Schlaue Zitate sind von mir nicht zu erwarten, besonders nicht in Bezug auf dieses Projekt ^_°</blockquote>
    </div>
</div>