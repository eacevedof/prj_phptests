<?php
namespace App\Blog\Infrastructure;

trait RequestTrait
{
    private function getRequestGet($key, $default=null)
    {
        return $_GET[$key] ?? $default;
    }

    private function getRequestPost($key, $default=null)
    {
        return $_POST[$key] ?? $default;
    }

    private function getRequestSession($key, $default=null)
    {
        return $_SESSION[$key] ?? $default;
    }
}