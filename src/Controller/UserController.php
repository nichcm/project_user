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
    #[Route('/user', name: 'getUsers', methods: ['GET'])]
    public function getUsers( UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();
        return $this->json([
            'data' => $users,
        ]);
    }

    #[Route('/user/{id}', name: 'getUserByid', methods: ['GET'])]
    public function getUserByid($id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find($id);

        if(!$user) throw $this->createNotFoundException('User not found');

        return $this->json($user);
    }

    #[Route('/user/saveUser', name: 'saveUser', methods: ['POST','PUT'])]
    public function saveUser(Request $request, UserRepository $userRepository)
    {
        $data = json_decode($request->getContent(), true);

        $userId = $data['userId'] ?? null;

        $user = new User();

        if ($userId) {
            $user = $userRepository->find($userId);

            if (!$user) throw $this->createNotFoundException('User not found');
        }

        $user->setFullName($data['fullName']);
        $user->setDateOfBirth(new \DateTime($data['dateOfBirth'], new \DateTimeZone('America/Sao_Paulo')));

        $userRepository->save($user, true);

        return new JsonResponse(['success' => true, 'id' => $user->getId()]);
    }
}
