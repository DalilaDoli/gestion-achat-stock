@extends('admin_layout')

@section('title', 'Commande')

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
                        <h3 class="card-title">Liste Commandes</h3>
                        <a href="#" class="float-right" onclick="myfdisplay()">Ajouter une Nouvelle Commande <i
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
                                    <th>Dm Achat N°</th>
                                    <th>Action</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($cmds as $cmd)
                                    <tr>
                                        <td>{{ $cmd->code }}</td>
                                        <td>{{ $cmd->date }}</td>
                                        <td hidden>
                                            @foreach ($cmd->dt_commandes as $item)
                                                {{ $item->article->id }}
                                            @endforeach
                                        </td>
                                        @if ($cmd->statuts->sortBy('created_at')->last() == null)
                                            <td></td>
                                        @else
                                            <td>{{ $cmd->statuts->first()->typestatut->libelle }}</td>
                                        @endif
                                        <td>{{ $cmd->user->personnel->matricule }}</td>
                                        <td>{{ $cmd->fournisseur->nom }}</td>
                                        @if ($cmd->dmachat_id == null)
                                            <td></td>
                                        @else
                                            <td>{{ $cmd->dmachat->code }}</td>
                                        @endif

                                        <td class="project-actions text-left">
                                            <button type="button" class="btn btn-success btn-sm"
                                                onclick="recupcmd({{ $cmd->id }},'{{ $cmd->code }}','{{ date('Y-m-d H:i', strtotime($cmd->date)) }}','{{ $cmd->fournisseur->id }}', '{{ $cmd->dmachat_id }}',@if ($cmd->statuts->sortBy('created_at')->last() == null) '{{ null }}'
                                            @else
                                                '{{ $cmd->statuts->first()->typestatut->libelle }}' @endif,@if ($cmd->dmachat_id == null) '{{ null }}'
                                            @else
                                                '{{ $cmd->dmachat->code }}' @endif,{{ $cmd->dt_commandes }})">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <a class="modal-effect btn btn-sm btn-info" href="#hh" title="Edit"
                                                onclick="consultcmd({{ $cmd->id }},'{{ $cmd->code }}','{{ date('Y-m-d H:i', strtotime($cmd->date)) }}','{{ $cmd->fournisseur->id }}','{{ $cmd->dmachat_id }}', @if ($cmd->statuts->sortBy('created_at')->last() == null) '{{ null }}'
                                            @else
                                                '{{ $cmd->statuts->first()->typestatut->libelle }}' @endif,@if ($cmd->dmachat_id == null) '{{ null }}'
                                            @else
                                                '{{ $cmd->dmachat->code }}' @endif,{{ $cmd->dt_commandes }})"><i
                                                    class="fa fa-eye"></i></a>
                                            <a class="modal-effect btn btn-sm btn-warning" href="" target="_blank">
                                                <i class="fas fa-print" data-toggle="tooltip" title="Imprimer">
                                                </i></a></a>
                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $cmd->id }}" data-toggle="modal" href="#modasupp"
                                                title="Delete">
                                                <i class="fas fa-trash" data-toggle="tooltip" title="Supprimer">
                                                </i></a>

                                                <form action="{{ route('AnnulationCommande') }}" method="post">
                                                    @csrf
                                                    @method('')
                                                    <!-- Delete Modal HTML -->
                                                    <div id="modasupp" class="modal fade">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Supprimer da</h4>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-hidden="true">&times;</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Etes vous sur de vouloir supprimer le da</p>
                                                                    <input type="hidden" name="id" id="id" value="">
                                                                   
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
                <h3 class="card-title">Ajouter une Commande</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="" autocomplete="off" class="form-horizontal" id="formUp">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <a data-effect="effect-scale" data-toggle="modal" href="#modalda" style="margin-left:12px"
                            id="adda"><button class="btn btn-info btn-block"><i class="far fa-plus-square"
                                    id="showda" style="display: none;"> Choisir la demande d'achat</i></button></a>
                        <label for="Codeda">Code DA</label>
                        <input type="text" class="form-control" name="code" id="codeda" value=""
                            disabled>
                        <label for="Codeda">Code Commande</label>
                        <input type="text" class="form-control" name="code" id="codecmd" value=""
                            disabled>

                        <input type="text" class="form-control" name="idcmd" id="idcmd" value="" hidden>
                        <input type="text" class="form-control" name="idda" id="idda" value="" hidden>
                        <input type="text" class="form-control" name="statutcmd" id="statutcmd" value=""
                            hidden>
                    </div>
                    <div class="input-group col-ml-0 pl-0">

                        <div class="input-group-prepend">
                            <div class="input-group-text" id="basic-addon1">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div><input class="form-control fom-control-sm" name="date" id="datecmd"
                            value="{{ date('Y-m-d H:i', strtotime(now()->toDateTimeString())) }}"
                            placeholder=" JJ/MM/AAAA" type="datetime-local">


                    </div>
                    <div class="form-group">
                        <label>Fournisseur</label>
                        <select name="fournisseur_id" id="fournisseurcmd" class="form-control custom-select">
                            <option value="">selectionnez le fournisseur</option>
                            @foreach ($fournisseurs as $fournisseur)
                                <option value="{{ $fournisseur->id }}">
                                    {{ $fournisseur->nom }} </option>
                            @endforeach
                        </select>
                    </div>
                    <a data-effect="effect-scale" data-toggle="modal" href="#modalarticle" style="margin-left:12px"
                        id="addarticle"><button class="btn btn-outline-light btn-block"><i class="far fa-plus-square"
                                id="showart" style="display: none;">Ajouter un article</i></button></a>
                    <div class="form-group" style="display:none;">

                        <input class="form-control form-control-sm" name="code" id="codeart" value=""
                            type="text">

                        <input class="form-control form-control-sm" name="libelle" id="libart" value=""
                            type="text">

                        <input class="form-control form-control-sm" id="idart" value="" type="text">

                        <input class="form-control form-control-sm" value="" id="pmpart" type="text">
                    </div>
                    <br>

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Détails articles</h3>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered  text-nowrap" id="tabart">
                                <thead>
                                    <tr>
                                        <th>code</th>
                                        <th>Designation</th>
                                        <th>qte</th>
                                        <th>prix unitaire</th>
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
                <input class="form-control fom-control-sm" name="date1" id="dateda"
                            value="{{ date('Y-m-d H:i', strtotime(now()->toDateTimeString())) }}"
                            placeholder=" JJ/MM/AAAA" type="datetime-local">
            <div class="form-group">
                <label  style="color:white">#</label>
                <a type="button" class="form-control btn btn-primary" href="{{route('printda')}}" target="_blank"> Editer</a>
            </div>
            <button type="submit" class="btn btn-primary" target="_blank">Export</button>
        
    </form> --}}
        </div>

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
                                                <a class="modal-effect btn btn-sm btn-info" id="cls"
                                                    onclick="recupart('{{ $article->code }}', {{ $article->id }},'{{ $article->libelle }}','{{ $article->qte }}', '{{ $article->pmp }}')"
                                                    href="#" title="Ajouter"><i class="fa fa-plus"></i></a>

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
        <!-- /.modalda -->
        <div class="modal" id="modalda">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Ajouter demande d'achat</h6><button aria-label="Close" class="close"
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
                                                <th class="border-bottom-0">Demande Achat N°</th>
                                                <th class="border-bottom-0">Demande Achat date</th>
                                                <th class="border-bottom-0">Statut</th>
                                                <th class="border-bottom-0">Fournisseur</th>
                                                <th hidden>dtachat</th>
                                                <th class="border-bottom-0">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; ?>
                                            @foreach ($das as $da)
                                                <?php $i++; ?>
                                                <tr>
                                                    <td>{{ $da->code }}</td>
                                                    <td>{{ $da->date }}</td>
                                                    <td>{{ $da->libelle }}</td>
                                                    <td>{{ $da->fournisseur->nom }}</td>
                                                    <td hidden>
                                                        @foreach ($da->dt_dmachats as $item)
                                                            {{ $item->article->id }}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <a class="modal-effect btn btn-sm btn-info" id="cls"
                                                            onclick="recupda('{{ $da->id }}','{{ $da->code }}','{{ $da->fournisseur_id }}',{{ $da->dt_dmachats }})"
                                                            href="#" title="Ajouter"><i class="fa fa-plus"></i></a>
                                                            <a class="modal-effect btn btn-sm btn-danger" id="cls"
                                                            onclick="detailda({{ $da->dt_dmachats }})"
                                                            href="#" title="Ajouter"><i class="fa fa-eye"></i></a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <th class="border-bottom-0">Demande Achat N°</th>
                                            <th class="border-bottom-0">Demande Achat date</th>
                                            <th class="border-bottom-0">Statut</th>
                                            <th class="border-bottom-0">Fournisseur</th>
                                            <th class="border-bottom-0">Actions</th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-bordered  text-nowrap tabda" id="tabda">
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
                                        <tbody id="bodda"></tbody>
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
        function recupcmd(idcmd, code, date, fournisseur, idda, statutcmd, codeda, tabart) {

            document.getElementById("idda").value = idda;
            document.getElementById("idcmd").value = idcmd;
            document.getElementById("codecmd").value = code;
            document.getElementById("codeda").value = codeda;
            document.getElementById("statutcmd").value = statutcmd;
            document.getElementById("datecmd").value = date;
            document.getElementById("fournisseurcmd").value = fournisseur;
            console.log(fournisseur);
            const tbodyElmnt3 = document.querySelector("#bodart");

            tbodyElmnt3.innerHTML = '';
            tabart.forEach(addToTable);

            if (document.getElementById("statutcmd").value.includes("En Cours")) {

                document.getElementById('show3').style.display = 'none';
                document.getElementById('show4').style.display = 'block';
                document.getElementById('showart').style.display = 'block';
                document.getElementById('showda').style.display = 'block';
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
                        <input class="form-control form-control-sm" name="prix_u[]" id="prix_uart"   value="${element['prix_u']}"placeholder="" type="text">
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
        function consultcmd(idcmd, code, date, fournisseur, idda, statutcmd, codeda, tabart) {

            document.getElementById("idda").value = idda;
            document.getElementById("idcmd").value = idcmd;
            document.getElementById("codecmd").value = code;
            document.getElementById("codeda").value = codeda;
            document.getElementById("statutcmd").value = statutcmd;
            document.getElementById("datecmd").value = date;
            document.getElementById("fournisseurcmd").value = fournisseur;
            document.getElementById('showart').style.display = 'none';
            document.getElementById('showda').style.display = 'none';
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
                    <a class="deleteBtn modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
    
                                                    data-toggle="modal" href="#modaldemo9" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
    
                </td>
            </tr>
            `;
        }
    </script>
    <script>
        function recupart(j, i, k, z, p) {
            document.getElementById("codeart").value = j;
            document.getElementById("pmpart").value = p;
            document.getElementById("libart").value = k;
            document.getElementById("idart").value = i;

            onAddTable();
            $('#modalarticle').modal('hide');


        }

        const tbodyElmnt = document.querySelector("#bodart");
        const tableElmnt = document.querySelector("#tabart");

        function onAddTable() {
            // e.preventDefault();
            const codeart = document.getElementById("codeart").value;
            const libart = document.getElementById("libart").value;
            // let qteart = document.getElementById("qte").value;
            let idart = document.getElementById("idart").value;
            console.log(idart);
            let prix_uart = document.getElementById("pmpart").value;
            // document.getElementById("qte").value = z;
            console.log(prix_uart);
            console.log(tbodyElmnt.innerHTML);
            tbodyElmnt.innerHTML += `
                <tr>
                    <td >
                        <input class="form-control form-control-sm" name="code[]" value="${codeart}" type="text" readonly>
                    </td>
    
                    <td >
                        <input class="form-control form-control-sm" name="article_id[]" id="idart" value="${idart}" type="text" readonly style="display:none;">
                        <input class="form-control form-control-sm" name="libart[]" id="libart" value="${libart}" type="text" readonly>
                       
                    </td>
    
                    <td >
                        <input class="form-control form-control-sm" name="qte[]" id="qteart" value=" " placeholder="" type="number" min="1">
                    </td>
    
                    <td>
                        <input class="form-control form-control-sm" name="prix_u[]" id="prix_uart"   value="${prix_uart}"placeholder="" type="text">
                    </td>
    
                    <td>
                    <a class="deleteBtn modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
    
                                                    data-toggle="modal" href="#modaldemo9" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
    
                </td>
            </tr>
            `;
        }

        function onDeleteRow(e) {
            if (!e.target.classList.contains("deleteBtn")) {
                return;
            }

            const btn = e.target;
            btn.closest("tr").remove();
        }

        tableElmnt.addEventListener("click", onDeleteRow);

        // document.getElementById("reff").value = "p1";
        function myfdisplay(sign) {
            const tbodyElmnt3 = document.querySelector("#bodart"); //important
            tbodyElmnt3.innerHTML = '';

            document.getElementById('formUp').action = "{{ route('commande.store') }}";
            document.getElementById('formUp').method = "post";
            document.getElementById("codeda").value = '';
            document.getElementById("codecmd").value = '';
            document.getElementById("statutcmd").value = '';
            document.getElementById("datecmd").value = "{{ date('Y-m-d H:i', strtotime(now()->toDateTimeString())) }}";;
            document.getElementById("fournisseurcmd").value = '';
            document.getElementById('show3').style.display = 'block';
            document.getElementById('show4').style.display = 'none';
            document.getElementById('showart').style.display = 'block';
            document.getElementById('showda').style.display = 'block';



        }

        function triggerModif() {

            // document.getElementById('show5').style.display = 'block';
            document.getElementById('formUp').action = "{{ route('ModificationCmd') }}";
            document.getElementById('formUp').method = "post";

            return true;

        }
    </script>

    <script>
        function recupda(idda, code, fournisseur, tabartda) {

            document.getElementById("idda").value = idda;
            document.getElementById("codeda").value = code;

            document.getElementById("fournisseurcmd").value = fournisseur;

            const tbodyElmnt3 = document.querySelector("#bodart");

            tbodyElmnt3.innerHTML = '';
            tabartda.forEach(addToTableda);


            if (document.getElementById("statutcmd").value.includes("En Cours")) {
                console.log(document.getElementById("statutcmd").value);
                document.getElementById('show3').style.display = 'none';
                document.getElementById('show4').style.display = 'block';
                document.getElementById('showart').style.display = 'block';
            } else
            //  if(document.getElementById("statutcmd").value == '')
            {
                console.log(document.getElementById("statutcmd").value);
                document.getElementById('show3').style.display = 'block';
                document.getElementById('show4').style.display = 'none';
                document.getElementById('showart').style.display = 'block';
            }


        }

        function addToTableda(element) {
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
                    <a class="deleteBtn modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
    
                                                    data-toggle="modal" href="#modaldemo9" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
    
                </td>
            </tr>
            `;

            $('#modalda').modal('hide');
        }
    </script>
    <script>
        function detailda(tabartda)
        {
            const tbodyElmnt4 = document.querySelector("#bodda");

            tbodyElmnt4.innerHTML = '';
            tabartda.forEach(addToTabledetail);
        }

        function addToTabledetail(element) {
            const tbodyElmnt2 = document.querySelector("#bodda");
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
                    <input class="form-control form-control-sm montant-ht" name="mntht[]" id="mntht"   value="${element['mntht']}" placeholder=""  type="text" readonly>
                    </td>
                    <td>
                    <input class="form-control form-control-sm montant-ttc" name="mntttc[]" id="mntttc"   value="${element['mntttc']}"placeholder="" type="text" readonly>
                    </td>
    
                  
            </tr>
            `;

           
        }
    </script>
@endpush
