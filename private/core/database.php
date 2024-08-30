<?php

/*
* Database
 */
class Database
{
    private function connect()
    {
        $string = DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME;
        try {
            $con = new PDO($string, DB_USER, DB_PASSWORD);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        } catch (PDOException $e) {
            // die('Connection failed: ' . $e->getMessage());
        }
    }

    public function query($query, $data = [], $data_type = "object")
    {
        $con = $this->connect();
        $stm = $con->prepare($query);

        if ($stm) {
            try {
                $check = $stm->execute($data);
                if ($check) {
                    if ($data_type == "object") {
                        $data = $stm->fetchAll(PDO::FETCH_OBJ);
                    } else {
                        $data = $stm->fetchAll(PDO::FETCH_ASSOC);
                    }

                    if (is_array($data) && count($data) > 0) {
                        return $data;
                    }
                }
            } catch (PDOException $e) {
                #
            }
        }
        return false;
    }
}
