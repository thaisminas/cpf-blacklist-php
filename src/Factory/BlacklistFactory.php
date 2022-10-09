<?php

namespace App\Factory;

use App\Entity\Blacklist;

class BlacklistFactory implements EntityFactoryInterface
{

    public function createEntity(string $json): Blacklist
    {
        $data = json_decode($json);

        $list = new Blacklist();

        $list->setCpf($data->cpf);

        return $list;
    }
}