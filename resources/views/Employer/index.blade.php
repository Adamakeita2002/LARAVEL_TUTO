@extends('../layouts.template')
@section('content')
    <div class="app-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                <div class="row g-3 mb-4 align-items-center justify-content-between">
                    <div class="col-auto">
                        <h1 class="app-page-title mb-0">Employers</h1>
                    </div>
                    <div class="col-auto">
                        <div class="page-utilities">
                            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                                <div class="col-auto">
                                    <form class="table-search-form row gx-1 align-items-center"
                                        action="{{ route('employers.search') }}" method="GET">
                                        @csrf
                                        <div class="col-auto">
                                            <input type="text" id="search-orders" name="search"
                                                class="form-control search-orders" placeholder="Recherche" />
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn app-btn-secondary">
                                                Recherche
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!--//col-->
                                <div class="col-auto">
                                    <select class="form-select w-auto">
                                        <option selected value="option-1">
                                            All
                                        </option>
                                        <option value="option-2">
                                            This week
                                        </option>
                                        <option value="option-3">
                                            This month
                                        </option>
                                        <option value="option-4">
                                            Last 3 months
                                        </option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <a class="btn app-btn-secondary" href="{{ route('employers.create') }}">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-1"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                            <path fill-rule="evenodd"
                                                d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                        </svg>
                                        Ajouter Employers
                                    </a>
                                </div>
                            </div>
                            <!--//row-->
                        </div>
                        <!--//table-utilities-->
                    </div>
                    <!--//col-auto-->
                </div>
                <!--//row-->
                @if (Session::has('success'))
                    <p class="alert alert-info">{{ Session::get('success') }}</p>
                @endif

                <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
                    <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab"
                        href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true">Tous les
                        Employers</a>

                </nav>


                <div class="tab-content" id="orders-table-tab-content">
                    <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                        <div class="app-card app-card-orders-table shadow-sm mb-5">
                            <div class="app-card-body">
                                <div class="table-responsive">
                                    <table class="table app-table-hover mb-0 text-left">
                                        <thead>
                                            <tr>
                                                <th class="cell">#</th>
                                                <th class="cell">
                                                    Nom
                                                </th>
                                                <th class="cell">
                                                    Prenom
                                                </th>
                                                <th class="cell">Email</th>
                                                <th class="cell">Contact</th>
                                                <th class="cell">Salaire</th>
                                                <th class="cell">Departement</th>
                                                <th class="cell">image</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($employers as $employe)
                                                <tr>
                                                    <td class="cell">#{{ $employe->id }}</td>
                                                    <td class="cell">
                                                        <span class="truncate">{{ $employe->nom }}</span>
                                                    </td>
                                                    <td class="cell">
                                                        {{ $employe->prenom }}
                                                    </td>
                                                    <td class="cell">
                                                        <span>{{ $employe->email }}</span>
                                                    </td>
                                                    <td class="cell">
                                                        {{ $employe->telephone }}
                                                    </td>
                                                    <td class="cell">
                                                        {{ $employe->montant_journalier * 30 }} F CFA
                                                    </td>
                                                    <td class="cell">
                                                        {{ $employe->departement->nom }}
                                                    </td>
                                                    @if ($employe->image == null)
                                                        <td class="cell">
                                                            <img class="rounded-circle"
                                                                src="https://ui-avatars.com/api/?name={{ $employe->prenom }}+{{ $employe->nom }}"
                                                                alt="user profile" style="width: 30px; height: 30px;">
                                                        </td>
                                                    @else
                                                        <td class="cell">
                                                            <img src="{{ asset('images/' . $employe->image) }}"
                                                                alt="Image de l'employé" class="img-fluid"
                                                                style="width: 40px; height: 30px; border-radius: 50%;">
                                                        </td>
                                                    @endif
                                                    <td class="cell">
                                                        <a class="btn-sm app-btn-secondary"
                                                            href="{{ route('employers.edit', $employe->id) }}">Modifier</a>
                                                        <a class="btn-sm app-btn-secondary"
                                                            href="{{ route('employers.destroy', $employe->id) }}">Supprimer</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">Aucun employé trouvé</td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                                <!--//table-responsive-->
                            </div>
                            <!--//app-card-body-->
                        </div>
                        <!--//app-card-->
                        <nav class="app-pagination">
                            {{ $employers->links() }}
                        </nav>
                        <!--//app-pagination-->
                    </div>
                    <!--//tab-pane-->


                    <!--//tab-pane-->


                    <!--//tab-pane-->

                    <!--//tab-pane-->
                </div>
                <!--//tab-content-->
            </div>
            <!--//container-fluid-->
        </div>
        <!--//app-content-->

        <footer class="app-footer">
            <div class="container text-center py-3">
                <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
                <small class="copyright">Designed with <span class="sr-only">love</span><i class="fas fa-heart"
                        style="color: #fb866a"></i> by
                    <a class="app-link" href="http://themes.3rdwavemedia.com" target="_blank">Xiaoying Riley</a>
                    for developers</small>
            </div>
        </footer>
        <!--//app-footer-->
    </div>
@endsection
