<?php

require_once 'core.php';

$valid = array('success' => false, 'messages' => array());

$categoriesId = $_POST['categories_id'];

if ($categoriesId) { 

    $sql = "DELETE FROM categories WHERE categories_id = {$categoriesId}";

    if ($connect->query($sql) === TRUE) {
        $valid['success'] = true;
        $valid['messages'] = "Successfully Removed";
        echo json_encode($valid);
        header('Location: ../categories.php');
        exit(); // Ensure no more output is sent
    } else {
        $valid['success'] = false;
        $valid['messages'] = "Error while removing the category";
        echo json_encode($valid);
    }

} else {
    $valid['success'] = false;
    $valid['messages'] = "Category ID not provided";
    echo json_encode($valid);
}

$connect->close();

?>
