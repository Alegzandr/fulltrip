<?php

namespace EntityBundle\Entity;

/**
 * Review
 */
class Review
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $addDate;

    /**
     * @var \DateTime
     */
    private $updateDate;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var int
     */
    private $grade;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set addDate
     *
     * @param string $addDate
     *
     * @return Review
     */
    public function setAddDate($addDate)
    {
        $this->addDate = $addDate;

        return $this;
    }

    /**
     * Get addDate
     *
     * @return string
     */
    public function getAddDate()
    {
        return $this->addDate;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return Review
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Review
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set grade
     *
     * @param integer $grade
     *
     * @return Review
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return int
     */
    public function getGrade()
    {
        return $this->grade;
    }
    /**
     * @var \EntityBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param \EntityBundle\Entity\User $user
     *
     * @return Review
     */
    public function setUser(\EntityBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \EntityBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @var \EntityBundle\Entity\Place
     */
    private $place;


    /**
     * Set place
     *
     * @param \EntityBundle\Entity\Place $place
     *
     * @return Review
     */
    public function setPlace(\EntityBundle\Entity\Place $place = null)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return \EntityBundle\Entity\Place
     */
    public function getPlace()
    {
        return $this->place;
    }
}
