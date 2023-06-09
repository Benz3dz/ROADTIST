<?php

    require_once("config.php");

    class Database extends Config {

        public function fetch($id = 0) {
            $sql = "SELECT * FROM parent";
            if ($id != 0) {
                $sql .= " WHERE id = :id";
            }
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id]);
            $rows = $stmt->fetchAll();
            return $rows;
        }

        public function insert($parent_fullname, $std_fullname, $std_id) {
            $sql = "INSERT INTO parent(parent_fullname, std_fullname, std_id) VALUES(:parent_fullname, :std_fullname, :std_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["parent_fullname" => $parent_fullname, "std_fullname" => $std_fullname, "std_id" => $std_id]);
            return true;
        }

        public function update($parent_fullname, $std_fullname, $std_id, $id) {
            $sql = "UPDATE parent SET parent_fullname = :parent_fullname, std_fullname = :std_fullname, std_id = :std_id WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["parent_fullname" => $parent_fullname, 'std_fullname' => $std_fullname, 'std_id' => $std_id, 'id' => $id]); 
            return true; 
        }

        public function delete($id) {
            $sql = "DELETE FROM parent WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(["id" => $id]);
            return true;
        }

    }

?>
