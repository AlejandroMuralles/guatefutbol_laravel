<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'rest/users-app/registrar',
        'rest/notificaciones/agregar-equipo-user',
        'rest/notificaciones/eliminar-equipo-user'
    ];
}
