<?php

namespace App\DataFixtures;

use App\Entity\Memoire;
use App\Entity\Tableau;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;


    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create();
        $memoires = [];
        for ($i = 0; $i < 25; $i++) {
            $memoire = new Memoire();
            $memoire->setTitre($faker->name());
            $memoire->setDescription($faker->city());
            $memoire->setDatePublication($faker->dateTime());
            $memoire->setImage($faker->imageUrl());
            array_push($memoires,$memoire);
            $manager->persist($memoire);
        }

        for ($i = 0; $i < 5; $i++) {
            $tableau = new Tableau();
            $tableau->setImageUrl($faker->imageUrl());
            $tableau->setTitre($faker->name());
            $tableau->setUrl(bin2hex(random_bytes(15)));
            for($j = 0;$j<$faker->randomNumber(1);$j++){
                $memoire = $faker->randomElement($memoires);
                $memoire->addtableaux($tableau);
                $tableau->addMemoire($memoire);
                $manager->persist($memoire);
            }
            $manager->persist($tableau);
        }

        $user = new User();
        $user->setNom($faker->lastName());
        $user->setPrenom($faker->firstName());
        $user->setImgUrl($faker->imageUrl());
        $password = $this->hasher->hashPassword($user, '1234');
        $user->setPassword($password);
        $user->setEmail('test@test.test');
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $user2 = new User();
        $user2->setNom($faker->lastName());
        $user2->setPrenom($faker->firstName());
        $user2->setImgUrl($faker->imageUrl());
        $password = $this->hasher->hashPassword($user, '1234');
        $user2->setPassword($password);
        $user2->setEmail('test2@test.test');
        $user2->setRoles(['ROLE_ADMIN']);
        $manager->persist($user2);


        $user3 = new User();
        $user3->setNom($faker->lastName());
        $user3->setPrenom($faker->firstName());
        $user3->setImgUrl($faker->imageUrl());
        $password = $this->hasher->hashPassword($user, '1234');
        $user3->setPassword($password);
        $user3->setEmail('test3@test.test');
        $user3->setRoles(['ROLE_ADMIN']);
        $manager->persist($user3);

        $manager->flush();
    }
}
