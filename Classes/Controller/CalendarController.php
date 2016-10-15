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
use ALT\AltEventplanner\Domain\Model\Event;
use ALT\AltEventplanner\Domain\Model\Signup;
use ALT\AltEventplanner\Domain\Repository\EventRepository;
use ALT\AltEventplanner\Domain\Repository\SignupRepository;
use ALT\AltEventplanner\Service\Calendar;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
  * Display events in calendar design
  */
class CalendarController extends ActionController {


    /**
     * @var EventRepository
     */
    protected $eventRepository;

    /**
     * @var SignupRepository
     */
    protected $signupRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     */
    protected $persistenceManager;

    /**
     * @param EventRepository $eventRepository
     */
    public function injectEventRepository(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param PersistenceManager $persistenceManager
     */
    public function injectPersistenceManager(PersistenceManager $persistenceManager)
    {
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * @param SignupRepository $signupRepository
     */
    public function injectSignupRepository(SignupRepository $signupRepository)
    {
        $this->signupRepository = $signupRepository;
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


        $events = $this->eventRepository->findByMonthAndYear($currentYearAndMonth['year'],$currentYearAndMonth['month']);
        $monthToDisplay = $calender->renderMonth($currentYearAndMonth['year'],$currentYearAndMonth['month'], $events);

        $this->view->assign('calendar', $currentYearAndMonth);
        $this->view->assign('monthToDisplay', $monthToDisplay);
    }

    public function signupAction()
    {
        $event = null;
        if ($this->request->hasArgument('event')) {
            /** @var Event $event */
            $event = $this->eventRepository->findByUid($this->request->getArgument('event'));
        }
        /** @var Signup $signUp */
        $signUp = $this->signupRepository->findByUserAndEvent($event, $GLOBALS['TSFE']->fe_user->user['uid']);
        if($signUp === null) {
            $signUp = $this->objectManager->get(Signup::class);
            $signUp->setEventUid($event);
        }
        $this->view->assign('signup', $signUp);
    }

    public function saveAction(Signup $signUp)
    {
        $signUp->setFrontenduserUid($GLOBALS['TSFE']->fe_user->user['uid']);
        $event = $signUp->getEventUid();
        $event->addSignUp($signUp);
        $this->eventRepository->update($event);
        $this->redirect('show');
    }
}