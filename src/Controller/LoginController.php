<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController {

    private AuthenticationUtils $authenticationUtils;

    public function __construct(AuthenticationUtils $authenticationUtils) {
        $this->authenticationUtils = $authenticationUtils;
    }

    public function index(): Response {
        /*
          $this->addFlash('primary', '<a href="#" class="alert-link">Primary</a> Teste 123');
          $this->addFlash('secondary', '<a href="# class="alert-link">Secondary</a> Teste 123');
          $this->addFlash('success', '<a href="#" class="alert-link">Success</a> Teste 123');
          $this->addFlash('danger', '<a href="#" class="alert-link">Danger</a> Teste 123');
          $this->addFlash('warning', '<a href="#" class="alert-link">Warning</a> Teste 123');
          $this->addFlash('info', '<a href="#" class="alert-link">Info</a> Teste 123');
          $this->addFlash('light', '<a href="#" class="alert-link">Light</a> Teste 123');
          $this->addFlash('dark', '<a href="#" class="alert-link">Dark</a> Teste 123');
         */

        $this->addFlash('primary', '1. Teste realizado em: ' . date("d/m/Y H:i:s"));

        $error = $this->authenticationUtils->getLastAuthenticationError();

        $lastUsername = $this->authenticationUtils->getLastUsername();

        if (null !== $error) {
            $this->addFlash('danger', $error->getMessageKey() . ":" . $error->getCode() . ": " . $error->getMessage());
        }

        if ($lastUsername) {
            $this->addFlash('success', $lastUsername);
        }

        return $this->render('login/index.html.twig', compact('lastUsername'));
    }

}
