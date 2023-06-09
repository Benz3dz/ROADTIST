<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: X-Requested-With");
    header("Content-Tyoe: Application/json");

    require_once("pic_db.php");
    $pick = new Database();

    $api = $_SERVER["REQUEST_METHOD"];
    $id = intval($_GET['id'] ?? '');

    //Get All data or single data
    if ($api == "GET") {
        if ($id != 0) {
            $data = $pick->fetch($id);
        } else {
            $data = $pick->fetch('');
        } echo json_encode($data);
    }

    // Add new data
    if ($api == "POST") {
        $pick_location = $pick->test_input($_POST['pick_location']);
        $pick_note = $pick->test_input($_POST['pick_note']);
        $parent_id = $pick->test_input($_POST['parent_id']);

        if ($pick->insert($pick_location, $pick_note, $parent_id)) {
            echo $pick->message("pick added successfully", false);
        } else {
            echo $pick->message("Failed to add a pick", true);
        }
    }

    // Update data
    if ($api == 'PUT') {
        parse_str(file_get_contents('php://input'), $post_input);

        $pick_location = $pick->test_input($post_input['pick_location']);
        $pick_note = $pick->test_input($post_input['pick_note']);
        $parent_id = $pick->test_input($post_input['parent_id']);

        if ($id != null) {
            if ($pick->update($pick_location, $pick_note, $parent_id, $id)) {
                echo $pick->message("Pick detail updated successfully", false);
            } else {
                echo $pick->message("Failed to update pick detail", true);
            }
        } else {
            echo $pick->message("Pick detail not found!", true);
        }
    }

    // Delete an user from database
    if ($api == "DELETE") {
        if ($id != null) {
            if ($pick->delete($id)) {
                echo $pick->message("User deleted successfully", false);
            } else {
                echo $pick->message("Failed to delete an user", true);
            }
        } else {
            echo $pick->message("User not found!", true);
        }
    }


?>
