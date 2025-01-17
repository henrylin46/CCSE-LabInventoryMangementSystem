<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

// Check if the POST request is received and if so, execute the script
if(isset($_POST['textBoxValue'])){
    $output = '';
    $studentMatricNumberString = '%' . htmlentities($_POST['textBoxValue']) . '%';

    // Construct the SQL query to get the student ID
    $sql = 'SELECT matricNumber FROM student WHERE matricNumber LIKE ?';
    $stmt = $conn->prepare($sql);
    $stmt->execute([$studentMatricNumberString]);

    // If we receive any results from the above query, then display them in a list
    if($stmt->rowCount() > 0){

        // Given student ID is available in DB. Hence create the dropdown list
        $output = '<ul class="list-unstyled suggestionsList" id="saleDetailsMatricNumberSuggestionsList">';
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $output .= '<li>' . $row['matricNumber'] . '</li>';
        }
        echo '</ul>';
    } else {
        $output = '';
    }
    $stmt->closeCursor();
    echo $output;
}
?>