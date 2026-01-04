<?php

namespace tests\functional\controllers;

use FunctionalTester;

class PostControllerCest
{
    public function testIndexPageAsGuest(FunctionalTester $I)
    {
        $I->amOnPage('/post/index');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testListPostsWithData(FunctionalTester $I)
    {
        $I->amOnPage('/post/index');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testIndexPageHasNoErrors(FunctionalTester $I)
    {
        $I->amOnPage('/post/index');
        $I->seeResponseCodeIsSuccessful();
    }
}
