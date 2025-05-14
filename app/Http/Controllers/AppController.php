<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\departement;
use App\Models\Employer;
use App\Models\payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        $totalDepartement = departement::all()->count();
        $totalEmployes = Employer::all()->count();
        $totalAdmin = User::all()->count();
        $totalPayment = payment::all()->count();

        $monthMapping = [
            'JANUARY' => 'JANVIER',
            'FEBRUARY' => 'FEVRIER',
            'MARCH' => 'MARS',
            'APRIL' => 'AVRIL',
            'MAY' => 'MAI',
            'JUNE' => 'JUIN',
            'JULY' => 'JUILLET',
            'AUGUST' => 'AOUT',
            'SEPTEMBER' => 'SEPTEMBRE',
            'OCTOBER' => 'OCTOBRE',
            'NOVEMBER' => 'NOVEMBRE',
            'DECEMBER' => 'DECEMBRE',
        ];
        $currentMonth = strtoupper(Carbon::now()->formatLocalized('%B'));
        //Month in French
        $currentMonthInFrench = $monthMapping[$currentMonth] ?? $currentMonth;
        $currentYear = Carbon::now()->format('Y');
        // recuperer les employers non paye pour le mois en cours
        $employers = Employer::whereDoesntHave('payments', function ($query) use ($currentMonthInFrench, $currentYear) {
            $query->where('month', '=', $currentMonthInFrench)
                ->where('year', '=', $currentYear);
        })->get();
        $nopayment = $employers->count();

        $defautPaymentDate = null;
        $paymentnotice = " ";
        $convertedDate = null;
        $currentDate = Carbon::now()->day;
        $defautPaymentDateQuery = Configuration::where('type', "PAYMENT_DATE")->first();
        if ($defautPaymentDateQuery) {
            $defautPaymentDate = $defautPaymentDateQuery->value;
            $convertedDate = intval($defautPaymentDate);
            if ($currentDate <= $convertedDate) {
                $paymentnotice = "Le paiement doit etre fait le " . $defautPaymentDate . " de ce mois";
            } else {
                $nextMonth = Carbon::now()->addMonth()->format("F");
                $paymentnotice = "Le paiement doit etre fait le " . $defautPaymentDate . " du mois de " . $nextMonth;
            }
        }
        // dd($defautPaymentDateQuery);
        return view('dashboard', compact('totalDepartement', 'totalEmployes', 'totalAdmin', 'paymentnotice', 'convertedDate', 'nopayment',));
    }
}
