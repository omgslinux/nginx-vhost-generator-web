<?php

namespace App\Controller;

use App\Entity\VhostType;
use App\Form\VhostTypeType;
use App\Repository\VhostTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

#[Route('/admin/vhosttype')]
final class VhostTypeController extends AbstractController
{
    #[Route(name: 'app_vhost_type_index', methods: ['GET'])]
    public function index(VhostTypeRepository $vhostTypeRepository): Response
    {
        return $this->render('vhost_type/index.html.twig', [
            'vhost_types' => $vhostTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vhost_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vhostType = new VhostType();
        $form = $this->createForm(
            VhostTypeType::class,
            $vhostType,
            [
                'copy_choices' => $this->getConfFiles()
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($vhostType);
            $entityManager->persist($vhostType);
            $entityManager->flush();
            $fs = new Filesystem();

            $templateDir = $this->getParameter('kernel.project_dir') . '/templates/vhost_templates/';
            $templateFileName = $vhostType->getName() . '_template.twig';

            $fs->dumpFile($templateDir . $templateFileName, $vhostType->getTemplate());

            return $this->redirectToRoute('app_vhost_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vhost_type/new.html.twig', [
            'vhost_type' => $vhostType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vhost_type_show', methods: ['GET'])]
    public function show(VhostType $vhostType): Response
    {
        return $this->render('vhost_type/show.html.twig', [
            'vhost_type' => $vhostType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vhost_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VhostType $vhostType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(
            VhostTypeType::class,
            $vhostType,
            [
                'copy_choices' => $this->getConfFiles()
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $fs = new Filesystem();

            $templateDir = $this->getParameter('kernel.project_dir') . '/templates/vhost_templates/';
            $templateFileName = $vhostType->getName() . '_template.twig';

            $fs->dumpFile($templateDir . $templateFileName, $vhostType->getTemplate());

            return $this->redirectToRoute('app_vhost_type_index', [], Response::HTTP_SEE_OTHER);
        }
        //dump($vhostType);

        return $this->render('vhost_type/edit.html.twig', [
            'vhost_type' => $vhostType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vhost_type_delete', methods: ['POST'])]
    public function delete(Request $request, VhostType $vhostType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vhostType->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($vhostType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vhost_type_index', [], Response::HTTP_SEE_OTHER);
    }

    private function getConfFiles(): array
    {
        $copyDir = '../templates/copy';
        $finder = new Finder();
        $finder->files()->in($copyDir)->name('*.conf');

        $files = [];
        foreach ($finder as $file) {
            $path = str_replace($copyDir . DIRECTORY_SEPARATOR, '', $file->getPathname());
            $files[$path] = $path; // Usamos el mismo valor para key y value
        }

        return $files;
    }
}
