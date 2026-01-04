<?php

namespace tests\functional\controllers;

use FunctionalTester;

class CommentControllerCest
{
    public function testIndexPage(FunctionalTester $I)
    {
        $I->amOnPage('/comment/index');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testCommentListLoads(FunctionalTester $I)
    {
        $I->amOnPage('/comment/index');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testCommentIndexHasContent(FunctionalTester $I)
    {
        $I->amOnPage('/comment/index');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testCommentPageWithoutErrors(FunctionalTester $I)
    {
        $I->amOnPage('/comment/index');
        $I->seeResponseCodeIsSuccessful();
    }
}
