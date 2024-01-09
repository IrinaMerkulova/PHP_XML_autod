<?php if (isset($_GET['code'])) {die(highlight_file(__FILE__, 1));}?>
<?php
$autod=simplexml_load_file('andmed.xml');
//otsingu funktsioon
function otsingAutonumbriJargi($paring){
    global $autod;
    $paringuVastus=array();
    foreach($autod->auto as $auto){
        if(substr(strtolower($auto->autonumber), 0, strlen($paring))==
        strtolower($paring)){
            array_push($paringuVastus, $auto);
        }
    }
    return $paringuVastus;
}

//https://meet.google.com/ttd-pbjs-aak
?>
<!doctype html>
<html lang="et">
<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    <meta charset="UTF-8">
    <script type="text/javascript">
        function punaseks(){
            $('h1#ilus').css("color", "red");
        }
        function mustaks(){
            $('h1#ilus').css("color", "black");
        }

        function liigutus(event, ui){
            var asukoht=ui.offset;
            $("#vastusekiht").html(asukoht.top+" "+asukoht.left);
        }
        function tekstivarv(){
            $('h1#ilus').mouseenter(punaseks);
            $('h1#ilus').mouseleave(mustaks);
            $("#ala").draggable();
            $("#ala").bind("drag", liigutus);
        }

    </script>
    <title>Autod XML failist</title>
</head>
<body onload="tekstivarv()">
<h1 id="ilus">Autod XML failist</h1>
<div id="magatud" style="position: relative; left:0px; width: 100px; border:solid 1pt;">
    <strong>Esimese autonumber</strong>
    <?php
        echo $autod->auto[1]->autonumber;
        echo ", ";
        echo $autod->auto[1]->omanik;
        echo ", ";
        echo $autod->auto[1]->mark;
        echo ", ";
        echo $autod->auto[1]->v_aasta;
    ?>
</div>
<input type="button" value="paremale" onclick="$('div#magatud').animate({left:'300px'}, 2000);">
<input type="button" value="vasakule" onclick="$('div#magatud').animate({left:'0px'}, 2000);">
<input type="button" value="peida" onclick="$('div#magatud').hide(2000);">
<input type="button" value="näita div" onclick="$('div#magatud').show(2000);">
<h2>Kõik autod XML failist</h2>
<form method="post" action="?">
    <input type="text" id="otsing" name="otsing" placeholder="Autonumber">
    <input type="submit" value="OK">
</form>
<?php
    if(!empty($_POST["otsing"])){
        $paringuVastus=otsingAutonumbriJargi($_POST["otsing"]);
    echo"<table>
    <tr>
        <th>Autonumber</th>
        <th>Omanik</th>
        <th>Automark</th>
        <th>Väljastamise aasta</th>
    </tr>";

    foreach ($paringuVastus as $auto){
        echo  "<tr>";
        echo "<td>".$auto->autonumber."</td>";
        echo "<td>".$auto->omanik."</td>";
        echo "<td>".$auto->mark."</td>";
        echo "<td>".$auto->v_aasta."</td>";
        echo "</tr>";
    }
    echo "</table>";
    } else {


?>
<table>
    <tr>
        <th>Autonumber</th>
        <th>Omanik</th>
        <th>Automark</th>
        <th>Väljastamise aasta</th>
    </tr>
    <?php
    foreach ($autod as $auto){
        echo  "<tr>";
        echo "<td>".$auto->autonumber."</td>";
        echo "<td>".$auto->omanik."</td>";
        echo "<td>".$auto->mark."</td>";
        echo "<td>".$auto->v_aasta."</td>";
        echo "</tr>";
    }
    echo "</table>";
    }
    ?>
    <img src="pallike.png" alt="pall" id="ala">
    <div id="vastusekiht"></div>
</body>
</html>
