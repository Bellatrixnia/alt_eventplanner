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

/**
  * Signup Model
  */
class Signup extends AbstractEntity {

    /**
     * @var integer
     */
    protected $frontenduserUid;

    /**
     * @var \ALT\AltEventplanner\Domain\Model\Event
     */
    protected $eventUid;

    /**
     * @var integer
     */
    protected $signupType;

    /**
     * @return int
     */
    public function getFrontenduserUid()
    {
        return $this->frontenduserUid;
    }

    /**
     * @param int $frontenduserUid
     */
    public function setFrontenduserUid($frontenduserUid)
    {
        $this->frontenduserUid = $frontenduserUid;
    }

    /**
     * @return Event
     */
    public function getEventUid()
    {
        return $this->eventUid;
    }

    /**
     * @param Event $eventUid
     */
    public function setEventUid($eventUid)
    {
        $this->eventUid = $eventUid;
    }

    /**
     * @return int
     */
    public function getSignupType()
    {
        return $this->signupType;
    }

    /**
     * @param int $signupType
     */
    public function setSignupType($signupType)
    {
        $this->signupType = $signupType;
    }


}