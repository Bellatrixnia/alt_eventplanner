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
     */
    public function showAction()
    {
        $events = $this->eventRepository->findAll();
        $calender = new Calendar();
        $currentMonth = $calender->renderMonth(2016,10);
        $this->view->assign('events', $events);
        $this->view->assign('calendar', $currentMonth);
    }
}