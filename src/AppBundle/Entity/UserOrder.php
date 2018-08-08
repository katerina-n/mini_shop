<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="user_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class UserOrder
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user", type="integer")
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="count_price", type="integer")
     */
    private $countPrice;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getCountPrice(): int
    {
        return $this->countPrice;
    }

    /**
     * @param int $countPrice
     */
    public function setCountPrice(int $countPrice): void
    {
        $this->countPrice = $countPrice;
    }

}