<?php

namespace Database\Seeders;

use App\Helpers\PullCompanyJson;
use App\Models\CompanySymbol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeedCompanySymbol extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pullCompanyJson = new PullCompanyJson();
        $pullCompanyJson->getJson();
        $companies = $pullCompanyJson->getCompanies();
        CompanySymbol::insert($companies);
    }
}
