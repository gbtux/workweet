<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [

        ]);
    }

    #[Route('/publish/{id}', name: 'app_publish')]
    public function publish($id, HubInterface $hub, Request $request): Response
    {
        $json = $request->getContent();
        $content = json_decode($json);
        $update = new Update(
            'https://workweet.com/conversations/' . $id,
            json_encode(['message' => $content->message])
        );

        $hub->publish($update);

        return new Response('published!');
    }
}
