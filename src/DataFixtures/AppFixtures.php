<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('en_US');
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < 4; $i++) {
            $category = new Category();
            $category->setName($faker->word);
            $categories[] = $category;

            $manager->persist($category);
        }
    
        for ($i = 0; $i < 50; $i++) {
            $article = new Article();
            $article->setTitle($faker->realText(30));
            $article->setDescription($faker->text(200));
            $article->setContent($faker->realTextBetween(250, 500));
            $article->setCreatedAt($faker->dateTimeBetween('-3 years')); 
            $article->setVisible(visible: $faker->boolean(70));

            $randomCategories = $categories[array_rand($categories)];
            $article->setCategory($randomCategories);

            $manager->persist($article);
        }

        $manager->flush();
    }
}

