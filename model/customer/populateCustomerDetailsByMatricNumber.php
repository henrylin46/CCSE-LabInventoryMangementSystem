<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

// Execute the script if the POST request is submitted
if(isset($_POST['matricNumber'])){

    $customerMatric = htmlentities($_POST['matricNumber']);

    $customerDetailsSql = 'SELECT * FROM customer WHERE matricNumber = :matricNumber';
    $customerDetailsStatement = $conn->prepare($customerDetailsSql);
    $customerDetailsStatement->execute(['matricNumber' => $customerMatric]);

    // If data is found for the given item number, return it as a json object
    if($customerDetailsStatement->rowCount() > 0) {
        $row = $customerDetailsStatement->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);
    }
    $customerDetailsStatement->closeCursor();
}
?>