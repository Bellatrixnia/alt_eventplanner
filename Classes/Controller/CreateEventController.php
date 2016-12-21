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
use ALT\AltEventplanner\Domain\Repository\EventRepository;
use ALT\AltEventplanner\Domain\Repository\SignupRepository;
use ALT\AltEventplanner\Service\CreateEventService;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;


/**
  * Display Form for Backend-Modules
  */
class CreateEventController extends ActionController {

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

    protected $defaultViewObjectName = BackendTemplateView::class;

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


    public function showFormAction(){
        // Include DateTimePicker
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Backend/DateTimePicker');

    }

    public function submitAction(){

        $arguments = $this->request->getArguments();

        $eventTitle = $arguments['title'];
        $eventStart = $arguments['startDate'];
        /**
         * String aus $eventStart in ein DateTime-Objekt konvertieren
         */
        $eventStartDT = \DateTime::createFromFormat('H:i d-m-Y', $eventStart, new \DateTimeZone('Europe/Berlin'));

        $eventEnd = $arguments['endDate'];
        /**
         * String aus $eventEnd in ein Datetime-Objekt konvertieren
         */
        $eventEndDT = \DateTime::createFromFormat('H:i d-m-Y', $eventEnd, new \DateTimeZone('Europe/Berlin'));

        $eventRepetition = $arguments['repetition'];

        $eventFinish = $arguments['finishDate'];
        /**
         * String aus $eventFinish in ein Datetime-Objekt konvertieren
         */
        $eventFinishDT = \DateTime::createFromFormat('d-m-Y', $eventFinish, new \DateTimeZone('Europe/Berlin'));

        $eventVolunteers = (int) $arguments['minimum_volunteers'];


        /** @var CreateEventService $eventService */
        $eventService = GeneralUtility::makeInstance(CreateEventService::class);
        $repetitionEvents = $eventService->getDates($eventStartDT, $eventEndDT, $eventFinishDT, $eventRepetition);

        foreach ($repetitionEvents as $index => $repetitionEvent) {
            /** @var Event $eventToPersist */
            $eventToPersist = GeneralUtility::makeInstance(Event::class);
            $eventToPersist->setTitle($eventTitle);
            $eventToPersist->setBegin($repetitionEvent['start']);
            $eventToPersist->setEnd($repetitionEvent['end']);
            $eventToPersist->setMinimumVolunteers($eventVolunteers);
            $this->eventRepository->add($eventToPersist);
            $this->persistenceManager->persistAll();
        }
        $this->view->assign('events', $repetitionEvents);
        $this->view->assign('title', $eventTitle);
    }
}