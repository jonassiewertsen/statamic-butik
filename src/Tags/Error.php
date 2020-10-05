<?php

namespace Jonassiewertsen\StatamicButik\Tags;

class Error extends \Statamic\Tags\Tags
{
    protected $errors;

    /**
     * {{ error:fieldname }}
     */
    public function wildcard($name)
    {
        /**
         * Are there errors at all?
         */
        if (count($this->context['errors']) === 0) {
            return false;
        }

        /**
         * Does our default error bag exist
         */
        if (isset($this->context['errors']->default)) {
            return false;
        }

        /**
         * Let's fetch all errors
         */
        $this->errors = $this->context['errors']->default;

        /**
         * Does an error exist with the given name
         */
        if (! $this->errors->has($name)) {
            return false;
        }

        /**
         * Return the error message
         */
        return $this->errors->get($name)[0];
    }
}
