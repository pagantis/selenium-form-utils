<?php

namespace Pagantis\SeleniumFormUtils\Step;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Clearpay\Clearpay\Test\ClearpayMagentoTest;

/**
 * Class OrderConfirmation
 *
 * @package Clearpay\SeleniumFormUtils\Step
 */
class OrderConfirmation extends AbstractStep
{
    /**
     * Handler step
     */
    const STEP = 'OrderConfirmation'
    ;

    /**
     * First step Confirm retrieved data
     *
     * @param bool $rejected
     * @return bool
     * @throws \Exception
     */
    public function run($rejected = false)
    {
        try{
            //Wait after redirection
            $simulatorElementSearch = WebDriverBy::id('OrderConfirmation-container');
            $condition  = WebDriverExpectedCondition::presenceOfElementLocated($simulatorElementSearch);
            $this->webDriver->wait()->until($condition);
        } catch (\Exception $e) {
            $errorElementSearch = WebDriverBy::className('technical-error-container');
            $condition  = WebDriverExpectedCondition::presenceOfElementLocated($errorElementSearch);
            $this->webDriver->wait()->until($condition);
            $this->assertTrue((bool) $condition, "ERROR ON ".self::STEP);
        }

        //Click on popup
        $buttonElementSearch = WebDriverBy::name('dialogButton');
        $condition  = WebDriverExpectedCondition::presenceOfElementLocated($buttonElementSearch);
        $this->webDriver->wait()->until($condition);
        $formContinue = $this->webDriver->findElement($buttonElementSearch)->click();
        sleep(3);

        //Click on confirm
        $buttonElementSearch = WebDriverBy::className('button-contained-primary');
        $condition  = WebDriverExpectedCondition::presenceOfElementLocated($buttonElementSearch);
        $this->webDriver->wait()->until($condition);
        $formContinue = $this->webDriver->findElement($buttonElementSearch)->click();

        sleep(5);

        return false;
    }
}