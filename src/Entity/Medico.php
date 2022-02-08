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
     *@ORM\GeneratedValue
     *@ORM\Column(type="integer")
     */
    public $id;
    /**
     * @ORM\Column(type="integer")
     */
    public $crm;
    /**
     * @ORM\Column(type="string")
     */
    public $nome;

}