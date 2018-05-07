<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrandRepository")
 */
class Brand
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Model", mappedBy="brand")
     */
    private $models;
    
    public function __construct(){
        
        $this->models = new ArrayCollection();
    }
    /**
     * @return Collection|Model[]
     */
    public function getModels()
    {
        return $this->models;
    }

    public function getId(){
        
        return $this->id;
        
    }
    public function getName(){
    
        return $this->name;
    
    }
    
    
    public function setName($name){
    
        $this->name = $name;
    
    }
}
