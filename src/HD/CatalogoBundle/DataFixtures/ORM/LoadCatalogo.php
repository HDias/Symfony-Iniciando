<?php

namespace HD\CatalogoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HD\CatalogoBundle\Entity\Catalogo;

class LoadCatalogo implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $catalogo = new Catalogo();
            $catalogo->setName('Nome do produto' . $i);
            $catalogo->setDescription('Descrição do Produto' . $i);
            $catalogo->setReleaseDate(new \DateTime('tomorrow'));
            $catalogo->setImageName('image' . $i . '.jpg');

            $manager->persist($catalogo);
        }

        $manager->flush();
    }
}