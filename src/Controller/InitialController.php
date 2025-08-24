<?php

namespace App\Controller;

use App\Entity\Initial;
use App\Form\InitialType;
use App\Repository\InitialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_initial_')]
final class InitialController extends AbstractController
{
    const PREFIX = 'app_initial_';

    #[Route(name: 'homepage', methods: ['GET', 'POST'])]
    public function index(InitialRepository $repo,): Response
    {
        $initials = $repo->findAll();

        return $this->render(
            'initial/index.html.twig',
            [
                'defaults' => null!=$initials
            ]
        );
    }

    #[Route('defaults', name: 'defaults', methods: ['GET', 'POST'])]
    public function defaults(Request $request, InitialRepository $repo, EntityManagerInterface $em): Response
    {
        $initials = $repo->findAll();
        if (null==$initials) {
            $initial = new Initial();
        } else {
            $initial = $initials[0];
        }

        $form = $this->createForm(InitialType::class, $initial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($initial);
            $em->flush();
        }

        return $this->render('initial/new.html.twig', [
            'initial' => $initial,
            'form' => $form,
            'PREFIX' => self::PREFIX,
        ]);
    }
}
