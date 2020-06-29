<?php
class User {
    public $id;
    public $username;
    public $password;
    public $firstName;
    public $lastName;
    
    // Get all users in database
    public static function findAllUsers() {
        $sql = "SELECT * FROM users";
        
        return self::findThisQuery($sql);
    }

    // Gets user by ig
    public static function findUserById($userId) {
        $sql = "SELECT * FROM users WHERE id = {$userId}";

        $theResultArray = self::findThisQuery($sql);

        return !empty($theResultArray) ? array_shift($theResultArray) : false;

    }

    // Finding this query
    public static function findThisQuery($sql) {
        global $database;

        $resultSet = $database->query($sql);
        $theObjectArray = array();
        while($row = mysqli_fetch_array($resultSet)) {
            $theObjectArray[] = self::instantiation($row);
        }

        return $theObjectArray;
    }

    // Verify User
    public static function verifyUser($username, $password) {
        global $database;

        $username = $database->escapeString($username);
        $password = $database->escapeString($password);

        $sql = "SELECT * FROM users WHERE";
        $sql .= " username = '{$username}'";
        $sql .= " AND password = '{$password}'";
        $sql .= " LIMIT 1";

        $theResultArray = self::findThisQuery($sql);

        return !empty($theResultArray) ? array_shift($theResultArray) : false;
    }

    // Instantiation
    public static function instantiation($theRecord) {
        $theObject = new self;

        foreach($theRecord as $theAttribute => $value) {
            if($theObject->hasTheAttribute($theAttribute)) {
                $theObject->$theAttribute = $value;
            }
        }

        return $theObject;
    }

    // Gets the attribute from key
    private function hasTheAttribute($theAttribute) {
        // Gets the properties of the given object
        $objectProperties = get_object_vars($this);

        // Checks if the given key or index exists in the array
        return array_key_exists($theAttribute, $objectProperties);

    }
}
?>