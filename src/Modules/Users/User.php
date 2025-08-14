<?php
namespace MiniStore\Modules\Users;

abstract class User {
    protected string $username;
    protected string $role;

    public function __construct(string $username, string $role) {
        $this->username = $username;
        $this->role = $role;
    }

    public function getUsername(): string { return $this->username; }
    public function getRole(): string { return $this->role; }
}
