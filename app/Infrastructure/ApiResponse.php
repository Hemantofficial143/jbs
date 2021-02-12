<?php

namespace App\Infrastructure;

class ApiResponse{
    public $IsSuccess;
    public function __construct()
    {
        $this->IsSuccess = false;
    }
}