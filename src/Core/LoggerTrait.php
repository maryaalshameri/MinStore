<?php
namespace MiniStore\Core;

trait LoggerTrait {
    public function log(string $message, string $type = 'INFO'): void {
        echo date('Y-m-d H:i:s') . " [$type] $message<br>";
    }
}
