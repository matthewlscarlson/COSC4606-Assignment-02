<?php
    # Sadly resources (such as database connections) can not be transferred across files via session
    # So we need a class
    class database {
        private static $db;
        private $connection;

        # Connect with same credentials every time
        # Root account used ONLY for your convenience --- I realize this is bad in practice
        private function __construct() {
            $this->connection = new mysqli('localhost', 'root', '', 'cosc4606_assignment_02');
        }

        function __destruct() {
            # Close connection or else we'd have a bunch of open connections
            $this->connection->close();
        }

        public static function get_connection() {
            if (self::$db == null) {
                self::$db = new database();
            }
            return self::$db->connection;
        }
    }
?>
