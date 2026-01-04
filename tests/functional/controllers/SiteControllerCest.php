<?php

namespace tests\functional\controllers;

use FunctionalTester;

class SiteControllerCest
{
    public function testHomePage(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testAboutPage(FunctionalTester $I)
    {
        $I->amOnPage('/site/about');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testLoginPageAsGuest(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testSignupPageAsGuest(FunctionalTester $I)
    {
        $I->amOnPage('/site/signup');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testContactPageAsGuest(FunctionalTester $I)
    {
        $I->amOnPage('/site/contact');
        $I->seeResponseCodeIsSuccessful();
    }
}
