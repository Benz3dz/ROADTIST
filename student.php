<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: X-Requested-With");
    header("Content-Tyoe: Application/json");

    require_once("std_db.php");
    $student = new Database();

    $api = $_SERVER["REQUEST_METHOD"];
    $id = intval($_GET['id'] ?? '');

       //Get All data or single data
    if ($api == "GET") {
        if ($id != 0) {
            $data = $student->fetch($id);
        } else {
            $data = $student->fetch('');
        } echo json_encode($data);
    }

    if ($api == "POST") {
        $std_fullname = $student->test_input($_POST['std_fullname']);
        $std_id = $student->test_input($_POST['std_id']);
        $level = $student->test_input($_POST['level']);
        $class = $student->test_input($_POST['class']);
        
        if ($student->insert($std_fullname, $std_id, $level, $class)) {
            echo $student->message("student added successfully", false);
        } else {
            echo $student->message("Failed to add a student", true);
        }
    }
    
    // Update data
    if ($api == 'PUT') {
        parse_str(file_get_contents('php://input'), $post_input);

        $std_fullname = $student->test_input($post_input['std_fullname']);
        $std_id = $student->test_input($post_input['std_id']);
        $level = $student->test_input($post_input['level']);
        $class = $student->test_input($post_input['class']);

        if ($id != null) {
            if ($student->update($std_fullname, $std_id, $level, $class, $id)) {
                echo $student->message("student updated successfully", false);
            } else {
                echo $student->message("Failed to update and student", true);
            }
        } else {
            echo $student->message("student not found!", true);
        }
    }

    // Delete an user from database
    if ($api == "DELETE") {
        if ($id != null) {
            if ($student->delete($id)) {
                echo $student->message("User deleted successfully", false);
            } else {
                echo $student->message("Failed to delete an user", true);
            }
        } else {
            echo $student->message("User not found!", true);
        }
    }

?>
