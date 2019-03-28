<?php
/**
 * Created by PhpStorm.
 * User: severine
 * Date: 12/03/19
 * Time: 21:23
 */

namespace App\Controller;

use App\Entity\User;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="security_login")
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('connexion.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     * @throws \Exception
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * @Route("/forgottenPassword", name="app_forgotten_password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param TokenGeneratorInterface $tokenGenerator
     * @param EmailService $emailService
     * @return Response
     */
    public function forgottenPassword(Request $request,
                                      UserPasswordEncoderInterface $passwordEncoder,
                                      TokenGeneratorInterface $tokenGenerator,
                                      EmailService $emailService): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($user === null) {
                $this->addFlash('danger', 'Email inconnu');
                return $this->redirectToRoute('sonata_admin_dashboard');
            }

            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $entityManager->persist($user);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('sonata_admin_dashboard');
            }

            $url = $this->generateUrl('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

            $emailService->sendResetPassword($email, $url);
            $this->addFlash('notice', 'Email de changement de mot de passe envoyé');
            return $this->redirectToRoute('sonata_admin_dashboard');
        }
        return $this->render('forgotten_password.html.twig');
    }

    /**
     * @Route("/reset_password/{token}", name="app_reset_password")
     * @param Request $request
     * @param string $token
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $entityManager->getRepository(User::class)->findOneBy(['resetToken' => $token]);

            if ($user === null) {
                $this->addFlash('danger', 'Le lien n\'est pas valide');
                return $this->redirectToRoute('sonata_admin_dashboard');
            }

            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->get('password')));
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('notice', 'Le nouveau mot de passe a été enregistré');

            return $this->redirectToRoute('sonata_admin_dashboard');
        } else {
            return $this->render('reset_password.html.twig', ['token' => $token]);
        }
    }
}
