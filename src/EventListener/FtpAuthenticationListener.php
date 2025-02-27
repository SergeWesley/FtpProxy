<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FtpAuthenticationListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->attributes->get('ftp_required', false)) {
            $ftpUser = $request->headers->get('X-FTP_USER');
            $ftpPass = $request->headers->get('X_FTP_PASS');

            if (!isset($ftpUser)|| !isset($ftpPass)) {
                throw new BadRequestHttpException('Missing FTP credentials');
            }
        }
    }
}