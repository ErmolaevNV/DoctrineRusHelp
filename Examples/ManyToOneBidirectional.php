<?php
/*
 * В данном примере описывается ДВУНАПРАВЛЕННАЯ связь 1 ко многим
 * Полученный продукт имеет в свойстве photos имеет список всех своих фотографий:
 *
 * $productRepository = $entityManager->getRepository(\App\Entity\Product::class);
 * $product = $productRepository->find(1);
 * $photos = $products->getPhotos();
 *
 * Но так же и можно получить продукт по фотографии.
 * $productRepository = $entityManager->getRepository(\App\Entity\ProductPhoto::class);
 * $photo = $productRepository->find(1);
 * $product = $photo->getProduct();
 * $product->getName()
 *
 * В реальных задачах такая двунаправленная(Bidirectional) связь приведёт к огромному количеству
 * нежелательных запросов в базу. К примеру если вы хотите получить список фотографий, то в придачу
 * к каждой фотографии вы получите по продукту.
 */

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

    public function __construct()
    {}

    /**
     * @return Product
     */
    public function getProduct() : Product
    {
        return $this->product;
    }
}