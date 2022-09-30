<?php

namespace App\Helpers;

use Carbon\Carbon;

class MakeChart
{
    private array $records;
    private array $labels;
    public array $open;
    public array $close;
    const WEEK = 'week';
    const MONTH = 'month';
    const DAY = 'day';
    public string $type;
    public array $months;
    public array $data;
    private Carbon $start;
    private Carbon $end;

    public function __construct($records)
    {
        $this->records = $records;
        $this->months = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
        ];
        $this->open = [];
        $this->close = [];
    }

    public function setType(): void
    {
        $this->start = Carbon::createFromTimestamp($this->records[0]->date);
        $this->end = Carbon::createFromTimestamp(end($this->records)->date);
//        $difference = $this->start->diffInWeeks($this->end);
//        $this->makeLabels();
    }

    public function makeLabels()
    {
//        $this->makeRecords();
//        if ($difference > 8) {
//            $this->makeMonthLabel();
//        } elseif ($difference < 8 && $difference > 1) {
//            $this->makeWeekLabel();
//        } else {
//            $this->makeDayLabel();
//        }
    }

//    public function makeWeekLabel()
//    {
//        $this->type = self::WEEK;
//        $weeks = $this->start->diffInWeeks($this->end);
//        $count = 1;
//
//        while ($count <= $weeks) {
//            $this->labels[] = 'Week ' . $count;
//            $count++;
//        }
//    }

//    public function makeMonthLabel()
//    {
//        $this->type = self::MONTH;
//        $months = $this->start->diffInMonths($this->end);
//        $this->labels = array_slice($this->months, 0, $months+1);
//    }

//    public function makeDayLabel()
//    {
//        $this->type = self::DAY;
//        $days = $this->start->diffInDays($this->end);
//        $count = 1;
//
//        while ($count <= $days) {
//            $this->labels[] = 'Day ' . $count;
//            $count++;
//        }
//    }

    public function makeRecords()
    {
        foreach ($this->months as $key => $month) {
            $this->makeMonthData($key+1);
        }
    }

    public function makeMonthData($month)
    {
        $open = [];
        $close = [];
        foreach ($this->records as $key => $record) {
            $date = Carbon::createFromTimestamp($record->date);
            if ($date->month === $month) {
                if($record->open) {
                    $open[] = $record->open;
                }
                if($record->close) {
                    $close[] = $record->close;
                }
                array_splice($this->records, $key, 1);
            }
        }
        $this->makeMedian($open);
        $this->makeMedian($close, false);
    }

    public function makeMedian(array $records, bool $open = true)
    {
        $a = array_filter($records);
        $sum = array_sum($a);
        if ($sum > 0) {
            $average = $sum/count($a);
        } else {
            $average = 0;
        }

        $open ? $this->open[] = $average : $this->close[] = $average;
    }
}