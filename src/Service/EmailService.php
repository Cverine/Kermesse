<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 19/12/18
 * Time: 22:10
 */

namespace App\Service;


class EmailService
{
    const FROM_EMAIL = 'severinelab@gmail.com';

    const FAIR_PARTICIPATION_EMAIL = [
        'subject'   => 'Votre participation à la kermesse',
        'renderHtml' => 'emails/confirm-fair-participation.html.twig'
    ];

    private $mailer;

    private $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendEmail($mail)
    {
        $message = (new \Swift_Message())
            ->setFrom(self::FROM_EMAIL)
            ->setTo($mail['to'])
            ->setSubject(self::FAIR_PARTICIPATION_EMAIL['subject'])
            ->setBody(
                $this->twig->render(self::FAIR_PARTICIPATION_EMAIL['renderHtml'], [
                    'name' => $mail['name'],
                    'participations' => $mail['participations']
                ]),
                'text/html'
            );
        $this->mailer->send($message);
    }
}