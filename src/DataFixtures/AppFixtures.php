<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
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
        
        $regularUser = new User();
        $regularUser
            ->setUsername('Bobby')
            ->setEmail('bobby@bob.com')
            ->setPassword($this->hasher->hashPassword($regularUser, 'test'));
        $manager->persist($regularUser);

        $adminUser = new User();
        $adminUser
            ->setUsername('Admin')
            ->setEmail('admin@mycorp.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->hasher->hashPassword($adminUser, 'test'));
          
        $manager->persist($adminUser);

        $manager->flush();
    }
}

