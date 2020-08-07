<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\CurrencyChart;
use App\Http\Requests;
use Carbon\Carbon;
use Validator;
use URL;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Message\Response;

class CryptoController extends Controller
{
    public function calculate()
    {
        return view('crypto.calculate');
    }

    public function getIndex($param1, $param2)
    {
        return $this->validation($param1, $param2);
    }

    public function index(Request $request)
    {
        $param1 = $request->input('param1');
        $param2 = $request->input('param2');
        
        return $this->validation($param1, $param2);
    }

    public function validation($param1, $param2)
    {
        $param1 = strtoupper($param1);
        $param2 = strtoupper($param2);

        $validator = Validator::make([
            'param1' => $param1,
            'param2' => $param2
            ], [
            'param1' => 'required|in:EUR,CAD,HKD,DKK,AUD,SEK,USD,CHF,SGD,ZAR,GBP,PLN',
            'param2' => 'required|in:BTC,ETH,LTC,XRP,NEO,BAT,XLM,EOS,ADA'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('crypto.calculate')->withInput()->with('info', 'Make sure all the rules are being followed and the currency available!');
        }
        else {
            return $this->process($param1, $param2);
        }
    }

    public function process($param1, $param2)
    {
        $results = [];

        $client = new Client();
        $response = $client->get('https://www.alphavantage.co/query?function=DIGITAL_CURRENCY_MONTHLY&symbol='.$param2.'&market='.$param1.'&apikey=T6G1X1UQ88FA2OB5');
            
        $results = json_decode($response->getBody()->getContents(), true);

        $dates = [];
        $auxIndex = 11;
        for ($index = 0; $index <= 11; $index++) {
            if ($index == 0) {
                $date = Carbon::now()->subMonth($index)->toDateString();
            }
            else {
                $date = Carbon::now()->subMonth($index)->endOfMonth()->toDateString();
            }
            $dates[$auxIndex] = $date;
            $auxIndex--;
        }

        $lineChartRange = new CurrencyChart;
        $lineChartRange->title($param2.' Price Evol. '.'(on '.$param1.' market)', 26, '#000', true, 'Patua One');

        for ($index = 0; $index <= 11; $index++) {
            $lineChartRangeLabels[$index] = Carbon::parse($dates[$index])->format('M Y');
        }
                
        $lineChartRange->labels($lineChartRangeLabels);

        $averageFirstParam = 0;
        $averageSecondParam = 0;
        $averageThirdParam = 0;
        $averageFourthParam = 0;
        for ($index = 0; $index <= 11; $index++) {
            $lineChartFirstParam[$index] = $results['Time Series (Digital Currency Monthly)'][$dates[$index]]['1a. open ('.$param1.')'];
            $averageFirstParam += $results['Time Series (Digital Currency Monthly)'][$dates[$index]]['1a. open ('.$param1.')'];

            $lineChartSecondParam[$index] = $results['Time Series (Digital Currency Monthly)'][$dates[$index]]['2a. high ('.$param1.')'];
            $averageSecondParam += $results['Time Series (Digital Currency Monthly)'][$dates[$index]]['2a. high ('.$param1.')'];

            $lineChartThirdParam[$index] = $results['Time Series (Digital Currency Monthly)'][$dates[$index]]['3a. low ('.$param1.')'];
            $averageThirdParam += $results['Time Series (Digital Currency Monthly)'][$dates[$index]]['3a. low ('.$param1.')'];

            $lineChartFourthParam[$index] = $results['Time Series (Digital Currency Monthly)'][$dates[$index]]['4a. close ('.$param1.')'];
            $averageFourthParam += $results['Time Series (Digital Currency Monthly)'][$dates[$index]]['4a. close ('.$param1.')'];
        }
        $averageFirstParam /= 12;
        $averageSecondParam /= 12;
        $averageThirdParam /= 12;
        $averageFourthParam /= 12;

        $averageFirstParam = round($averageFirstParam);
        $averageSecondParam = round($averageSecondParam);
        $averageThirdParam = round($averageThirdParam);
        $averageFourthParam = round($averageFourthParam);

        $lineChartRange->dataset('Open', 'line', $lineChartFirstParam)
            ->color("rgb(92, 184, 92)")
            ->backgroundcolor("rgba(92, 184, 92, 0.5)")
            ->fill(false);

        $lineChartRange->dataset('High', 'line', $lineChartSecondParam)
            ->color("rgb(91, 192, 222)")
            ->backgroundcolor("rgba(91, 192, 222, 0.5)")
            ->fill(false);

        $lineChartRange->dataset('Low', 'line', $lineChartThirdParam)
            ->color("rgb(91, 192, 222)")
            ->backgroundcolor("rgba(91, 192, 222, 0.5)")
            ->fill(false);

        $lineChartRange->dataset('Close', 'line', $lineChartFourthParam)
            ->color("rgb(217, 83, 79)")
            ->backgroundcolor("rgba(217, 83, 79, 0.5)")
            ->fill(false);
        
        for ($index = 0; $index <= 11; $index++) {
            $barChartVolumeLabels[$index] = Carbon::parse($dates[$index])->format(' M Y ');
        }

        $barChartVolume = new CurrencyChart;
        $barChartVolume->title('Transaction Vol. of '.$param2.' (on USA market)', 28, '#000', true, 'Patua One');
        $barChartVolume->labels($barChartVolumeLabels);
        
        $averageParam = 0;
        for ($index = 0; $index <= 11; $index++) {
            $barChartParam[$index] = $results['Time Series (Digital Currency Monthly)'][$dates[$index]]['5. volume'];
            $averageParam += $results['Time Series (Digital Currency Monthly)'][$dates[$index]]['5. volume'];
        }
        $averageParam /= 12;
        $averageParam = round($averageParam);

        $barChartVolume->dataset('USD', 'bar', $barChartParam)
            ->color([
                "rgb(91, 192, 222)",
                "rgb(91, 192, 222)",
                "rgb(91, 192, 222)",
                "rgb(91, 192, 222)",
                "rgb(91, 192, 222)",
                "rgb(91, 192, 222)",
                "rgb(91, 192, 222)",
                "rgb(91, 192, 222)",
                "rgb(91, 192, 222)",
                "rgb(91, 192, 222)",
                "rgb(91, 192, 222)",
                "rgb(91, 192, 222)"
            ])
            ->backgroundcolor([
                "rgba(91 ,192, 222, 0.5)",
                "rgba(91 ,192, 222, 0.5)",
                "rgba(91 ,192, 222, 0.5)",
                "rgba(91 ,192, 222, 0.5)",
                "rgba(91 ,192, 222, 0.5)",
                "rgba(91 ,192, 222, 0.5)",
                "rgba(91 ,192, 222, 0.5)",
                "rgba(91 ,192, 222, 0.5)",
                "rgba(91 ,192, 222, 0.5)",
                "rgba(91 ,192, 222, 0.5)",
                "rgba(91 ,192, 222, 0.5)",
                "rgba(91 ,192, 222, 0.5)"
            ]);

        $downloadUrl = 'https://www.alphavantage.co/query?function=DIGITAL_CURRENCY_MONTHLY&symbol='.$param2.'&market='.$param1.'&apikey=T6G1X1UQ88FA2OB5&datatype=csv';
        $qrUrl = URL::to('crypto', [
            'param1' => $param1,
            'param2' => $param2
        ]);

        return view('crypto.index', [
            'averageParam' => $averageParam,
            'averageFirstParam' => $averageFirstParam,
            'averageSecondParam' => $averageSecondParam,
            'averageThirdParam' => $averageThirdParam,
            'averageFourthParam' => $averageFourthParam,
            'lineChartRange' => $lineChartRange,
            'barChartVolume' => $barChartVolume,
            'downloadUrl' => $downloadUrl,
            'qrUrl' => $qrUrl
        ]);
    }
}
