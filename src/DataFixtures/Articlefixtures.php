<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class Articlefixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = $manager->getRepository(User::class)->find(4);
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i ++){
            $article = new Article();
            $article
                ->setTitle($faker->sentence(10, true))
                ->setContent($faker->text(1000))
                ->setCreatedAt($faker->dateTimeAD('now', null))
                ->setUser($user);
            ;
            $manager->persist($article);
        }
        $manager->flush();
    }
}
