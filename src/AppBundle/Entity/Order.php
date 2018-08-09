<?php

namespace AppBundle\Entity;

use AccountBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Account
 *
 * @ORM\Table(name="order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 */
class Order
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id = 1;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product")
     * @ORM\JoinColumn(name="product", referencedColumnName="id")
     */
    private $product;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;

    /**
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="AccountBundle\Entity\User")
     * @ORM\JoinColumn(name="orderUser", referencedColumnName="id")
     */
    private $orderUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getProduct(): string
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param $product
     */
    public function setPrice($product): void
    {
        $price = $product->getPrice();
        $this->price = $price;
    }

    /**
     * @return int|null
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getOrderUser(): int
    {
        return $this->orderUser;
    }

    /**
     * @param int $orderUser
     */
    public function setOrderUser(User $orderUser): void
    {
        $this->orderUser = $orderUser;
    }

//    /**
//     * Set product.
//     *@param $product
//     *
//     *@return $this
//     */
//    public function setProduct($product):self
//    {
//        foreach($product as $value){
//            $this->addProduct($value);
//        }
//        return $this;
//    }

    /**
     * Add product.
     *
     * @param Product $product
     *
     * @return $this
     */
    public function addProduct(Product $product):self
    {
        if(!$this->product->contains($product)) {
            $product->setProduct($this);
            $this->product->add($product);
        }
        return $this;
    }


}