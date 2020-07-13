<?php
class Session {
    private $signedIn = false;
    public $userId;
    public $message;
    public $count;

    function __construct() {
        // Start new or resume existing session
        session_start();

        $this->visitorCount();
        $this->checkTheLogin();
        $this->checkMessage();
    }

    // Counting visitors
    public function visitorCount() {
        if(isset($_SESSION['count'])) {
            return $this->count = $_SESSION['count']++;
        } else {
            return $_SESSION['count'] = 1;
        }
    }

    public function message($msg="") {
        if(!empty($msg)) {
            $_SESSION['message'] = $msg;
        } else {
            return $this->message;
        }
    }

    private function checkMessage() {
        if(isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }

    public function isSignedIn() {
        return $this->signedIn;
    }

    public function login($user) {
        if($user) {
            $this->userId = $_SESSION['user_id'] = $user->id;
            $this->signedIn = true;
        }
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($this->userId);

        $this->signedIn = false;
    }

    private function checkTheLogin() {
        // Determine if a variable is declared and is different than NULL
        if(isset($_SESSION['user_id'])) {
            $this->userId = $_SESSION['user_id'];
            $this->signedIn = true;
        } else {
            // Unset a given variable
            unset($this->userId);
            $this->signedIn = false;
        }
    }
}

$session = new Session();
$message = $session->message();
?>