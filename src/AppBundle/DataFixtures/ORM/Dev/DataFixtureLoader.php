<?php

namespace AppBundle\DataFixtures\ORM\Dev;

use Hautelook\AliceBundle\Doctrine\DataFixtures\AbstractLoader;

class DataFixtureLoader extends AbstractLoader
{
    public function getFixtures()
    {
        return [
            __DIR__ . '/category.yml',
            __DIR__ . '/tag.yml',
            __DIR__ . '/book.yml',
        ];
    }
}
