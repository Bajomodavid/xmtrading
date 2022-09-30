<?php

namespace Tests\Unit;

use App\Helpers\PullCompanyJson;
use App\Helpers\PullCompanyQuotes;
use PHPUnit\Framework\TestCase;

class QuotesTest extends TestCase
{
    public function test_check_quotes_return_array()
    {
        $quotes = new PullCompanyQuotes('AIIT', '09/01/2016', '09/10/2022');
        $quotes->fetchQuotes();
        $result = $quotes->getQuotes();
        $this->assertIsArray($result);
    }

    public function test_check_companies_return_array()
    {
        $quotes = new PullCompanyJson();
        $quotes->getJson();
        $result = $quotes->getCompanies();
        $this->assertIsArray($result);
    }
}
