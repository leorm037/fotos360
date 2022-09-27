<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends AbstractController
{

    public function index(): Response
    {
        /*
        $this->addFlash('primary', '<a href="#" class="alert-link">Primary</a> Teste 123');
        $this->addFlash('secondary', '<a href="#" class="alert-link">Secondary</a> Teste 123');
        $this->addFlash('success', '<a href="#" class="alert-link">Success</a> Teste 123');
        $this->addFlash('danger', '<a href="#" class="alert-link">Danger</a> Teste 123');
        $this->addFlash('warning', '<a href="#" class="alert-link">Warning</a> Teste 123');
        $this->addFlash('info', '<a href="#" class="alert-link">Info</a> Teste 123');
        $this->addFlash('light', '<a href="#" class="alert-link">Light</a> Teste 123');
        $this->addFlash('dark', '<a href="#" class="alert-link">Dark</a> Teste 123');
        */
        
        return $this->render('login/index.html.twig');
    }

}
