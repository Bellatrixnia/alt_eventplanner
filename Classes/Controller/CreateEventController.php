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
use ALT\AltEventplanner\Domain\Repository\SignupRepository;
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
        $postVars = $_POST;
        $this->view->assign('postVariablen', $postVars);
        $this->view->assign('getVariablen', $_GET);
    }
}