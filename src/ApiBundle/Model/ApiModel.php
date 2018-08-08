<?php

declare(strict_types=1);

namespace ApiBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Type;

/**
 * Class ApiModel
 *
 * @ExclusionPolicy("all")
 */
class ApiModel
{

    /**
     * @var string
     *
     * @Expose
     * @Groups({"chat"})
     * @Type("string")
     * @ORM\Column(type="string")
     */
    private $obj;

    /**
     * @var string
     *
     * @Expose
     * @Groups({"chat"})
     * @Type("string")
     * @ORM\Column(type="string")
     */
    private $subj;

    /**
     * @var \DateTime
     *
     * @Expose
     * @Groups({"chat"})
     * @Type("DateTime<'Y-m-d'>")
     * @ORM\Column(type="string")
     */
    private $date;

    /**
     * @var string
     *
     * @Expose
     * @Groups({"chat"})
     * @Type("string")
     * @ORM\Column(type="string")
     */
    private $chat;
    /**
     * Gets Obj.
     *
     * @return string
     */
    public function getObj(): string
    {
        return $this->obj;
    }

    /**
     * Sets Obj.
     *
     * @param string $obj
     *
     * @return $this
     */
    public function setObj(string $obj): self
    {
        $this->obj = $obj;

        return $this;
    }

    /**
     * Gets Subj.
     *
     * @return string
     */
   public function getSubj(): string
    {
        return $this->subj;
    }

    /**
     * Sets Subj.
     *
     * @param string $subj
     *
     * @return $this
     */
   public function setSubj(string $subj): self
    {
        $this->subj = $subj;

        return $this;
    }

    /**
     * Gets Date.
     *
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * Sets Date.
     *
     * @param \DateTime $date
     *
     * @return $this
     */
    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Gets Chat.
     *
     * @return string
     */
    public function getChat(): string
    {
        return $this->chat;
    }

    /**
     * Sets Chat.
     *
     * @param string $chat
     *
     * @return ApiModel
     */
    public function setChat(string $chat): self
    {
        $this->chat = $chat;
        return $this;
    }


}