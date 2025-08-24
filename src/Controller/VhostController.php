<?php

namespace App\Controller;

use App\Entity\Vhost;
use App\Form\VhostGeneratorType;
use App\Repository\VhostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VhostController extends AbstractController
{
    #[Route('/admin/vhosts', name: 'app_vhost_index')]
    public function index(VhostRepository $vhostRepository): Response
    {
        $vhosts = $vhostRepository->findAll();

        return $this->render('vhost/index.html.twig', [
            'vhosts' => $vhosts,
        ]);
    }

    #[Route('/vhost/{id}/edit', name: 'app_vhost_edit')]
    public function newOrEdit(?Vhost $vhost, Request $request, VhostRepository $vhostRepository): Response
    {
        if (!is_object($vhost)) {
            $vhost = new Vhost();
        }
/*        $vhostDto = $vhostRepository->createDtoFromVhost($vhost);

        $form = $this->createForm(VhostGeneratorType::class, $vhostDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vhostRepository->submitForm($form->getData(), $vhost);

            $this->addFlash('success', 'El Vhost se ha guardado correctamente.');
            return $this->redirectToRoute('app_vhost_index');
        }
*/
        return $this->render('vhost/form.html.twig', [
            'vhost' => $vhost,
            //'form' => $form->createView(),
        ]);
    }
}
