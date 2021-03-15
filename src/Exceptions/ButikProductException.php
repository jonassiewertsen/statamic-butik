<?php

namespace Jonassiewertsen\Butik\Exceptions;

use Exception;

class ButikProductException extends Exception
{
    public static function cantDeleteNonExistingProduct(string $id): self
    {
        return new static('You can\'t delete the non existing product with the id '.$id);
    }
}
