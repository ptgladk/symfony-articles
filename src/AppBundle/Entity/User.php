<?php

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 */
class User implements UserInterface
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $role;

    /**
     * @var integer
     */
    private $createdDate;

    /**
     * @var integer
     */
    private $loginDate;

    /**
     * @var boolean
     */
    private $active = true;

    /**
     * @var boolean
     */
    private $isPasswordChanged = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        if (!is_null($password)) {
            $this->password = $password;
            $this->isPasswordChanged = true;
        }

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set createdDate
     *
     * @param integer $createdDate
     *
     * @return User
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
     * Set loginDate
     *
     * @param integer $loginDate
     *
     * @return User
     */
    public function setLoginDate($loginDate)
    {
        $this->loginDate = $loginDate;

        return $this;
    }

    /**
     * Get loginDate
     *
     * @return integer
     */
    public function getLoginDate()
    {
        return $this->loginDate;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return User
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
     * PrePersist, PreUpdate
     */
    public function encryptPassword()
    {
        if ($this->isPasswordChanged) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }
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

    public function getRoles()
    {
        return array($this->role);
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @var string
     */
    private $token;

    /**
     * @var integer
     */
    private $tokenDate;


    /**
     * Set token
     *
     * @param string $token
     *
     * @return User
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set tokenDate
     *
     * @param integer $tokenDate
     *
     * @return User
     */
    public function setTokenDate($tokenDate)
    {
        $this->tokenDate = $tokenDate;

        return $this;
    }

    /**
     * Get tokenDate
     *
     * @return integer
     */
    public function getTokenDate()
    {
        return $this->tokenDate;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $articles;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $comments;

    /**
     * Add article
     *
     * @param \AppBundle\Entity\Article $article
     *
     * @return User
     */
    public function addArticle(\AppBundle\Entity\Article $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param \AppBundle\Entity\Article $article
     */
    public function removeArticle(\AppBundle\Entity\Article $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return User
     */
    public function addComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\Comment $comment
     */
    public function removeComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
