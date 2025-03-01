<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\JWTAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class JwtHeaderAuthenticator extends JWTAuthenticator
{
    /**
     * Vérifie que l'en-tête Authorization est présent et valide.
     */
    public function supports(Request $request): bool
    {
        return true;
    }

    /**
     * Si l'en-tête Authorization est manquant, on déclenche une exception
     */
    public function authenticate(Request $request): Passport
    {
        if (!$request->headers->has('Authorization')) {
            throw new AuthenticationException('Authorization token missing.');
        }

        return parent::authenticate($request);
    }
}