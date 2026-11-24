<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->respond(function (Response $response, \Throwable $exception, Request $request) {
            if ($response->getStatusCode() === 419) {
                if ($request->hasSession()) {
                    $request->session()->regenerateToken();
                }

                // Jika klik Logout saat sesi sudah kedaluwarsa, langsung arahkan ke Login.
                if ($request->routeIs('logout') || $request->is('logout')) {
                    return redirect()->route('login');
                }

                // Jika submit Login dengan token lama/cache browser HP, muat ulang halaman Login dengan token baru.
                if ($request->routeIs('login') || $request->is('login')) {
                    return redirect()
                        ->route('login')
                        ->withInput($request->only('username'))
                        ->with('status', 'Sesi halaman telah diperbarui. Silakan klik LOG IN kembali.');
                }

                return back()
                    ->withInput($request->except('password', '_token'))
                    ->with('error', 'Sesi halaman telah diperbarui. Silakan ulangi tindakan Anda.');
            }

            return $response;
        });
    })->create();