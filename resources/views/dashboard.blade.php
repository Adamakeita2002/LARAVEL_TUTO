@extends('layouts.template')
@section('content')
    <div class="app-wrapper">

        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">

                <h1 class="app-page-title">Tableaux de board</h1>


                @if ($convertedDate == null)
                    <div class="alert alert-danger" role="alert">
                        <i class="  fa fa-exclamation-triangle"></i>
                        <strong>Configurer</strong> la date de paiement dans la section configuration de
                        l'application pour pouvoir faire le suivi des paiements.


                    </div>
                @else
                    @if (Session::has('error'))
                        <p class="alert alert-danger">{{ Session::get('error') }}</p>
                    @endif
                    <div class="alert alert-warning">
                        <i class="  fa fa-exclamation-triangle"></i>
                        <strong>Attention!</strong>
                        {{ $paymentnotice }}
                    </div>
                @endif




                <div class="row g-4 mb-4">
                    <div class="col-6 col-lg-3">

                        <a class="app-card-link-mask" href="{{ route('departement.index') }}">
                            <div class="app-card app-card-stat shadow-sm h-100">
                                <div class="app-card-body p-3 p-lg-4">
                                    <h4 class="stats-type mb-1">Total Departement</h4>
                                    <div class="stats-figure">{{ $totalDepartement }}</div>

                                </div><!--//app-card-body-->
                            </div><!--//app-card-->
                        </a>
                    </div><!--//col-->

                    <div class="col-6 col-lg-3">
                        <a class="app-card-link-mask" href="{{ route('employers.index') }}">
                            <div class="app-card app-card-stat shadow-sm h-100">
                                <div class="app-card-body p-3 p-lg-4">
                                    <h4 class="stats-type mb-1">Total Employes </h4>
                                    <div class="stats-figure">{{ $totalEmployes }}</div>

                                </div><!--//app-card-body-->



                            </div><!--//app-card-->
                        </a>

                    </div><!--//col-->
                    <div class="col-6 col-lg-3">
                        <div class="app-card app-card-stat shadow-sm h-100">
                            <div class="app-card-body p-3 p-lg-4">
                                <h4 class="stats-type mb-1">Administrateurs</h4>
                                <div class="stats-figure">{{ $totalAdmin }}</div>

                            </div><!--//app-card-body-->
                            <a class="app-card-link-mask" href="#"></a>
                        </div><!--//app-card-->
                    </div>

                    <div class="col-6 col-lg-3">
                        <div class="app-card app-card-stat shadow-sm h-100">
                            <div class="app-card-body p-3 p-lg-4">
                                <h4 class="stats-type mb-1">Employes non paye</h4>
                                <div class="stats-figure">{{ $nopayment }}</div>

                            </div><!--//app-card-body-->
                            <a class="app-card-link-mask" href="#"></a>
                        </div><!--//app-card-->
                    </div>

                    <!--//col-->
                </div><!--//row-->
                <!--//row-->
                <!--//row-->
                <!--//row-->

            </div><!--//container-fluid-->
        </div><!--//app-content-->

        <footer class="app-footer">
            <div class="container text-center py-3">
                <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
                <div class="app-credits">
                    <p class="footer-text">&copy; {{ date('Y') }}
                        {{ AppName::getAppName() ? AppName::getAppName() : 'APP NAME' }}
                        - All rights reserved.</p>
                    <p class="footer-text"><a href=""></a></p>
                </div>
        </footer><!--//app-footer-->

    </div>
@endsection
