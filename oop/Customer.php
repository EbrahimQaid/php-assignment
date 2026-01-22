<?php

class Customer {
    private $name;
    private $email;
    private $registrationDate;

    public function __construct($name, $email, $registrationDate) {
        $this->name = $name;
        $this->email = $email;
        $this->registrationDate = $registrationDate;
    }

    public function getName() {
        return $this->name;
    }

    public function getMembershipAge() {
        $regDate = new DateTime($this->registrationDate);
        $today = new DateTime();
        $diff = $today->diff($regDate);
        
        if ($diff->y > 0) {
            return $diff->y . ($diff->y == 1 ? " سنة" : " سنوات");
        } elseif ($diff->m > 0) {
            return $diff->m . ($diff->m == 1 ? " شهر" : " أشهر");
        } else {
            return $diff->d . ($diff->d == 1 || $diff->d > 10 ? " يوم" : " أيام");
        }
    }
}
