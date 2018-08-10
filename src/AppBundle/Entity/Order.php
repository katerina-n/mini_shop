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
    private $id;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="AccountBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="summa", type="integer", nullable = true)
     */
    private $summa;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserOrder", mappedBy="order")
     *
     */
    private $order;
    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param  User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return int
     */
    public function getSumma(): int
    {
        return $this->summa;
    }

    /**
     * @param $summa
     */
    public function setSumma($summa)
    {
        $this->summa = $summa;
        return $this;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->order = new ArrayCollection();
    }

    public function setOrder($order):self
    {
        foreach($order as $value){
            $this->addOrder($value);
        }
        return $this;
    }
    /**
     * Add chat.
     *
     *
     * @return $this
     */
    public function addOrder(Order $order):self
    {
        if(!$this->order->contains($order)) {
            $order->setOrder($this);
            $this->order->add($order);
        }
        return $this;
    }
}