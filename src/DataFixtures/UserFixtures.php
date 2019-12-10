<?php

/*
 * Copyright (C) 2019 Mazarini <mazarini@protonmail.com>.
 * This file is part of mazarini/crud-bundle.
 *
 * mazarini/crud-bundle is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * mazarini/crud-bundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [$fullname, $username, $password, $email, $role]) {
            $user = new User();
            $user->setFullName($fullname);
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setRoles([$role]);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $manager->persist($user);
        }

        for ($i = 1; $i <= 5; ++$i) {
            $manager->persist($this->getEntity($i));
        }

        $manager->flush();
    }

    protected function getEntity(int $i): EntityInterface
    {
        $entity = new User();
        $entity->setUsername(sprintf('name%02d', $i));
        $entity->setFullName(sprintf('Name%02d', $i));
        $entity->setEmail(sprintf('name%02d@example.com', $i));
        $entity->setRoles(['ROLES_USER']);
        $entity->setPassword($this->passwordEncoder->encodePassword($entity, sprintf('pass%02d', $i)));

        return $entity;
    }

    /**
     * getUserData.
     *
     * @return array<int,array>
     */
    private function getUserData(): array
    {
        return [
            // $userData = [$fullname, $username, $password, $email, $role];
            ['Jane Doe', 'jane_admin', 'kitten', 'jane_admin@symfony.com', 'ROLE_ADMIN'],
            ['Tom Doe', 'tom_admin', 'kitten', 'tom_admin@symfony.com', 'ROLE_ADMIN'],
        ];
    }
}
