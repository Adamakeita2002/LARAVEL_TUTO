<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Employer;
use App\Models\payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Nette\Utils\Random;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index(payment $payment)
    {


        $defautPaymentDateQuery = Configuration::where('type', "PAYMENT_DATE")->first();
        if (!$defautPaymentDateQuery) {
            return redirect()->back()->with('error', 'Aucune date de paiement par défaut trouvée.');
        }
        $defautPaymentDate = $defautPaymentDateQuery->value;
        $convertedDate = intval($defautPaymentDate);
        // dd($convertedDate);
        $ispaymentDate = false;
        $today = date('d');
        if ($today == $convertedDate) {
            $ispaymentDate = true;
        };

        if ($today < $convertedDate) {
            $paymentnotice = " le " . $defautPaymentDate . " de ce mois";
        } else {
            $nextMonth = Carbon::now()->addMonth()->format("F");
            $paymentnotice = " le " . $defautPaymentDate . " du mois de " . $nextMonth;
        }

        $payments = payment::latest()->orderBy('id', 'desc')->paginate(10);
        return view('payment.index', compact('payments', 'ispaymentDate', 'paymentnotice'));
    }
    public function makepayment()
    {
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
        if ($employers->isEmpty()) {
            return redirect()->back()->with('error', 'Tous les employeurs ont déjà été payés pour ce mois.');
        } else {

            foreach ($employers as $employer) {
                $aetepaye = $employer->payments()->where('month', '=', $currentMonthInFrench)
                    ->where('year', '=', $currentYear)->exists();
                if (!$aetepaye) {
                    $salaire = $employer->montant_journalier * 30;
                    $payment = new payment();
                    $payment->employer_id = $employer->id;
                    $payment->month = $currentMonthInFrench;
                    $payment->year = $currentYear;
                    $payment->amount = $salaire;
                    $payment->lanch_date = Carbon::now();
                    $payment->done_time = Carbon::now();
                    $payment->status = "SUCCESS";
                    $payment->references = Str::random(10);

                    $payment->save();
                } else {
                    return redirect()->back()->with('error', 'Le paiement a déjà été effectué pour ce mois.');
                }
            }
            return redirect()->back()->with('success', 'Le paiement a été effectué avec succès pour le mois de ' . $currentMonthInFrench . ' ' . $currentYear);
        }
    }
    public function download(payment $payment)
    {

        $allinfoforpayment = payment::with('employer')->find($payment->id);
        if (!$allinfoforpayment) {
            return redirect()->back()->with('error', 'Aucun paiement trouvé.');
        } else {
            if ($allinfoforpayment->isdownloaded == 'true') {
                return redirect()->back()->with('error', 'Ce paiement a déjà été téléchargé.');
            } else {
                $pdf = \PDF::loadView('facture.download', compact('allinfoforpayment'));
            }
            $payment->isdownloaded = 'true';
            $payment->save();
            return $pdf->download('payment_' . $payment->employer->nom . '.pdf');
        }
        return view('facture.download', compact('allinfoforpayment'));
    }
}
