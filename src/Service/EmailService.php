<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 19/12/18
 * Time: 22:10
 */

namespace App\Service;

use Swift_SwiftException;

class EmailService
{
    const FROM_EMAIL = 'severinelab@gmail.com';

    const FAIR_PARTICIPATION_EMAIL = [
        'subject'   => 'Votre participation à la kermesse',
        'renderHtml' => 'emails/confirm-fair-participation.html.twig'
    ];

    const RESET_PASSWORD_EMAIL = [
        'subject' => 'Mot de passe oublié',
        'renderHtml' => 'emails/reset_password.html.twig'
    ];

    private $mailer;

    private $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendParticipationEmail($mail)
    {
        $message = (new \Swift_Message());
        $message->setFrom(self::FROM_EMAIL);
        $message->setTo($mail['to']);

        $message->setSubject(self::FAIR_PARTICIPATION_EMAIL['subject'])
                ->setBody(
                    $this->twig->render(self::FAIR_PARTICIPATION_EMAIL['renderHtml'], [
                        'name' => $mail['name'],
                        'participations' => $mail['participations']
                        ]),
                    'text/html'
                );
        $this->mailer->send($message, $failure);
    }

    public function sendResetPassword($email, $url)
    {
        $message = (new \Swift_Message())
            ->setFrom(self::FROM_EMAIL)
            ->setTo($email)
            ->setSubject(self::RESET_PASSWORD_EMAIL['subject'])
            ->setBody(
                $this->twig->render(self::RESET_PASSWORD_EMAIL['renderHtml'], [
                    'url' => $url]),
                'text/html'
            );
        $this->mailer->send($message, $failure);
    }
}