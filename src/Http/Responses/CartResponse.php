<?php

namespace Jonassiewertsen\Butik\Http\Responses;

class CartResponse
{
    public static string $message;
    public static bool $success = true;

    public static function success(string $message = ''): static
    {
        self::$message = $message;

        return new static();
    }

    public static function failed(string $message = ''): static
    {
        self::$success = false;
        self::$message = $message;

        return new static();
    }
}
