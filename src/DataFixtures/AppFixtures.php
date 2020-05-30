<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // create user
        $user = new User();
        $user->setLogin('test');
        $user->setPassword($this->passwordEncoder->encodePassword($user,'Test123!'));
        $user->setRoles(array('ROLE_USER'));
        $user->setEmail('test@test.ru');
        $user->setName('Тестов Тест Тестович');
        // create admin
        $admin = new User();
        $admin->setLogin('admin');
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, 'Odmin123!'));
        $admin->setRoles(array('ROLE_ADMIN'));
        $admin->setEmail('admin@lstu-app.ru');
        $admin->setName('Admin');
        // insert users to database
        $manager->persist($user);
        $manager->persist($admin);
        // flush manager
        $manager->flush();
    }
}
