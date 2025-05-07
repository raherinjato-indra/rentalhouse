<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Twig\Environment;

class BaseController extends AbstractController
{
    public function Response(Environment $twig,$template,$data)
    {
        $session = new Session();
        //$session->start();
        //$id=$session->get('user');
        //
        $user = $this->getUser();
        //dd($user);
        if($user)
       {

           //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
           //$client = new \GuzzleHttp\Client();
           //$response2 = $client->request('GET', $this->getParameter('RESTUri')."utilisateur/".$user->getId());
			
           //dd($reveils);
           //$data["utilisateur"]=$utilisateur;
           $content = $twig->render($template,$data);

            return new Response($content);
       }
       else
       {
		    $content = $twig->render($template,$data);

            return new Response($content);
            //return $this->redirectToRoute('app_login');
       }
    }
    public function redirectTo($route,$data)
    {
        $session = new Session();
        //$session->start();
        $user = $this->getUser();

        if($user)
        {
            if($data)
                return $this->redirectToRoute($route,$data);
            else
                return $this->redirectToRoute($route);
        } else
        {
            return $this->redirectToRoute('app_login');
        }
    }

}