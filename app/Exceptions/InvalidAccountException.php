<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class InvalidAccountException extends Exception
{
    /**
     * Get the exception's context information.
     *
     * @return array
     */
    public function context()
    {
        return ['code' => $this->code];
    }

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        // Determine if the exception needs custom reporting...
        Log::error($this->getMessage(), $this->context());
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function render($request)
    {
        return Redirect::to(url('/'));
    }
}
