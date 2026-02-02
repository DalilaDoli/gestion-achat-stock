@extends('admin_layout')

@section('title', 'Reception')

@section('content')

    <div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session()->has('Add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('Add') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session()->has('delete'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('delete') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session()->has('edit'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('edit') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <!-- /.card -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Liste Reception</h3>
                        <a href="#" class="float-right" onclick="myfdisplay()">Ajouter une Nouvelle Reception <i
                                class="far fa-plus-square"> </i></a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Num</th>
                                    <th>Date</th>
                                    <th hidden>article</th>
                                    <th>Statut</th>
                                    <th>Matricule</th>
                                    <th>Fournisseur</th>
                                    <th>Commande N°</th>
                                    <th>Action</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($receptions as $reception)
                                    <tr>
                                        <td>{{ $reception->code }}</td>
                                        <td>{{ $reception->date }}</td>
                                        <td hidden>
                                            @foreach ($reception->dt_receptions as $item)
                                                {{ $item->article->id }}
                                            @endforeach
                                        </td>
                                        @if ($reception->statuts->sortBy('created_at')->last() == null)
                                            <td></td>
                                        @else
                                            <td>{{ $reception->statuts->first()->typestatut->libelle }}</td>
                                        @endif
                                        <td>{{ $reception->user->personnel->matricule }}</td>
                                        <td>{{ $reception->fournisseur->nom }}</td>
                                        <td>{{ $reception->commande->code }}</td>


                                        <td class="project-actions text-left">
                                            <button type="button" class="btn btn-success btn-sm"
                                                onclick="recupreception({{ $reception->id }},'{{ $reception->code }}','{{ date('Y-m-d H:i', strtotime($reception->date)) }}','{{ $reception->fournisseur->id }}', '{{ $reception->commande_id }}',@if ($reception->statuts->sortBy('created_at')->last() == null) '{{ null }}'
                                            @else
                                                '{{ $reception->statuts->first()->typestatut->libelle }}' @endif,
                                                '{{ $reception->commande->code }}' ,{{ $reception->dt_receptions }})">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <a class="modal-effect btn btn-sm btn-info" href="#hh" title="Edit"
                                                onclick="consultreception({{ $reception->id }},'{{ $reception->code }}','{{ date('Y-m-d H:i', strtotime($reception->date)) }}','{{ $reception->fournisseur->id }}','{{ $reception->commande_id }}', @if ($reception->statuts->sortBy('created_at')->last() == null) '{{ null }}'
                                            @else
                                                '{{ $reception->statuts->first()->typestatut->libelle }}' @endif,
                                            
                                                '{{ $reception->commande->code }}',{{ $reception->dt_receptions }})"><i
                                                    class="fa fa-eye"></i></a>
                                            <a class="modal-effect btn btn-sm btn-warning" href="" target="_blank">
                                                <i class="fas fa-print" data-toggle="tooltip" title="Imprimer">
                                                </i></a></a>
                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $reception->id }}" data-toggle="modal" href="#modasupp"
                                                title="Delete">
                                                <i class="fas fa-trash" data-toggle="tooltip" title="Supprimer">
                                                </i></a>

                                            <form action="{{ route('AnnulationReception') }}" method="post">
                                                @csrf
                                                @method('')
                                                <!-- Delete Modal HTML -->
                                                <div id="modasupp" class="modal fade modasupp">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Supprimer la Reception</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-hidden="true">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Etes vous sur de vouloir supprimer la Reception</p>
                                                                <input type="hidden" name="id" id="id"
                                                                    value="">

                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="button" class="btn btn-default"
                                                                    data-dismiss="modal" value="Annuler">
                                                                <input type="submit" class="btn btn-danger"
                                                                    value="Supprimer">
                                                            </div>
                                            </form>
                    </div>
                </div>
            </div>
            </td>
            </tr>
            @endforeach
            </tbody>

            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Ajouter une Reception</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="" autocomplete="off" class="form-horizontal" id="formUp">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <a data-effect="effect-scale" data-toggle="modal" href="#modalcmd" style="margin-left:12px"
                            id="adcmd"><button class="btn btn-info btn-block"><i class="far fa-plus-square"
                                    id="showcmd" style="display: none;"> Choisir Commande</i></button></a>
                        <label for="Codecmd">Code Commande</label>
                        <input type="text" class="form-control" name="code" id="codecmd" value=""
                            disabled>
                        <label for="Codereception">Code Réception</label>
                        <input type="text" class="form-control" name="code" id="codereception" value=""
                            disabled>

                        <input type="text" class="form-control" name="idreception" id="idreception" value=""
                            hidden>
                        <input type="text" class="form-control" name="idcmd" id="idcmd" value="" hidden>
                        <input type="text" class="form-control" name="statutreception" id="statutreception"
                            value="" hidden>
                    </div>
                    <div class="input-group col-ml-0 pl-0">

                        <div class="input-group-prepend">
                            <div class="input-group-text" id="basic-addon1">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div><input class="form-control fom-control-sm" name="date" id="datereception"
                            value="{{ date('Y-m-d H:i', strtotime(now()->toDateTimeString())) }}"
                            placeholder=" JJ/MM/AAAA" type="datetime-local">


                    </div>
                    <div class="form-group">
                        <label for="fournisseur">Fournisseur</label>
                        <input type="text" class="form-control" name="fournisseur_id" id="fournisseur_id"
                            value="" style="display:none;">
                        <input type="text" class="form-control" name="code_fournisseur" id="code_fournisseur"
                            value="">


                    </div>
                    <div class="row">
                        <div class="col-md-6"> <label for="num_bl">Num BL</label></div>
                        <div class="col-md-6"> <label for="">Date BL</label></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> <input type="text" class="form-control" name="num_bl" id="num_bl"
                                value=""></div>
                        <div class="col-md-6"><input class="form-control fom-control-sm" name="date_bl" id="date_bl"
                                value="" placeholder=" JJ/MM/AAAA" type="datetime-local"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6"> <label for="num_fac">Num Facture</label></div>
                        <div class="col-md-6"> <label for="">Date Facture</label></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"> <input type="text" class="form-control" name="num_fac" id="num_fac"
                                value=""></div>
                        <div class="col-md-6"><input class="form-control fom-control-sm" name="date_fac" id="date_fac"
                                value="" placeholder=" JJ/MM/AAAA" type="datetime-local"></div>
                    </div>
                   
                    <div class="form-group">
                        <label>Emplacement</label>
                        <select name="emplacement_id" id="emplacement_id" class="form-control custom-select" required>
                            <option value="">selectionnez l'emplacement</option>
                            @foreach ($emplacements as $emplacement)
                                <option value="{{ $emplacement->id }}">
                                    {{ $emplacement->libelle }} </option>
                            @endforeach
                        </select>
                    </div>

              
               

                
                <div class="form-group" style="display:none;">

                    <input class="form-control form-control-sm" name="code" id="codeart" value=""
                        type="text">

                    <input class="form-control form-control-sm" name="libelle" id="libart" value=""
                        type="text">

                    <input class="form-control form-control-sm" id="idart" value="" type="text">

                    <input class="form-control form-control-sm" value="" id="pmpart" type="text">
                </div>
                <br>
                <button id="ajouter-ligne" class="btn btn-primary" hidden>Ajouter une ligne</button>

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Détails Reception</h3>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered  text-nowrap" id="tabart">
                            <thead>
                                <tr>
                                    <th>code</th>
                                    <th>Designation</th>
                                    <th>qte</th>
                                    <th>prix unitaire</th>
                                    <th>prix HT</th>
                                    <th>prix TTC</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="bodart"></tbody>
                        </table>

                    </div>

                </div>

        </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-info" id="show3" style="display: none">Ajouter</button>
        <div class="row">

            <div class="col">

                <div class="col"> <button type="submit" class="btn btn-success" id="show4"
                        style="display: none" onclick="return triggerModif()">Sauvegarder les
                        modifications</button>
                </div>
            </div>
        </div>
        </form>
        {{-- <form id="formExport" class="form-horizontal" role="form" method="get" action="{{route('printda')}}">
                {{ csrf_field() }}
                <input class="form-control fom-control-sm" name="date1" id="datecmd"
                            value="{{ date('Y-m-d H:i', strtotime(now()->toDateTimeString())) }}"
                            placeholder=" JJ/MM/AAAA" type="datetime-local">
            <div class="form-group">
                <label  style="color:white">#</label>
                <a type="button" class="form-control btn btn-primary" href="{{route('printda')}}" target="_blank"> Editer</a>
            </div>
            <button type="submit" class="btn btn-primary" target="_blank">Export</button>
        
    </form> --}}
    </div>
    <style>
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
    <!-- /.card -->
    <div class="modal" id="modalarticle">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Ajouter un article</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table id="example8" style="text-align: center"
                            class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">

                            <thead>
                                <tr>

                                    <th class="border-bottom-0">Code article</th>
                                    <th class="border-bottom-0">Désignation </th>
                                    <th class="border-bottom-0">Qte </th>
                                    <th class="border-bottom-0">pmp </th>
                                    <th class="border-bottom-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($articles as $article)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $article->code }}</td>
                                        <td>{{ $article->libelle }}</td>
                                        <td>{{ number_format($article->qte, 2) }}</td>
                                        <td>{{ $article->pmp }}</td>
                                        <td>

                                            <button id="ajouter-ligne" class="btn btn-primary"
                                                onclick="ajouterLigne('{{ $article->code }}', {{ $article->id }},'{{ $article->libelle }}','{{ $article->qte }}', '{{ $article->pmp }}')"><i
                                                    class="fa fa-plus"></i></button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <th class="border-bottom-0">Code article</th>
                                <th class="border-bottom-0">Désignation </th>
                                <th class="border-bottom-0">Qte </th>
                                <th class="border-bottom-0">pmp </th>
                                <th class="border-bottom-0" style="display: none"></th>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- /.modalcmd -->
    <style>
        .modal-custom {
            width: 1200px;
        }
    </style>
    <div class="modal" id="modalcmd">
        <div class="modal-dialog modal-xl" role="document" style="max-width:1500px;">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Ajouter une commande</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-6">
                            <div class="table-responsive">
                                <table id="example2" style="text-align: center"
                                    class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">

                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">Commande N°</th>
                                            <th class="border-bottom-0">Comande date</th>
                                            <th class="border-bottom-0">Statut</th>
                                            <th class="border-bottom-0">Fournisseur</th>
                                            <th hidden>dtcommande</th>
                                            <th class="border-bottom-0">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        @foreach ($cmds as $cmd)
                                            <?php $i++; ?>
                                            <tr>
                                                <td>{{ $cmd->code }}</td>
                                                <td>{{ $cmd->date }}</td>
                                                <td>{{ $cmd->libelle }}</td>
                                                <td>{{ $cmd->fournisseur->nom }}</td>
                                                <td hidden>
                                                    @foreach ($cmd->dt_commandes as $item)
                                                        {{ $item->article->id }}
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <a class="modal-effect btn btn-sm btn-info" id="cls"
                                                        onclick="recupcmd('{{ $cmd->id }}','{{ $cmd->code }}','{{ $cmd->fournisseur_id }}','{{ $cmd->fournisseur->nom }}',{{ $cmd->dt_commandes }})"
                                                        href="#" title="Ajouter"><i class="fa fa-plus"></i></a>
                                                    <a class="modal-effect btn btn-sm btn-danger" id="cls"
                                                        onclick="detailcmd({{ $cmd->dt_commandes }})" href="#"
                                                        title="Ajouter"><i class="fa fa-eye"></i></a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <th class="border-bottom-0">Commande N°</th>
                                        <th class="border-bottom-0">Comande date</th>
                                        <th class="border-bottom-0">Statut</th>
                                        <th class="border-bottom-0">Fournisseur</th>
                                        <th hidden>dtcommande</th>
                                        <th class="border-bottom-0">Actions</th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-bordered  text-nowrap tabda" id="tabcmd">
                                    <thead>
                                        <tr>
                                            <th>code</th>
                                            <th>Designation</th>
                                            <th>qte</th>
                                            <th>prix unitaire</th>
                                            <th>Montant HT</th>
                                            <th>Montant TTc</th>

                                        </tr>
                                    </thead>
                                    <tbody id="bodcmd"></tbody>
                                </table>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
    </div>
    <!-- /.row -->
    </div>
@endsection
@push('doli_script')
    <script>
        $('.modasupp').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget)
            console.log('hello');
            var id = button.data('id')
            console.log(id);

            var modal = $(this)
            modal.find('.modal-body #id').val(id);

        })
    </script>
    <script>
        function recupreception(idreception, code, date, fournisseur, idcmd, statutreception, codecmd, tabart) {

            document.getElementById("idcmd").value = idcmd;
            document.getElementById("idreception").value = idreception;
            document.getElementById("codereception").value = code;
            document.getElementById("codecmd").value = codecmd;
            document.getElementById("statutreception").value = statutreception;
            document.getElementById("datereception").value = date;
            document.getElementById("fournisseur_id").value = fournisseur;
            console.log(fournisseur);
            const tbodyElmnt3 = document.querySelector("#bodart");

            tbodyElmnt3.innerHTML = '';
            tabart.forEach(addToTable);

            if (document.getElementById("statutreception").value.includes("En Cours")) {

                document.getElementById('show3').style.display = 'none';
                document.getElementById('show4').style.display = 'block';
                document.getElementById('showart').style.display = 'block';
                document.getElementById('showcmd').style.display = 'block';
            }

        }

        function addToTable(element) {
            const tbodyElmnt2 = document.querySelector("#bodart");
            tbodyElmnt2.innerHTML += `
                <tr>
                    <td >
                        <input class="form-control form-control-sm" name="code[]" value="${element["article"]['code']}" type="text" readonly>
                    </td>
    
                    <td >
                        <input class="form-control form-control-sm" name="article_id[]" id="idart" value="${element['article_id']}" type="text" readonly style="display:none;">
                        <input class="form-control form-control-sm" name="libart[]" id="libart" value="${element["article"]['libelle']}" type="text" readonly>
                       
                    </td>
    
                    <td >
                        <input class="form-control form-control-sm" name="qte[]" id="qteart" value="${element['qte']}" placeholder="" type="number" min="1">
                    </td>
    
                    <td>
                        <input class="form-control form-control-sm" name="prix_uc[]" id="prix_uart"   value="${element['prix_u']}"placeholder="" type="text">
                    </td>

                    <td>
                        <input class="form-control form-control-sm" name="mntht[]" id="mntht"   value="${element['mntht']}"placeholder="" type="text">
                    </td>

                    <td>
                        <input class="form-control form-control-sm" name="mntttc[]" id="mntttc"   value="${element['mntttc']}"placeholder="" type="text">
                    </td>
    
                    <td>
                    <a class="deleteBtn modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
    
                                                    data-toggle="modal" href="#modaldemo9" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
    
                </td>
            </tr>
            `;
        }
    </script>
    <script>
        function consultreception(idreception, code, date, fournisseur, idcmd, statutreception, codecmd, tabart) {

            document.getElementById("idcmd").value = idcmd;
            document.getElementById("idreception").value = idreception;
            document.getElementById("codereception").value = code;
            document.getElementById("codecmd").value = codeda;
            document.getElementById("statutreception").value = statutreception;
            document.getElementById("datereception").value = date;
            document.getElementById("fournisseurre_id").value = fournisseur;
            document.getElementById('showart').style.display = 'none';
            document.getElementById('showcmd').style.display = 'none';
            document.getElementById('show3').style.display = 'none';
            document.getElementById('show4').style.display = 'none';
            console.log(fournisseur);
            const tbodyElmnt3 = document.querySelector("#bodart");

            tbodyElmnt3.innerHTML = '';
            tabart.forEach(addToTable);



        }

        function addToTable(element) {
            const tbodyElmnt2 = document.querySelector("#bodart");

            tbodyElmnt2.innerHTML += `
                <tr>
                    <td >
                        <input class="form-control form-control-sm" name="code[]" value="${element["article"]['code']}" type="text" readonly>
                    </td>
    
                    <td >
                        <input class="form-control form-control-sm" name="article_id[]" id="idart" value="${element['article_id']}" type="text" readonly style="display:none;">
                        <input class="form-control form-control-sm" name="libart[]" id="libart" value="${element["article"]['libelle']}" type="text" readonly>
                       
                    </td>
    
                    <td >
                        <input class="form-control form-control-sm" name="qte[]" id="qteart" value="${element['qte']}" placeholder="" type="number" min="1">
                      
                    </td>
    
                    <td>
                        <input class="form-control form-control-sm" name="prix_u[]" id="prix_uart"   value="${element['prix_u']}"placeholder="" type="text">
                        
                    </td>

                    <td>
                        <input class="form-control form-control-sm" name="mntht[]" id="mntht"   value="${element['mntht']}"placeholder="" type="text">
                    </td>

                    <td>
                        <input class="form-control form-control-sm" name="mntttc[]" id="mntttc"   value="${element['mntttc']}"placeholder="" type="text">
                    </td>
    
                    <td>
                    <a class="deleteBtn modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
    
                                                    data-toggle="modal" href="#modaldemo9" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
    
                </td>
            </tr>
            `;
        }
    </script>
    <script>
        // document.getElementById("reff").value = "p1";
        function myfdisplay(sign) {
            const tbodyElmnt3 = document.querySelector("#bodart"); //important
            tbodyElmnt3.innerHTML = '';

            document.getElementById('formUp').action = "{{ route('reception.store') }}";
            document.getElementById('formUp').method = "post";
            document.getElementById("codecmd").value = '';
            document.getElementById("codereception").value = '';
            document.getElementById("statutreception").value = '';
            document.getElementById("datereception").value =
                "{{ date('Y-m-d H:i', strtotime(now()->toDateTimeString())) }}";;
            document.getElementById("fournisseur_id").value = '';
            document.getElementById("num_bl").value = '';
            document.getElementById("date_bl").value = '';
            document.getElementById("num_fac").value = '';
            document.getElementById("date_fac").value = '';
            document.getElementById('show3').style.display = 'block';
            document.getElementById('show4').style.display = 'none';
            // document.getElementById('showart').style.display = 'block';
            document.getElementById('showcmd').style.display = 'block';



        }

        function triggerModif() {

            // document.getElementById('show5').style.display = 'block';
            document.getElementById('formUp').action = "{{ route('ModificationReception') }}";
            document.getElementById('formUp').method = "post";

            return true;

        }
    </script>

    <script>
        function recupcmd(idcmd, code, fournisseur,codefour, tabartcmd) {

            document.getElementById("idcmd").value = idcmd;
            document.getElementById("codecmd").value = code;

            document.getElementById("fournisseur_id").value = fournisseur;
            document.getElementById("code_fournisseur").value = codefour;

            const tbodyElmnt3 = document.querySelector("#bodart");

            tbodyElmnt3.innerHTML = '';
            tabartcmd.forEach(addToTablecmd);


            if (document.getElementById("statutreception").value.includes("En Cours")) {
                console.log(document.getElementById("statutreception").value);
                document.getElementById('show3').style.display = 'none';
                document.getElementById('show4').style.display = 'block';
                document.getElementById('showart').style.display = 'block';
            } else
            //  if(document.getElementById("statutreception").value == '')
            {
                console.log(document.getElementById("statutreception").value);
                document.getElementById('show3').style.display = 'block';
                document.getElementById('show4').style.display = 'none';
                document.getElementById('showart').style.display = 'block';
            }


        }

        function addToTablecmd(element) {
            const tbodyElmnt2 = document.querySelector("#bodart");
            tbodyElmnt2.innerHTML += `
                <tr>
                    <td >
                        <input class="form-control form-control-sm" name="code[]" value="${element["article"]['code']}" type="text" readonly>
                    </td>
    
                    <td >
                        <input class="form-control form-control-sm" name="article_id[]" id="idart" value="${element['article_id']}" type="text" readonly style="display:none;">
                        <input class="form-control form-control-sm" name="libart[]" id="libart" value="${element["article"]['libelle']}" type="text" readonly>
                       
                    </td>
    
                    <td >
                        <input class="form-control form-control-sm" name="qte[]" id="qteart" value="${element['qte']}" placeholder="" type="number" min="1">
                        <input class="form-control form-control-sm" name="qteart[]" id="" value="${element["article"]['qte']}" placeholder=""  style="display:none;">
                    </td>
    
                    <td>
                        <input class="form-control form-control-sm" name="prix_ucmd[]" id="prix_uart"   value="${element['prix_u']}"placeholder="" type="text">
                        <input class="form-control form-control-sm" name="prix_uart[]" id="prix_uart"   value="${element["article"]['pmp']}"placeholder="" type="text" style="display:none;">
                    </td>

                    <td>
                        <input class="form-control form-control-sm" name="mntht[]" id="mntht"   value="${element['mntht']}"placeholder="" type="text">
                    </td>

                    <td>
                        <input class="form-control form-control-sm" name="mntttc[]" id="mntttc"   value="${element['mntttc']}"placeholder="" type="text">
                    </td>
    
                    <td>
                    <a class="deleteBtn modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
    
                                                    data-toggle="modal" href="#modaldemo9" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
    
                </td>
            </tr>
            `;

            $('#modalcmd').modal('hide');
        }
    </script>
    <script>
        $('#tabart').keyup(function() {

            $("input[name='prix_u[]']").keyup(function() {

                var row_params = {},
                    row = $(this).closest("tr"),
                    montantHT, montantTTC;

                row_params.quantite = $(row).find("input.form-control[name='qte[]']").val().replace(/,/g,
                    ".");


                row_params.pu = $(row).find("input.form-control[name='prix_u[]']").val().replace(/,/g,
                    ".");

                montantHT = row_params.quantite * row_params.pu;
                tva = (row_params.quantite * row_params.pu) * 0.19;
                montantTTC = montantHT + tva;

                console.log(montantTTC);


                $(row).find("input.form-control[name='mntht[]']").val(montantHT);
                $(row).find("input.form-control[name='mntttc[]']").val(montantTTC).toFixed(2);

            });

            $("input[name='qte[]']").keyup(function() {
                var row_params = {},
                    row = $(this).closest("tr"),
                    montantHT, montantTTC;

                row_params.quantite = $(row).find("input.form-control[name='qte[]']").val().replace(/,/g,
                    ".");
                row_params.pu = $(row).find("input.form-control[name='prix_u[]']").val().replace(/,/g,
                    ".");

                montantHT = row_params.quantite * row_params.pu;
                tva = (row_params.quantite * row_params.pu) * 0.19;
                montantTTC = montantHT + tva;

                console.log(montantTTC);



                $(row).find("input.form-control[name='mntht[]']").val(montantHT);
                $(row).find("input.form-control[name='mntttc[]']").val(montantTTC);

            })
        });
    </script>
    
    <script>
        function detailcmd(tabartcmd) {
            const tbodyElmnt4 = document.querySelector("#bodcmd");

            tbodyElmnt4.innerHTML = '';
            tabartcmd.forEach(addToTabledetail);
        }

        function addToTabledetail(element) {
            const tbodyElmnt2 = document.querySelector("#bodcmd");
            tbodyElmnt2.innerHTML += `
                <tr>
                    <td >
                        <input class="form-control form-control-sm" name="code[]" value="${element["article"]['code']}" type="text" readonly>
                    </td>
    
                    <td >
                        <input class="form-control form-control-sm" name="article_id[]" id="idart" value="${element['article_id']}" type="text" readonly style="display:none;">
                        <input class="form-control form-control-sm" name="libart[]" id="libart" value="${element["article"]['libelle']}" type="text" readonly>
                       
                    </td>
    
                    <td >
                        <input class="form-control form-control-sm" name="qte[]" id="qteart" value="${element['qte']}" placeholder="" type="number" min="1">
                    </td>
    
                    <td>
                        <input class="form-control form-control-sm" name="" id="prix_uart"   value="${element['prix_u']}"placeholder="" type="text">
                    </td>
                    <td>
                    <input class="form-control form-control-sm montant-ht" name="mntht[]" id="mntht"   value="${element['mntht']}" placeholder=""  type="text" readonly>
                    </td>
                    <td>
                    <input class="form-control form-control-sm montant-ttc" name="mntttc[]" id="mntttc"   value="${element['mntttc']}"placeholder="" type="text" readonly>
                    </td>
    
                  
            </tr>
            `;


        }
    </script>
    <script>
        function clearModalInputs(modalId) {
            const modal = document.getElementById(modalId);
            const inputs = modal.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.value = '';
            });
        }

        // Utilisation de la fonction pour vider les champs de formulaire d'un modal avec l'ID "mon-modal" lorsque celui-ci est fermé
        $('#modalcmd').on('hidden.bs.modal', function() {
            clearModalInputs('modalcmd');
        });
    </script>
@endpush
