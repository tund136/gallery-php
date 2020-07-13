<?php
class User extends DbObject {

    protected static $dbTable = "users";
    protected static $dbTableFields = array('username', 'password', 'first_name', 'last_name', 'user_image');

    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $user_image;

    public $upload_directory = "images";
    public $image_placeholder = "http://placehold.it/100";
    public $errors = array();
    public $upload_errors_array = array(
        UPLOAD_ERR_OK           => "There is no error.",
        UPLOAD_ERR_INI_SIZE     => "The uploaded file exceeds the upload_max_filesize directive in php.nit.",
        UPLOAD_ERR_FORM_SIZE    => "The uploaded file exceeds the MAX_FILE_SIZE directive that was  specified in php.init.",
        UPLOAD_ERR_PARTIAL      => "The uploaded file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE      => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR   => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE   => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION    => "A PHP extension stopped the file upload."
    );

    // basename — Returns trailing name component of path
    public function setFile($file) {
        if(empty($file) || !$file || !is_array($file)) {
            $this->errors[] = "There was no file uploaded here";
            return false;

        } elseif($file['error'] != 0) {
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;

        } else {
            $this->user_image = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }

    public function imagePathAndPlaceholder() {
        return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory . DS . $this->user_image;
    }

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

    public function saveUserAndImage() {
        if(!empty($this->errors)) {
            return false;
        }

        if(empty($this->user_image) || empty($this->tmp_path)) {
            $this->errors[] = "The file was not available";
            return false;
        }

        $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;

        if(file_exists($target_path)) {
            $this->errors[] = "The file {$this->user_image} already exists";
            return false;
        }

        // move_uploaded_file — Moves an uploaded file to a new location
        if(move_uploaded_file($this->tmp_path, $target_path)) {
            if($this->save()) {
                // unset — Unset a given variable
                unset($this->tmp_path);
                return true;
            }
        } else {
            $this->errors[] = "The file directory probably does not have permission";
            return false;
        }

        $this->save();
    }

    // Using Ajax to save user image
    public function ajaxSaveUserImage($user_image, $user_id) {
        global $database;

        $user_image = $database->escapeString($user_image);
        $user_id = $database->escapeString($user_id);

        $this->user_image   = $user_image;
        $this->id           = $user_id;

        $sql = "UPDATE " . self::$dbTable . " SET user_image = '{$this->user_image}'";
        $sql .= " WHERE id = {$this->id}";

        $update_image = $database->query($sql);
        echo $this->imagePathAndPlaceholder();
    }

    // Deleting photo
    public function deletePhoto() {
        if($this->delete()) {
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->picturePath();

            // unlink — Deletes a file
            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
    }
}

?>