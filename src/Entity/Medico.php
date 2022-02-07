<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM; //especifica/declara que medico é uma entidade.
use Doctrine\ORM\Mapping\Id;

/**
 * @ORM\Entity()
 */

class Medico
{
    /**
     * @ORM\Id
     * @ORM\GenerateValue
     * @ORM\Column(Type="integer")
     */
    public $id;
    /**
     * @ORM\Column(Type="integer")
     */
    public $crm;
    /**
     * @ORM\Column(Type="string")
     */
    public $nome;

}