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
use ALT\AltEventplanner\Domain\Model\Signup;
use ALT\AltEventplanner\Domain\Repository\SignupRepository;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
  * Signup concerns
  */
class SignupController extends ActionController {

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

    public function formAction()
    {
        // nothing here
    }

    /**
     * @param Signup $signup
     */
    public function signupAction(Signup $signup)
    {
        $this->signupRepository->add($signup);
        $this->addFlashMessage('Danke fuer die Meldung. Die Daten wurden gespeichert', 'Erfolg', AbstractMessage::OK);
        $this->redirect('show', 'Calendar');
    }

}