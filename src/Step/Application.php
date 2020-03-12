<?php

namespace Pagantis\SeleniumFormUtils\Step;

use Facebook\WebDriver\WebDriverBy;

/**
 * Class Application
 *
 * @package Pagantis\SeleniumFormUtils\Step
 */
class Application extends AbstractStep
{
    /**
     * Handler step
     */
    const STEP = 'Application';

    const VALID_CARD_NUMBER = '4111111111111111';

    const REJECTED_CARD_NUMBER = '4012888888881881';

    const CARD_CVC = '123';

    const CARD_HOLDER = 'John Doe';

    /**
     * Pass from confirm-data to next step in Application Form
     *
     * @param bool $rejected
     * @return bool
     * @throws \Exception
     */
    public function run($rejected = false)
    {
        $this->validateStep(self::STEP);

        try {
            $iframe = $this->webDriver->findElement(WebDriverBy::tagName('iframe'));
            $iFrameOneId = $iframe->getAttribute('name');
            $spreedlyCode = explode('-', $iFrameOneId);
            $iFrameTwoId = 'spreedly-cvv-frame-'.end($spreedlyCode);

            $this->moveToIFrame($iFrameOneId);
            $script = "document.getElementById('card_number').style.display";
            $cardStyle = $this->webDriver->executeScript($script);
            echo 'CardStyle=.'.$cardStyle;
            if ($cardStyle!='none')
            {
                $this->waitTobeVisible(WebDriverBy::id('card_number'));
                $creditCardNumber = $this->webDriver->findElement(WebDriverBy::name('card_number'));
                $card             = $rejected ? self::REJECTED_CARD_NUMBER : self::VALID_CARD_NUMBER;
                $creditCardNumber->clear()->sendKeys($card);
                $this->moveToParent();
                sleep(1);
                $fullName = $this->webDriver->findElement(WebDriverBy::name('fullName'));
                $fullName->clear()->sendKeys(self::CARD_HOLDER);
                $expirationDate = $this->webDriver->findElement(WebDriverBy::name('expirationDate'));
                $expirationDate->clear()->sendKeys('1221');
            } else {
                $this->moveToIFrame($iFrameTwoId);
                $cvv = $this->webDriver->findElement(WebDriverBy::id('cvv'));
                $cvv->clear()->sendKeys(self::CARD_CVC);
                $this->moveToParent();
            }
            sleep(1);
        } catch (\Exception $exception) {
            unset($exception);
            return false;
        }

        $formContinue = $this->webDriver->findElement(WebDriverBy::name('continue_button'));
        $formContinue->click();
        return true;
    }
}
