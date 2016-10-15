<?php
namespace ALT\AltEventplanner\Domain\Model;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
  * Event Model
  */
class Event extends AbstractEntity {

    /**
     * @var string
     * @validate StringLength(minimum=3, maximum=250)
     */
    protected $title;

    /**
     *
     * @var \DateTime
     */
    protected $begin;

    /**
     *
     * @var \DateTime
     */
    protected $end;

    /**
     *
     * @var integer
     */
    protected $minimumVolunteers;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ALT\AltEventplanner\Domain\Model\Signup>
     */
    protected $signUps;

    public function __construct()
    {
        $this->signUps = new ObjectStorage();
    }

    public function getSignups()
    {
        return $this->signUps;
    }

    public function setSignups($signups)
    {
        $this->signUps = $signups;
    }

    /**
     * @param Signup $signup
     */
    public function addSignUp(Signup $signup)
    {
        $this->signUps->attach($signup);
    }

    /**
     * @param Signup $signup
     */
    public function removeSignup(Signup $signup)
    {
        $this->signUps->detach($signup);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * @param \DateTime $begin
     */
    public function setBegin($begin)
    {
        $this->begin = $begin;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param \DateTime $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @return int
     */
    public function getMinimumVolunteers()
    {
        return $this->minimumVolunteers;
    }

    /**
     * @param int $minimumVolunteers
     */
    public function setMinimumVolunteers($minimumVolunteers)
    {
        $this->minimumVolunteers = $minimumVolunteers;
    }


}