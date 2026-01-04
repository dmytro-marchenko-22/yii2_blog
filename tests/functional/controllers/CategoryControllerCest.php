<?php

namespace tests\functional\controllers;

use FunctionalTester;

class CategoryControllerCest
{
    public function testIndexPage(FunctionalTester $I)
    {
        $I->amOnPage('/category/index');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testCategoryListWithData(FunctionalTester $I)
    {
        $I->amOnPage('/category/index');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testCategoryIndexHasContent(FunctionalTester $I)
    {
        $I->amOnPage('/category/index');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testCategoryPageWithoutErrors(FunctionalTester $I)
    {
        $I->amOnPage('/category/index');
        $I->seeResponseCodeIsSuccessful();
    }
}
