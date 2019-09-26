<?php

namespace Ibnujakaria\FileManager\Http\Middleware;

use Closure;
use Ibnujakaria\FileManager\Http\Controllers\FileManagerController;
use InvalidArgumentException;

class FileManagerMiddleware {

  public function handle($request, Closure $next)
  {
    try {
      //code...
      setcookie(
        'file-manager-base-url',
        action([FileManagerController::class, 'index']),
        time() + (60),
        '/'
      );
    } catch (InvalidArgumentException $exception) {
    }

    return $next($request);
  }
}