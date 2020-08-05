<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\CurrencyChart;
use App\Http\Requests;
use DateTime;
use Validator;
use URL;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Message\Response;

class RateChartController extends Controller
{
    public function calculate()
    {
        return view('rates.calculate');   
    }

    public function getIndex($param1, $param2, $param3, $startYear, $endYear)
    {
        return $this->validation($param1, $param2, $param3, $startYear, $endYear);
    }

    public function index(Request $request)
    {
        $param1 = $request->input('param1');
        $param2 = $request->input('param2');
        $param3 = $request->input('param3');
        $startYear = $request->input('startYear');
        $endYear = $request->input('endYear');
        
        return $this->validation($param1, $param2, $param3, $startYear, $endYear);
    }

    public function validation($param1, $param2, $param3, $startYear, $endYear)
    {
        if (is_numeric($startYear) && is_numeric($endYear)) {
            if ($startYear + 15 > now()->year) {
                $endInterval = now()->year;
            }
            else {
                $endInterval = $startYear + 15;
            }
        }
        else {
            return redirect()->route('rates.calculate')->withInput()->with('info', 'Make sure all the rules are being followed and all currencies available!');
        }

        $param1 = strtoupper($param1);
        $param2 = strtoupper($param2);
        $param3 = strtoupper($param3);

        $validator = Validator::make([
            'param1' => $param1,
            'param2' => $param2,
            'param3' => $param3,
            'startYear' => $startYear,
            'endYear' => $endYear
            ], [
            'param1' => 'required|in:EUR,CAD,HKD,DKK,AUD,SEK,USD,CHF,SGD,ZAR,GBP,PLN',
            'param2' => 'required|in:EUR,CAD,HKD,DKK,AUD,SEK,USD,CHF,SGD,ZAR,GBP,PLN',
            'param3' => 'required|in:EUR,CAD,HKD,DKK,AUD,SEK,USD,CHF,SGD,ZAR,GBP,PLN',
            'startYear' => 'required|integer|between:2000,'.((now()->year)-1),
            'endYear' => 'required|integer|between:'.($startYear+1).','.($endInterval)
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('rates.calculate')->withInput()->with('info', 'Make sure all the rules are being followed and all currencies available!');
        }
        else {
            return $this->process($param1, $param2, $param3, $startYear, $endYear);
        }
    }

    public function process($param1, $param2, $param3, $startYear, $endYear)
    {
        $results = [];

        for ($index = 0; $index <= date('Y') - $startYear; $index++) {
            $client = new Client();
            $response = $client->get('https://api.exchangeratesapi.io/'.date('Y-m-d', strtotime('- 1 days - '.$index.' years')).'?base='.$param1.'&symbols='.$param2.','.$param3);
            $results[$index] = json_decode($response->getBody()->getContents(), true);
        }

        for ($index = 0; $index <= 11; $index++) {
            $client = new Client();
            $response = $client->get('https://api.exchangeratesapi.io/'.date('Y-m-d', strtotime('- 1 days - '.$index.' months')).'?base='.$param1.'&symbols='.$param2.','.$param3);
            $resultsMonths[$index] = json_decode($response->getBody()->getContents(), true);
        }
        
        $startIndex = date('Y') - $startYear;
        $endIndex = date('Y') - $endYear;

        $barChart = new CurrencyChart;
        $barChart->title($startYear.' vs. '.$endYear.' (endpoints)', 28, '#000', true, 'Patua One');
        $barChart->labels([$param1, $param2, $param3]);
        $barChart->dataset($startYear, 'bar', [
            1.0,
            $results[$startIndex]['rates'][$param2],
            $results[$startIndex]['rates'][$param3]
        ])
            ->color([
                "rgb(255, 199, 132)",
                "rgb(178, 151, 0)",
                "rgb(255, 100, 132)"
            ])
            ->backgroundcolor([
                "rgba(255, 199, 132, 0.5)",
                "rgba(178, 151, 0, 0.5)",
                "rgba(255, 100, 132, 0.5)"
            ]);

        $barChart->dataset($endYear, 'bar', [
            1.0,
            $results[$endIndex]['rates'][$param2],
            $results[$endIndex]['rates'][$param3]
        ])
            ->color([
                "rgb(255, 199, 132)",
                "rgb(178, 151, 0)",
                "rgb(255, 100, 132)"
            ])
            ->backgroundcolor([
                "rgb(255, 199, 132)",
                "rgb(178, 151, 0)",
                "rgb(255, 100, 132)"
            ]);
            

        $firstDayOfPreviousMonth = date("n", strtotime("first day of previous month + 1 month"));
        for ($index = 1; $index <= $firstDayOfPreviousMonth; $index++) {
            $dateObj = DateTime::createFromFormat('!m', $index);
            $auxIndex = $index - 1;
            $months[$auxIndex] = $dateObj->format('F');
        }

        $radarChart = new CurrencyChart;
        $radarChart->title(now()->year, 26, '#000', true, 'Patua One');
        $radarChart->displayAxes(false);
        $radarChart->labels($months);
            
        for ($index = 0; $index <= $firstDayOfPreviousMonth - 1; $index++) {
            $radarChartFirstParam[$index] = 1.0;
        }
        
        $radarChart->dataset($param1, 'radar', $radarChartFirstParam)
            ->color("rgb(255, 199, 132)")
            ->backgroundcolor("rgba(255, 199, 132, 0.5)");
            
        for ($index = 0; $index <= $firstDayOfPreviousMonth - 1; $index++) {
            $auxIndex = $firstDayOfPreviousMonth - 1 - $index;
            $radarChartSecondParam[$index] = $resultsMonths[$auxIndex]['rates'][$param2];
        }
    
        $radarChart->dataset($param2, 'radar', $radarChartSecondParam)
            ->color("rgb(178, 151, 0)")
            ->backgroundcolor("rgba(178, 151, 0, 0.5)");
    
        for ($index = 0; $index <= $firstDayOfPreviousMonth - 1; $index++) {
            $auxIndex = $firstDayOfPreviousMonth - 1 - $index;
            $radarChartThirdParam[$index] = $resultsMonths[$auxIndex]['rates'][$param3];
        }
    
        $radarChart->dataset($param3, 'radar', $radarChartThirdParam)
            ->color("rgb(255, 100, 132)")
            ->backgroundcolor("rgba(255, 100, 132, 0.5)");
        

        $pieChart = new CurrencyChart;
        $pieChart->title($endYear, 26, '#000', true, 'Patua One');
        $pieChart->displayAxes(false);
        $pieChart->labels([$param1, $param2, $param3]);

        $pieChart->dataset('Currencies', 'doughnut', [
            1.0,
            $results[$endIndex]['rates'][$param2],
            $results[$endIndex]['rates'][$param3]
        ])
            ->backgroundcolor([
                "rgb(255, 199, 132)",
                "rgb(178, 151, 0)",
                "rgb(255, 100, 132)"
            ]);
        
        $lineChartInterval = new CurrencyChart;
        $lineChartInterval->title($startYear.' vs. '.$endYear.' (interval)', 26, '#000', true, 'Patua One');

        $auxIndex = -1;
        for ($index = $startYear; $index <= $endYear; $index++) {
            $lineChartIntervalLabels[++$auxIndex] = $index;
        }
                
        $lineChartInterval->labels($lineChartIntervalLabels);

        for ($index = 0; $index <= 19; $index++) {
                $lineChartIntervalFirstParam[$index] = 1.0;
        }

        $lineChartInterval->dataset($param1, 'line', $lineChartIntervalFirstParam)
            ->color("rgb(255, 199, 132)")
            ->backgroundcolor("rgba(255, 199, 132, 0.5)")
            ->fill(false);

        $averageParam2 = 0;
        $auxIndex = -1;
        for ($index = $startIndex; $index >= $endIndex; $index--) {
            $lineChartIntervalSecondParam[++$auxIndex] = $results[$index]['rates'][$param2];
            $averageParam2 += $results[$index]['rates'][$param2];
        }
        $averageParam2 /= ($endYear-$startYear+1);

        $lineChartInterval->dataset($param2, 'line', $lineChartIntervalSecondParam)
            ->color("rgb(178, 151, 0)")
            ->backgroundcolor("rgba(178, 151, 0, 0.5)")
            ->fill(false);

        $averageParam3 = 0;
        $auxIndex = -1;
        for ($index = $startIndex; $index >= $endIndex; $index--) {
            $lineChartIntervalThirdParam[++$auxIndex] = $results[$index]['rates'][$param3];
            $averageParam3+=$results[$index]['rates'][$param3];
        }
        $averageParam3 /= ($endYear - $startYear + 1);

        $lineChartInterval->dataset($param3, 'line', $lineChartIntervalThirdParam)
            ->color("rgb(255, 100, 132)")
            ->backgroundcolor("rgba(255, 100, 132, 0.5)")
            ->fill(false);
            
        $qrUrl = URL::to('rates', [
            'param1' => $param1,
            'param2' => $param2,
            'param3' => $param3,
            'startYear' => $startYear,
            'endYear' => $endYear,
        ]);

        return view('rates.index', [
            'barChart' => $barChart,
            'radarChart' => $radarChart,
            'pieChart' => $pieChart,
            'lineChartInterval' => $lineChartInterval,
            'param1' => $param1,
            'param2' => $param2,
            'param3' => $param3,
            'startYear' => $startYear,
            'endYear' => $endYear,
            'averageParam2' => $averageParam2,
            'averageParam3' => $averageParam3,
            'startYearParam2' => $results[$startIndex]['rates'][$param2],
            'startYearParam3' => $results[$startIndex]['rates'][$param3],
            'endYearParam2' => $results[$endIndex]['rates'][$param2],
            'endYearParam3' => $results[$endIndex]['rates'][$param3],
            'qrUrl' => $qrUrl
        ]);
    }
}
