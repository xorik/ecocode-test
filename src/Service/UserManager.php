<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserManager
{
    /**
     * @var EncoderFactoryInterface
     */
    protected $encoderFactory;
    /**
     * @var EntityRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * UserManager constructor.
     *
     * @param EncoderFactoryInterface $ef
     * @param EntityManagerInterface  $em
     */
    public function __construct(
        EncoderFactoryInterface $ef,
        EntityManagerInterface $em
    ) {
        $this->userRepository = $em->getRepository(User::class);
        $this->encoderFactory = $ef;
        $this->em = $em;
    }

    /**
     * @param $email
     *
     * @return null|object
     */
    public function findUserByEmail($email)
    {
        return $this->userRepository->findOneBy(['email' => $email]);
    }

    /**
     * @param UserInterface $user
     */
    public function login(UserInterface $user)
    {
        $user->setLastLogin(new \DateTime());
        $user->incLoginCount();
        $this->saveUser($user);
    }

    /**
     * @param UserInterface $user
     */
    public function updatePassword(UserInterface $user)
    {
        $password = $user->getPlainPassword();
        if (0 < mb_strlen($password)) {
            $encoder = $this->getEncoder($user);
            $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
        }
    }

    /**
     * @param UserInterface $user
     */
    public function saveUser(UserInterface $user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param User $user
     */
    public function remove(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    /**
     * @param UserInterface $user
     *
     * @return mixed
     */
    protected function getEncoder(UserInterface $user)
    {
        return $this->encoderFactory->getEncoder($user);
    }
}
