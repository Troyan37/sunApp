<?php
if (isset($_POST['key'])) {
    $servername = 'localhost:3306';
    $username = 'root';
    $password = 'admin';
    try {
        $conn = new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }

    if ($_POST['key'] == 'addNew') {

        $cityName = $_POST['cityName'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];

        $stmt = $conn->prepare("INSERT INTO city (cityName, lat, lng) VALUES (:name, :lat, :lng)");
        $stmt->bindParam(':name',$cityName);
        $stmt->bindParam(':lat',$lat);
        $stmt->bindParam(':lng',$lng);

        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Unable to create record";
        }

        exit('');
    }


    if ($_POST['key'] == 'fill') {

        $stmt = $conn->prepare("SELECT * FROM city");
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($row);
    }



}