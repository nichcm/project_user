<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Phone;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;


class PhoneController extends AbstractController
{
    #[Route('/phone/userPhones', name: 'userPhones', methods: ['PUT', 'POST'])]
    public function userPhones(Request $request, ManagerRegistry $doctrine)
    {
        $data = json_decode($request->getContent(), true);

        $userRepository = $doctrine->getRepository(User::class);

        $user = $userRepository->find($data['userId']);

        $mobilePhone = $user->getPhones()->filter(function (Phone $phone) {
            return $phone->isMobile();
        })->first();

        if ($mobilePhone) {
            $mobilePhone->setPhoneNumber($data['mobilePhone']);
        } else {
            $mobilePhone = new Phone();
            $mobilePhone->setPhoneNumber($data['mobilePhone']);
            $mobilePhone->setMobile(true);
            $user->addPhone($mobilePhone);
        }

        $nonMobilePhone = $user->getPhones()->filter(function (Phone $phone) {
            return !$phone->isMobile();
        })->first();

        if ($nonMobilePhone) {
            $nonMobilePhone->setPhoneNumber($data['phone']);
        } else {
            $phone = new Phone();
            $phone->setPhoneNumber($data['phone']);
            $phone->setMobile(false);
            $user->addPhone($phone);
        }

        $doctrine->getManager()->flush();

        return new JsonResponse(['success' => true]);
    }
}
