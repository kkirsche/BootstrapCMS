<?php

    class Database {
        private $hostname = "localhost";
        private $databaseUser = "BootstrapCMSUser";
        private $databaseUserPassword = "Ae3Vr3mcUvK3wTva";
        private $databaseName = "BootstrapCMS";

        private $dbh;
        private $error;

        private $stmt;

        public function __construct() {
           // Set DSN
            $dsn = 'mysql:host=' . $this->hostname . ';dbname=' . $this->databaseName;
            //Set options
            $options = array(
                PDO::ATTR_PERSISTENT    =>true,
                PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
            );
            //Attempt a new PDO instance
            try {
                $this->dbh = new PDO($dsn, $this->databaseUser, $this->databaseUserPassword, $options);
            }
            // Catch any errors
            catch (PDOException $e) {
                $this->error = $e->getMessage();
            }
        }//end __construct()

        public function query($query) {
            $this->stmt = $this->dbh->prepare($query);
        }

        public function bind($param, $value, $type = null) {
            if (is_null($type)) {
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }//end switch
            }//end if
            $this->stmt->bindValue($param, $value, $type);
        }//end function bind

        public function execute() {
            return $this->stmt->execute();
        }

        public function resultSet() {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function single() {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        }

        //Get rows affected by query
        public function rowCount() {
            return $this->stmt->rowCount();
        }

        public function lastInsertId() {
            return $this->dbh->lastInsertId();
        }

        public function beginTransaction() {
            return $this->dbh->beginTransaction();
        }

        public function endTransaction() {
            return $this->dbh->commit();
        }

        public function cancelTransaction() {
            return $this->dbh->rollBack();
        }

        public function debugDumpParams() {
            return $this->stmt->debugDumpParams();
        }
    }

?>