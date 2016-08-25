<?php

namespace AppBundle\Entity;

/**
 * Comment
 */
class Comment
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $text;

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
     * @var \AppBundle\Entity\Article
     */
    private $article;

    /**
     * @var \AppBundle\Entity\User
     */
    private $user;


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
     * Set text
     *
     * @param string $text
     *
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set createdDate
     *
     * @param integer $createdDate
     *
     * @return Comment
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
     * @return Comment
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
     * @return Comment
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
     * Set article
     *
     * @param \AppBundle\Entity\Article $article
     *
     * @return Comment
     */
    public function setArticle(\AppBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \AppBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Comment
     */
    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
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

    /**
     * PreUpdate
     */
    public function setUpdatedDateValue()
    {
        $this->updatedDate = time();
    }
}
