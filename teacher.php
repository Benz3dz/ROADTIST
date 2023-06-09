<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: X-Requested-With");
    header("Content-Tyoe: Application/json");

    require_once("tea_db.php");
    $teacher = new Database();

    $api = $_SERVER["REQUEST_METHOD"];
    $id = intval($_GET['id'] ?? '');

    //Get All data or single data
    if ($api == "GET") {
        if ($id != 0) {
            $data = $teacher->fetch($id);
        } else {
            $data = $teacher->fetch('');
        } echo json_encode($data);
    }

    // Add new data
    if ($api == "POST") {
        $teacher_fullname = $teacher->test_input($_POST['teacher_fullname']);
        $teacher_level = $teacher->test_input($_POST['teacher_level']);
        $teacher_class = $teacher->test_input($_POST['teacher_class']);

        if ($teacher->insert($teacher_fullname, $teacher_level, $teacher_class)) {
            echo $teacher->message("Teacher added successfully", false);
        } else {
            echo $teacher->message("Failed to add a teacher", true);
        }
    }

    // Update data
    if ($api == 'PUT') {
        parse_str(file_get_contents('php://input'), $post_input);

        $teacher_fullname = $teacher->test_input($post_input['teacher_fullname']);
        $teacher_level = $teacher->test_input($post_input['teacher_level']);
        $teacher_class = $teacher->test_input($post_input['teacher_class']);

        if ($id != null) {
            if ($teacher->update($teacher_fullname, $teacher_level, $teacher_class, $id)) {
                echo $teacher->message("Teacher updated successfully", false);
            } else {
                echo $teacher->message("Failed to update and teacher", true);
            }
        } else {
            echo $teacher->message("Teacher not found!", true);
        }
    }

    // Delete an user from database
    if ($api == "DELETE") {
        if ($id != null) {
            if ($teacher->delete($id)) {
                echo $teacher->message("User deleted successfully", false);
            } else {
                echo $teacher->message("Failed to delete an user", true);
            }
        } else {
            echo $teacher->message("User not found!", true);
        }
    }


?>
