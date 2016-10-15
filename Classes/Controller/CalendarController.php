<?php
namespace ALT\AltEventplanner\Controller;

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
use ALT\AltEventplanner\Domain\Repository\EventRepository;
use ALT\AltEventplanner\Service\Calendar;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
  * Display events in calendar design
  */
class CalendarController extends ActionController {


    /**
     * @var EventRepository
     */
    protected $eventRepository;

    /**
     * @param EventRepository $eventRepository
     */
    public function injectEventRepository(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     *
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    public function showAction()
    {

        $calender = new Calendar();

        /**
         * Get the current month and year as a fallback
         */
        $currentYearAndMonth = $calender->getCurrentYearAndMonth();

        /**
         * Check if te user has given the according parameters
         * If so, set them
         */
        if ($this->request->hasArgument('year') && $this->request->hasArgument('month')) {
            $currentYearAndMonth = [
                'year' => (int)$this->request->getArgument('year'),
                'month' => (int)$this->request->getArgument('month'),
            ];
        }
        /**
         * Get the next and previous month
         */
        $this->view->assignMultiple(
            [
                'nextMonthAndYear' => $calender->getNextMonth($currentYearAndMonth['year'],$currentYearAndMonth['month']),
                'prevMonthAndYear' => $calender->getPreviousMonth($currentYearAndMonth['year'],$currentYearAndMonth['month'])
            ]
        );


        $monthToDisplay = $calender->renderMonth($currentYearAndMonth['year'],$currentYearAndMonth['month']);


        $events = $this->eventRepository->findAll();
        $this->view->assign('events', $events);
        $this->view->assign('calendar', $currentYearAndMonth);
    }
}