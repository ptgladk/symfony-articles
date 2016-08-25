<?php

namespace AppBundle\Entity;

/**
 * Category
 */
class Category
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $createdDate;

    /**
     * @var integer
     */
    private $updatedDate;

    /**
     * @var boolean
     */
    private $active = true;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $artiles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->artiles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set createdDate
     *
     * @param integer $createdDate
     *
     * @return Category
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return integer
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set updatedDate
     *
     * @param integer $updatedDate
     *
     * @return Category
     */
    public function setUpdatedDate($updatedDate)
    {
        $this->updatedDate = $updatedDate;

        return $this;
    }

    /**
     * Get updatedDate
     *
     * @return integer
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Category
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Add artile
     *
     * @param \AppBundle\Entity\Article $artile
     *
     * @return Category
     */
    public function addArtile(\AppBundle\Entity\Article $artile)
    {
        $this->artiles[] = $artile;

        return $this;
    }

    /**
     * Remove artile
     *
     * @param \AppBundle\Entity\Article $artile
     */
    public function removeArtile(\AppBundle\Entity\Article $artile)
    {
        $this->artiles->removeElement($artile);
    }

    /**
     * Get artiles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArtiles()
    {
        return $this->artiles;
    }

    /**
     * PrePersist
     */
    public function setCreatedDateValue()
    {
        if (!$this->getCreatedDate()) {
            $this->createdDate = time();
        }
    }
}
