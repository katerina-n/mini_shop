<?php
namespace AppBundle\Model;

class Form
{
    protected $dateFirst;
    protected $dateLast;

    /**
     * Gets DateFirst.
     *
     * @return mixed|null
     */
    public function getDateFirst()
    {
        return $this->dateFirst;
    }

    /**
     * Sets DateFirst.
     *
     * @param mixed $dateFirst
     *
     * @return Form
     */
    public function setDateFirst($dateFirst): Form
    {
        $this->dateFirst = $dateFirst;
        return $this;
    }

    /**
     * Gets DateLast.
     *
     * @return mixed|null
     */
    public function getDateLast()
    {
        return $this->dateLast;
    }

    /**
     * Sets DateLast.
     *
     * @param mixed $dateLast
     *
     * @return Form
     */
    public function setDateLast($dateLast): Form
    {
        $this->dateLast = $dateLast;
        return $this;
    }
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->dateFirst;
    }

}
