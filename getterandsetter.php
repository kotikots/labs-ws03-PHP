<?php

class User
{
    public $name;
    public $email;
    private $status = "active"; // Private property

    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    // Getter function
    public function getStatus()
    {
        return $this->status;
    }

    // Setter function
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function login()
    {
        return $this->name . " logged in";
    }
}

$user1 = new User("Ron", "ron@gmail.com");
$user1->setStatus("pogi"); // Modifying private data via setter [00:16:20]
echo $user1->getStatus();
