<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use App\Exceptions;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof MethodNotAllowedHttpException && $request->is('api/*')) {
            // Handle MethodNotAllowedHttpException for API routes
            return response()->json([ 'status'    => 0 , 'message' => __('Method not allowed for API')], 405);
        }

        if ($exception instanceof TokenMismatchException || ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException && $exception->getStatusCode() == 419)) {
            // If request is from Agent portal
            if ($request->is('agent/*') || $request->is('agent')) {
                return redirect()->route('agent.login')->with('info', 'আপনার সেশনের সময় শেষ হয়ে গেছে। অনুগ্রহ করে আবার লগইন করুন।');
            }
            // Check if the request is for the customer store
            if ($request->is('{storeSlug}/*') || $request->is('{storeSlug}')) {
                return redirect()->route('customer.login', ['storeSlug' => $request->route('storeSlug')]);
            }
            return redirect()->route('login')->with('info', __('Your session has expired. Please try again.'));
        }

        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
