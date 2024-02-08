<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Entity\Address;
use App\Entity\Phone;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/user/step1', name: 'registerStep1', methods: ['POST'])]
    public function registerStep1(Request $request, UserRepository $userRepository)
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setFullName($data['fullName']);
        
        $user->setDateOfBirth(new \DateTime($data['dateOfBirth'], new \DateTimeZone('America/Sao_Paulo')));

        $userRepository->add($user, true);

        return new JsonResponse(['success' => true,  'id' => $user->getId()]);
    }

    #[Route('/user/step2', name: 'registerStep2', methods: ['POST'])]
    public function registerStep2(Request $request, UserRepository $userRepository)
    {
        $data = json_decode($request->getContent(), true);

        $user = $userRepository->find($data['id']);

        // Atualizar a entidade do usuário com os dados da etapa 2
        $address = new Address();
        $address->setNumber($data['number']);
        $address->setCity($data['city']);
        $address->setState($data['state']);
        $address->setZipCode($data['zipCode']);
        $user->setAddress($address);

        $userRepository->add($user, true);

        return new JsonResponse(['success' => true, 'id' => $user->getId()]);
    }

    #[Route('/user/step3', name: 'registerStep3', methods: ['POST'])]
    public function registerStep3(Request $request, UserRepository $userRepository)
    {
        $data = json_decode($request->getContent(), true);

        $user = $userRepository->find($data['id']);

        $phone = new Phone();
        
        $user->addPhone($phone);
        $user->addPhone($phone);

         $userRepository->add($user, true);

        return new JsonResponse(['success' => true]);
    }
}
