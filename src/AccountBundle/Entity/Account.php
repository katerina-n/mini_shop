<?php
declare(strict_types=1);
namespace AccountBundle\Entity;

use AppBundle\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Account
 */
class Account
{
//    /**
//     * @var int
//     * @ORM\Column(name="id", type="integer")
//     * @ORM\Id
//     * @ORM\GeneratedValue(strategy="AUTO")
//     *
//     */
//    private $id;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="type", type="string", length=20)
//     */
//    private $type;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="name", type="string", length=20)
//     */
//    private $name;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="email", type="string", length=40)
//     */
//    private $email;
//
//    /**
//     * One Chat has Many Messages.
//     *
//     * @OneToMany(targetEntity="AppBundle\Entity\Chat", mappedBy="visitor", mappedBy="agents")
//     */
//    private $chat;
//
//
//    /**
//     * Constructor
//     */
//    public function __construct()
//    {
//        $this->chat = new ArrayCollection();
//    }
//
//    /**
//     * Get id.
//     *
//     * @return int
//     */
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    /**
//     * Set type.
//     *
//     * @param string $type
//     *
//     * @return Account
//     */
//    public function setType($type)
//    {
//        $this->type = $type;
//
//        return $this;
//    }
//
//    /**
//     * Get type.
//     *
//     * @return string
//     */
//    public function getType()
//    {
//        return $this->type;
//    }
//
//    /**
//     * Set name.
//     *
//     * @param string $name
//     *
//     * @return Account
//     */
//    public function setName($name)
//    {
//        $this->name = $name;
//
//        return $this;
//    }
//
//    /**
//     * Get name.
//     *
//     * @return string
//     */
//    public function getName()
//    {
//        return $this->name;
//    }
//
//    /**
//     * Set email.
//     *
//     * @param string $email
//     *
//     * @return Account
//     */
//    public function setEmail($email)
//    {
//        $this->email = $email;
//
//        return $this;
//    }
//
//    /**
//     * Get email.
//     *
//     * @return string
//     */
//    public function getEmail()
//    {
//        return $this->email;
//    }
//
//    /**
//     * Set chat.
//     *@param ArrayCollection|Chat[] $chat
//     *
//     *@return $this
//     */
//    public function setChat($chat):self
//    {
//        foreach($chat as $value){
//            $this->addChat($value);
//        }
//        return $this;
//    }
//
//    /**
//     * Add chat.
//     *
//     * @param Chat $chat
//     *
//     * @return $this
//     */
//    public function addChat(Chat $chat):self
//    {
//        if(!$this->chat->contains($chat)) {
//            $chat->setChat($this);
//            $this->chat->add($chat);
//        }
//        return $this;
//    }
//
//    /**
//     * Remove chat.
//     *
//     * @param Chat $chat
//     *
//     * @return $this
//     */
//    public function removeChat(\AppBundle\Entity\Chat $chat):self
//    {
//        if(!$this->chat->contains($chat)){
//            $this->chat->removeElement($chat);
//        }
//        return $this->chat->removeElement($chat);
//    }

}
