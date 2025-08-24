<?php

namespace App\Controller;

use App\Entity\Initial;
use App\Form\InitialType;
use App\Repository\InitialRepository;
use App\Security\FileUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/', name: 'app_initial_')]
final class InitialController extends AbstractController
{
    const PREFIX = 'app_initial_';

    #[Route(name: 'homepage', methods: ['GET', 'POST'])]
    public function homepage(InitialRepository $repo,): Response
    {
        $userFile = $this->getParameter('app.user_credentials_file');
        // Verifica si el archivo de usuario existe
        if (!file_exists($userFile)) {
            // Si no existe, muestra el formulario de creación de usuario
            return $this->redirectToRoute(self::PREFIX . 'user');
        }

        $initials = $repo->findAll();

        return $this->render(
            'initial/homepage.html.twig',
            [
                'defaults' => null!=$initials
            ]
        );
    }

    #[Route('/create-user', name: 'user')]
    public function createUser(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $userFile = $this->getParameter('app.user_credentials_file');
        if (file_exists($userFile)) {
            return $this->redirectToRoute(self::PREFIX . 'homepage');
        }

        $form = $this->createFormBuilder()
            ->add('username', TextType::class, ['label' => 'Username'])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            ->add('create', SubmitType::class, ['label' => 'Create User'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $username = $data['username'];
            $password = $data['password'];

            $user = new FileUser();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $password
            );

            // Guarda el nombre de usuario y la contraseña en el archivo
            file_put_contents($userFile, json_encode([
                'username' => $username,
                'password' => $hashedPassword,
            ]));

            return $this->redirectToRoute(self::PREFIX . 'homepage');
        }

        return $this->render('initial/create_user.html.twig', [
            'form' => $form->createView(),
        ]);
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

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $userFile = $this->getParameter('app.user_credentials_file');
        if (!file_exists($userFile)) {
            return $this->redirectToRoute(self::PREFIX . 'user');
        }

        // Obtén el error de autenticación, si lo hay
        $error = $authenticationUtils->getLastAuthenticationError();

        // Obtén el último nombre de usuario introducido
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('initial/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/logout', name: 'logout', methods: ['GET'])]
    public function logout(): never
    {
        // El firewall se encargará de la desconexión.
        // No necesitas código aquí.
        throw new \Exception('This should never be reached!');
    }
}
