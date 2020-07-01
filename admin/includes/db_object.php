<?php
class DbObject {
    // Get all users in database
    public static function findAll() {
        $sql = "SELECT * FROM " . static::$dbTable;
        
        return static::findByQuery($sql);
    }

    // Gets user by ig
    public static function findById($id) {
        $sql = "SELECT * FROM " . static::$dbTable . " WHERE id = {$id}";

        $theResultArray = static::findByQuery($sql);

        return !empty($theResultArray) ? array_shift($theResultArray) : false;

    }

    // Finding by query
    public static function findByQuery($sql) {
        global $database;

        $resultSet = $database->query($sql);
        $theObjectArray = array();
        while($row = mysqli_fetch_array($resultSet)) {
            $theObjectArray[] = static::instantiation($row);
        }

        return $theObjectArray;
    }

    // Instantiation
    public static function instantiation($theRecord) {
        // The "Late Static Binding" class name
        $callingClass = get_called_class();

        $theObject = new $callingClass;

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

    // Get value of properties
    protected function properties() {
        $properties = array();

        foreach(static::$dbTableFields as $dbField) {
            if(property_exists($this, $dbField)) {
                $properties[$dbField] = $this->$dbField;
            }
        }

        return $properties;
    }

    // Clean properties
    protected function cleanProperties() {
        global $database;

        $cleanProperties = array();

        foreach($this->properties() as $key => $value) {
            $cleanProperties[$key] = $database->escapeString($value);
        }

        return $cleanProperties;
    }

    public function save() {
        return isset($this->id) ? $this->update() : $this->create();
    }

    // Insert into user in database
    public function create() {
        global $database;

        $properties = $this->cleanProperties();

        // implode - Join array elements with a string
        $sql = "INSERT INTO " . static::$dbTable . " (" . implode(", ", array_keys($properties)) . ")";
        $sql .= " VALUES ('" . implode("', '", array_values($properties)) . "')";

        if($database->query($sql)) {
            $this->id = $database->theInsertId();

            return true;
        } else {
            return false;
        }

    }

    // Update database from users table
    public function update() {
        global $database;

        $properties = $this->cleanProperties();

        $propertiesPairs = array();

        foreach($properties as $key => $value) {
            $propertiesPairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . static::$dbTable . " SET ";
        $sql .= implode(", ", $propertiesPairs);
        $sql .= " WHERE id = " . $database->escapeString($this->id);

        $database->query($sql);

        // mysqli_affected_rows: Gets the number of affected rows in a previous MySQL operation
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    // Delete user row in database
    public function delete() {
        global $database;

        $sql = "DELETE FROM " . static::$dbTable;
        $sql .= " WHERE id = " . $database->escapeString($this->id);
        $sql .= " LIMIT 1";

        $database->query($sql);

        // mysqli_affected_rows: Gets the number of affected rows in a previous MySQL operation
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

}
?>