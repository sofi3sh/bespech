<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class HandleApiErrors
{
    public function handle($request, Closure $next)
    {
        try {
            return $next($request);
        } catch (AuthenticationException $exception) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        } catch (ValidationException $exception) {
            return response()->json(['error' => $exception->getMessage()], 422);
        } catch (\Exception $exception) {
            // Інші типи помилок можна обробити по-різному залежно від вашого випадку
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
}
