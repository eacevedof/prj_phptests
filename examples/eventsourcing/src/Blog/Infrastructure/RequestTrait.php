<?php
namespace App\Blog\Infrastructure;

trait RequestTrait
{
    private function getGet($key, $default=null)
    {
        return $_GET[$key] ?? $default;
    }

    private function getPost($key, $default=null)
    {
        return $_POST[$key] ?? $default;
    }
}