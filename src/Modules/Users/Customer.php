<?php
namespace MiniStore\Modules\Users;

class Customer extends User {
    public function __construct(string $username) {
        parent::__construct($username, 'Customer');
    }
}
