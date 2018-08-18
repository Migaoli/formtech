<?php


namespace App\Blocks;


class BlockException extends \RuntimeException
{
    public static function of($message): self
    {
        return new self($message);
    }
}