<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ResultatController extends AbstractController
{
    #[Route('/resultat', name: 'resultat')]
    public function index(MailerInterface $mailer): Response
    {

        $user = $this->getUser();
        $userEmail = $user->getEmail();
        $userFirstname = $user->getFirstname();

        $email = (new Email())
            ->from('resultat@riasec.com')
            ->to($userEmail)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Résultats RIASEC')
            ->text('Sending emails is fun again!')
            ->html('<p>'.$userFirstname.', merci d\'avoir effectué le test RIASEC.</p> 
                        <br>
                        <p>Voici vos résultats :</p>');

        $mailer->send($email);

        return $this->render('resultat/resultat.html.twig', [
            'controller_name' => 'ResultatController',
        ]);
    }
}
