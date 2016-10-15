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
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
  * handle events
  */
class EventRepository extends Repository {

    /**
     * @var SignupRepository
     */
    protected $signupRepository;

    /**
     * @param SignupRepository $signupRepository
     */
    public function injectSignupRepository(SignupRepository $signupRepository)
    {
        $this->signupRepository = $signupRepository;
    }

    public function findByMonthAndYear($year, $month)
    {

        $out = [];
        $start = mktime(0, 0, 0, (int)$month, 1, (int)$year);
        $end = mktime(0, 0, 0, (int)$month, date('t', $start), (int)$year);
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->greaterThanOrEqual('begin', $start),
                $query->lessThanOrEqual('end', $end)
            ]
            )
        );
        $results = $query->execute(true);
        foreach ($results as $index => $result) {
            $amountOfSignups = $this->signupRepository->findActiveSignups($result['uid']);
            $dateIdent = date('Ynj', $result['begin']);
            switch (true) {
                case (int)$amountOfSignups === 0:
                    $result['status'] = 'no-signups';
                    break;
                case (int)$amountOfSignups < (int)$result['minimum_volunteers']:
                    $result['status'] = 'needs-more-signups';
                    break;
                case (int)$amountOfSignups >= (int)$result['minimum_volunteers']:
                    $result['status'] = 'has-signups';
                    break;
            }
            $out[$dateIdent][] = $result;
        }
        return $out;
    }

}