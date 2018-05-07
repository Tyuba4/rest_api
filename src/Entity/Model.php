<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModelRepository")
 */
class Model
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="models")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     */
    protected $brand;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $count;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getCount()
    {
        return $this->count;
    }
    public function getName()
    {
        return $this->name;
    }
    
    public function getBrand()
    {
        return $this->brand;
    }
    
    // Setters
    
    public function setCount($count){
    
        $this->count = $count;
    
    }
    public function setName($name){
    
        $this->name = $name;
    
    }
    public function setBrand($brand){
    
        $this->brand = $brand;
    
    }
    
    
}
