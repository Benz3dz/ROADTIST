<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: X-Requested-With");
    header("Content-Tyoe: Application/json");

    require_once("par_db.php");
    $parent = new Database();

    $api = $_SERVER["REQUEST_METHOD"];
    $id = intval($_GET['id'] ?? '');

    //Get All data or single data
    if ($api == "GET") {
        if ($id != 0) {
            $data = $parent->fetch($id);
        } else {
            $data = $parent->fetch('');
        } echo json_encode($data);
    }

    // Add new data
    if ($api == "POST") {
        $parent_fullname = $parent->test_input($_POST['parent_fullname']);
        $std_fullname = $parent->test_input($_POST['std_fullname']);
        $std_id = $parent->test_input($_POST['std_id']);

        if ($parent->insert($parent_fullname, $std_fullname, $std_id)) {
            echo $parent->message("Parent added successfully", false);
        } else {
            echo $parent->message("Failed to add a parent", true);
        }
    }

    // Update data
    if ($api == 'PUT') {
        parse_str(file_get_contents('php://input'), $post_input);

        $parent_fullname = $parent->test_input($post_input['parent_fullname']);
        $std_fullname = $parent->test_input($post_input['std_fullname']);
        $std_id = $parent->test_input($post_input['std_id']);

        if ($id != null) {
            if ($parent->update($parent_fullname, $std_fullname, $std_id, $id)) {
                echo $parent->message("Parent updated successfully", false);
            } else {
                echo $parent->message("Failed to update and parent", true);
            }
        } else {
            echo $parent->message("Parent not found!", true);
        }
    }

    // Delete an user from database
    if ($api == "DELETE") {
        if ($id != null) {
            if ($parent->delete($id)) {
                echo $parent->message("User deleted successfully", false);
            } else {
                echo $parent->message("Failed to delete an user", true);
            }
        } else {
            echo $parent->message("User not found!", true);
        }
    }

?>
