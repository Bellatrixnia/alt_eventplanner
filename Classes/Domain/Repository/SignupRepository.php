<?php
namespace ALT\AltEventplanner\Domain\Repository;

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
use ALT\AltEventplanner\Domain\Model\Event;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
  * handles signups
  */
class SignupRepository extends Repository {

    public function findByUserAndEvent(Event $event, $userUid)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                [
                    $query->equals('frontenduser_uid', $userUid),
                    $query->equals('event_uid', $event->getUid())
                ]
            )
        );
        return $query->execute()->getFirst();
    }

    public function findActiveSignups($eventUid)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                [
                    $query->lessThan('signup_type', 3),
                    $query->equals('event_uid', $eventUid)
                ]
            )
        );
        return $query->execute()->count();
    }
}