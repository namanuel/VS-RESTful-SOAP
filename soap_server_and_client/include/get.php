<?php
    $SANITIZE = False; # disabled because it's funny :)
    
$i = isset($_GET["page"]) ? $_GET["page"] : 1;
switch ($i) {
    case 1:
        $url = "http://35.238.84.142/api/lights";
        break;
    case 2:
        $url = "http://35.238.84.142/api/blinds";
        break;
    case 3:
        $url="http://35.238.84.142/api/scenes";
        break;
}

$request_headers = array();
$request_headers[] = 'x-api-key:be81dc5b-bb41-46ad-8ad4-890d70626c77';


// Request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$json = curl_exec($ch);

curl_close($ch);

$data = json_decode($json, true);


switch ($i) {
    //Lights
    case 1:
        echo <<<EOL

        <table class="table">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Brightness</th>
        <th scope="col">State</th>
        <th scope="col">ON/OFF</th>
    </tr>
    </thead>
    <tbody>

EOL;


        foreach ($data as $list){
            echo"<tr>";
            echo "<td>";
            echo $list['id'];
            echo "</td>";
            echo "<td>";
            if ($SANITIZE == False) { echo $list['name']; }
            else  { echo filter_var($list['name'], FILTER_SANITIZE_STRING); }
            echo "</td>";
            echo "<td>";
            echo $list['brightness'];
            echo "</td>";
            echo "<td>";
            echo $list['status'];
            echo "</td>";
            echo "<td>";
            echo "<a role='button' href='light.php?&id=".$list['id']."&state=1"."&brightness=".$list['brightness']."' class='btn btn-success '>ON</a>";
            echo "<a role='button' href='light.php?&id=".$list['id']."&state=0"."&brightness=".$list['brightness']."' class='btn btn-danger ml-1 '>OFF</a>";
            echo "<a role='button' href='delete_light.php?&id=".$list['id']."' class='btn btn-primary ml-1 '>Delete</a>";
            echo "</td>";
            echo"</tr>";
        }
 
       echo "</tbody>";
        echo "</table>";

        echo <<<EOL

<div class="container">
    <form action="create_light.php" method="post">
    <h1>Anlegen</h1>
    <p>Light-Name: <input type="text" name="light" />
    
    <input type="submit" class="d-inline"/></p>
</form>
    <form action="light_dim.php" method="post">
        <h1>Dimmen</h1>
     <p>Light-ID: <input type="text" name="light_id" />
    <p>Brightness: <input type="number" min="0" max="100" name="bright" />
    <input type="submit" class="d-inline"/></p>
</form>
</div>

        <a role='button' href='lights.php?status=1' class='btn btn-success'>All lights on</a>
        <a role='button' href='lights.php?status=0' class='btn btn-danger'>All lights off</a>

EOL;


        break;
        //Blinds
    case 2:

        echo <<<EOL
        <table class="table">
    <thead>
    <tr>
        <th scope="col">ID</th>
   <th scope="col">Name</th>
        <th scope="col">State</th>
    </tr>
    </thead>
    <tbody>
EOL;

        foreach ($data as $list){
            echo"<tr>";
            echo "<td>";
            echo $list['id'];
            echo "</td>";
            echo "<td>";
            echo $list['name'];
            echo "</td>";
            echo "<td>";
            echo $list['status'];
            echo "</td>";
            echo "<td>";
            echo "<a role='button' href='blind.php?&id=".$list['id']."&state=0"."' class='btn btn-success '>UP</a>";
            echo "<a role='button' href='blind.php?&id=".$list['id']."&state=1"."' class='btn btn-danger ml-1 '>DOWN</a>";
            echo "<a role='button' href='delete_blinds.php?&id=".$list['id']."' class='btn btn-primary ml-1 '>Delete</a>";
            echo "</td>";
            echo"</tr>";
        }

        echo "</tbody>";
        echo "</table>";

        echo <<<EOL

<div class="container">
    <form action="create_blind.php" method="post">
    <p>Blind-Name: <input type="text" name="blind" />
    <input type="submit" class="d-inline"/></p>
</form>
</div>

        <a role='button' href='blinds.php?status=0' class='btn btn-success'>All blinds up</a>
        <a role='button' href='blinds.php?status=1' class='btn btn-danger'>All blinds down</a>

EOL;

        break;

        //Scenes
    case 3:
        echo <<<EOL
        <table class="table">
    <thead>
    <tr>
        <th scope="col">Light-ID</th>
        <th scope="col">Scene-ID</th>
        <th scope="col">Name</th>
        <th scope="col">Brightness</th>
        <th scope="col">State</th>
        
    </tr>
    </thead>
    <tbody>
EOL;

        foreach ($data as $list){
            echo"<tr>";
            echo "<td>";
            echo $list['light_id'];
            echo "</td>";
            echo "<td>";
            echo $list['scene_id'];
            echo "</td>";
            echo "<td>";
            echo $list['name'];
            echo "</td>";
            echo "<td>";
            echo $list['brightness'];
            echo "</td>";
            echo "<td>";
            echo $list['status'];
            echo "</td>";
            echo "<td>";
            echo "<a role='button' href='scene.php?&scene_id=".$list['scene_id']."' class='btn btn-success'>Enable</a>";
            echo "<a role='button' href='delete_scenes.php?&scene_id=".$list['scene_id']."' class='btn btn-primary ml-1 '>Delete</a>";
            echo "</td>";
            echo"</tr>";
        }
        break;
}


  ?>


