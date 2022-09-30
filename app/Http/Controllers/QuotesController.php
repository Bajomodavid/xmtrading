<?php

namespace App\Http\Controllers;

use App\Helpers\MakeChart;
use App\Helpers\PullCompanyQuotes;
use App\Http\Requests\GetHistoricalData;
use App\Models\CompanySymbol;
use App\Notifications\NotifyRecordsRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Notification;

class QuotesController extends Controller
{
    //
    public function index(): View
    {
        $companies = CompanySymbol::select('id', 'symbol')->get();
        return view('quotes.index')->with('companies', $companies);
    }

    public function getHistoricalData(GetHistoricalData $request): View
    {
        $data = new PullCompanyQuotes($request->symbol, $request->start, $request->end);
        $data->fetchQuotes();
        $quotes = $data->getQuotes();
        $chart = new MakeChart($quotes);
        $chart->setType();
        $chart->makeRecords();
        $company = CompanySymbol::where('symbol', $request->symbol)->select('company_name')->first();
        $message = 'From ' . date('Y-m-d', strtotime($request->start)) . ' to ' . date('Y-m-d', strtotime($request->end));
        Notification::route('mail', $request->email)
            ->notify(new NotifyRecordsRequest($company->company_name, $message));
        return view('quotes.history')
            ->with('records', $quotes)
            ->with('open', json_encode($chart->open))
            ->with('close', json_encode($chart->close))
            ->with('message', $message)
            ->with('labels', json_encode($chart->months));
    }
}
