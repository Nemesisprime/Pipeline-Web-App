<?php

namespace Pipeline\APIBundle\API;


interface BindInterface
{
    public function setOwner(\Pipeline\APIBundle\Entity\User $owner = null);
    public function setCreatedAt($createdAt);
}
