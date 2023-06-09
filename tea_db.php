<?php

    require_once("config.php");

    class Database extends Config {

        public function fetch($id = 0) {
            $sql = "SELECT * FROM teacher";
            if ($id != 0) {
                $sql .= " WHERE id = :id";
            }
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id]);
            $rows = $stmt->fetchAll();
            return $rows;
        }

        public function insert($teacher_fullname, $teacher_level, $teacher_class) {
            $sql = "INSERT INTO teacher(teacher_fullname, teacher_level, teacher_class) VALUES(:teacher_fullname, :teacher_level, :teacher_class)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["teacher_fullname" => $teacher_fullname, "teacher_level" => $teacher_level, "teacher_class" => $teacher_class]);
            return true;
        }

        public function update($teacher_fullname, $teacher_level, $teacher_class, $id) {
            $sql = "UPDATE teacher SET teacher_fullname = :teacher_fullname, teacher_level = :teacher_level, teacher_class = :teacher_class WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["teacher_fullname" => $teacher_fullname, 'teacher_level' => $teacher_level, 'teacher_class' => $teacher_class, 'id' => $id]); 
            return true; 
        }

        public function delete($id) {
            $sql = "DELETE FROM teacher WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id]);
            return true;
        }

    }

?>
