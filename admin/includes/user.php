<?php
class User extends DbObject {

    protected static $dbTable = "users";
    protected static $dbTableFields = array('username', 'password', 'first_name', 'last_name');

    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;

    // Verify User
    public static function verifyUser($username, $password) {
        global $database;

        $username = $database->escapeString($username);
        $password = $database->escapeString($password);

        $sql = "SELECT * FROM " . self::$dbTable . " WHERE";
        $sql .= " username = '{$username}'";
        $sql .= " AND password = '{$password}'";
        $sql .= " LIMIT 1";

        $theResultArray = self::findByQuery($sql);

        return !empty($theResultArray) ? array_shift($theResultArray) : false;
    }


}
?>