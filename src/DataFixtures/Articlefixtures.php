<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class Articlefixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i ++){
            $article = new Article();
            $article
                ->setTitle($faker->sentence(5, true))
                ->setContent($faker->text(300))
                ->setCreatedAt($faker->dateTimeAD('now', null))
            ;
            $manager->persist($article);
        }
        $manager->flush();
    }
}
