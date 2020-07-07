<?php
class Comment extends DbObject {

    protected static $dbTable = "comments";
    protected static $dbTableFields = array('photo_id', 'author', 'body');

    public $id;
    public $photo_id;
    public $author;
    public $body;

    // Create Comment Object
    public static function createComment($photo_id, $author, $body) {
        if(!empty($photo_id) && !empty($author) && !empty($body)) {
            $comment = new Comment();

            $comment->photo_id  = (int)$photo_id;
            $comment->author    = $author;
            $comment->body      = $body;

            return $comment;
        } else {
            return false;
        }
    }

    // Finding the comments of photo_id
    public static function findTheComments($photo_id) {
        global $database;

        $sql  = "SELECT * FROM " . self::$dbTable;
        $sql .= " WHERE photo_id = " . $database->escapeString($photo_id);
        $sql .= " ORDER BY photo_id ASC";

        return self::findByQuery($sql);
    }
}

?>