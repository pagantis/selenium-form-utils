<?php

namespace Pagantis\SeleniumFormUtils\Step\Result\Status;

use Pagantis\SeleniumFormUtils\Step\AbstractStep;

/**
 * Class Expired
 * @package Pagantis\SeleniumFormUtils\Step\Result\Status
 */
class Expired extends AbstractStep
{
    /**
     * Handler step
     */
    const STEP = '/result/status/expired';

    /**
     * Pass from confirm-data to next step in Application Form
     *
     * @throws \Exception
     */
    public function run()
    {
        $this->validateStep(self::STEP);
    }
}
