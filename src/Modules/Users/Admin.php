<?php
namespace MiniStore\Modules\Users;

class Admin extends User {
    public function __construct(string $username) {
        parent::__construct($username, 'Admin');
    }
}
