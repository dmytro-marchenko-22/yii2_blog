<?php

namespace tests\functional\controllers;

use FunctionalTester;

class TagControllerCest
{
    public function testIndexPage(FunctionalTester $I)
    {
        $I->amOnPage('/tag/index');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testTagListLoads(FunctionalTester $I)
    {
        $I->amOnPage('/tag/index');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testTagIndexHasContent(FunctionalTester $I)
    {
        $I->amOnPage('/tag/index');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testTagPageWithoutErrors(FunctionalTester $I)
    {
        $I->amOnPage('/tag/index');
        $I->seeResponseCodeIsSuccessful();
    }
}
