<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Address;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;


class AddressController extends AbstractController
{
    #[Route('/address/userAddress', name: 'userAddress', methods: ['POST', 'PUT'])]
    public function userAddress(Request $request, ManagerRegistry $doctrine)
    {
        $data = json_decode($request->getContent(), true);

        $entityManager = $doctrine->getManager();

        $userId = $data['userId'] ?? null;

        $userRepository = $entityManager->getRepository(User::class);

        $user = null;

        if ($userId) {
            $user = $userRepository->find($userId);

            if (!$user) {
                throw $this->createNotFoundException('User not found');
            }
        }

        $user = $user ?: new User();

        $address = $user->getAddress();
        if (!$address) {
            $address = new Address();
        }

        $address->setNumber($data['number']);
        $address->setStreet($data['street']);
        $address->setCity($data['city']);
        $address->setState($data['state']);
        $address->setZipCode($data['zipCode']);

        $user->setAddress($address);

        $entityManager->persist($address); // Persiste o endereço
        $entityManager->persist($user); // Persiste o usuário

        $entityManager->flush();

        return new JsonResponse(['success' => true, 'id' => $user->getId()]);
    }
}
