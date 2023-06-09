<?php

    require_once("config.php");

    class Database extends Config {

        public function fetch($id = 0) {
            $sql = "SELECT * FROM student";
            if ($id != 0) {
                $sql .= " WHERE id = :id";
            }
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id]);
            $rows = $stmt->fetchAll();
            return $rows;
        }

        public function insert($std_fullname, $std_id, $level, $class) {
            $sql = "INSERT INTO student(std_fullname, std_id, level, class) VALUES(:std_fullname, :std_id, :level, :class)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["std_fullname" => $std_fullname, "std_id" => $std_id, "level" => $level, "class" => $class]);
            return true;
        }

        public function update($std_fullname, $std_id, $level, $class, $id) {
            $sql = "UPDATE student SET std_fullname = :std_fullname, std_id = :std_id, level = :level, class = :class  WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["std_fullname" => $std_fullname, 'std_id' => $std_id, 'level' => $level, 'class' => $class, 'id' => $id]); 
            return true; 
        }

        public function delete($id) {
            $sql = "DELETE FROM student WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id]);
            return true;
        }

    }

?>
