<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var array
     * @ORM\OneToMany(targetEntity="ProductPhoto", mappedBy="product", orphanRemoval=true, cascade={"ALL"})
     */
    protected $photos;

    public function __construct() {
        $this->photos = new ArrayCollection();
    }
    
    /**
     * @return array
     */
    public function getPhotos() : array
    {
        return $this->photos->toArray();
    }
}

/**
 * @ORM\Entity
 */
class ProductPhoto
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="photos")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;
}