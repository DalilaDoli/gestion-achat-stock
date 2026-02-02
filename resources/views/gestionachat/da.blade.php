@extends('admin_layout')

@section('title', 'da')

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
                        <h3 class="card-title">Demandes d'achats</h3>
                        <a href="#" class="float-right" onclick="myfdisplay()">Ajouter une Nouvelle Demande d'achat <i class="far fa-plus-square"> </i></a>
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
                                    <th>Action</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($das as $da)
                                    <tr>
                                        <td>{{ $da->code }}</td>
                                        <td>{{ $da->date }}</td>
                                        <td hidden>
                                            @foreach ($da->dt_dmachats as $item)
                                                {{ $item->article->id }}
                                            @endforeach
                                        </td>
                                        @if ($da->statuts->sortBy('created_at')->last() == null)
                                            <td></td>
                                        @else
                                            <td>{{ $da->statuts->first()->typestatut->libelle }}</td>
                                        @endif
                                        <td>{{ $da->user->personnel->matricule }}</td>
                                        <td>{{ $da->fournisseur->nom }}</td>
                                        <td class="project-actions text-left">
                                            <button type="button" class="btn btn-success btn-sm"
                                                onclick="recupda({{ $da->id }},'{{ $da->code }}','{{ date('Y-m-d H:i', strtotime($da->date)) }}','{{ $da->fournisseur->id }}', @if ($da->statuts->sortBy('created_at')->last() == null)
                                                '{{ null }}'
                                            @else
                                                '{{ $da->statuts->first()->typestatut->libelle }}'
                                            @endif,{{ $da->dt_dmachats }})">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <a class="modal-effect btn btn-sm btn-info" href="#hh"
                                                title="Edit" onclick="consultda({{ $da->id }},'{{ $da->code }}','{{ date('Y-m-d H:i', strtotime($da->date)) }}','{{ $da->fournisseur->id }}', @if ($da->statuts->sortBy('created_at')->last() == null)
                                                '{{ null }}'
                                            @else
                                                '{{ $da->statuts->first()->typestatut->libelle }}'
                                            @endif,{{ $da->dt_dmachats }})"><i class="fa fa-eye"></i></a>
 <a class="modal-effect btn btn-sm btn-warning"  href="{{route('printda',$da->id)}}" target="_blank"> <i class="fas fa-print" data-toggle="tooltip" title="Imprimer">
</i></a></a>
                                            <a class="modal-effect btn btn-sm btn-danger"
                                            data-effect="effect-scale" data-id="{{ $da->id }}"
                                            data-toggle="modal"
                                            href="#modasupp" title="Delete">
                                                <i class="fas fa-trash" data-toggle="tooltip" title="Supprimer">
                                                </i></a>
                                               
                                            <form action="{{ route('AnnulationDa') }}" method="post">
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
                <h3 class="card-title">Ajouter une demande d'achat</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="" autocomplete="off" class="form-horizontal" id="formUp">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="Codeda">Code</label>
                        <input type="text" class="form-control" name="code" id="codeda" value="" disabled>
                        <input type="text" class="form-control" name="idda" id="idda" value="" hidden>
                        <input type="text" class="form-control" name="statutda" id="statutda" value="" hidden>
                    </div>
                    <div class="input-group col-ml-0 pl-0">

                        <div class="input-group-prepend">
                            <div class="input-group-text" id="basic-addon1">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div><input class="form-control fom-control-sm" name="date" id="dateda"
                            value="{{ date('Y-m-d H:i', strtotime(now()->toDateTimeString())) }}"
                            placeholder=" JJ/MM/AAAA" type="datetime-local">


                    </div>
                    <div class="form-group">
                        <label>Fournisseur</label>
                        <select name="fournisseur_id" id="fournisseurda" class="form-control custom-select">
                            <option value="">selectionnez le fournisseur</option>
                            @foreach ($fournisseurs as $fournisseur)
                                <option value="{{ $fournisseur->id }}">
                                    {{ $fournisseur->nom }} </option>
                            @endforeach
                        </select>
                    </div>
                    <a data-effect="effect-scale" data-toggle="modal" href="#modalarticle" style="margin-left:12px"
                        id="addarticle"><button class="btn btn-outline-light btn-block"><i
                                class="far fa-plus-square" id="showart" style="display: none;">Ajouter un article</i></button></a>
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
                            <h3 class="card-title">Détails articles</h3>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered  text-nowrap tabart" id="tabart">
                                <thead>
                                    <tr>
                                        <th>code</th>
                                        <th>Designation</th>
                                        <th>qte</th>
                                        <th>prix unitaire</th>
                                        <th>Montant HT</th>
                                        <th>Montant TTc</th>
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
                                                
                                                    <button id="ajouter-ligne" class="btn btn-primary"  onclick="ajouterLigne('{{ $article->code }}', {{ $article->id }},'{{ $article->libelle }}','{{ $article->qte }}', '{{ $article->pmp }}')"><i class="fa fa-plus"></i></button>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <th class="border-bottom-0">Code article</th>
                                    <th class="border-bottom-0">Désignation </th>
                                    <th class="border-bottom-0">Qte </th>
                                    <th class="border-bottom-0">pmp </th>
                                    <th class="border-bottom-0">qte da </th>
                                    <th class="border-bottom-0" style="display: none"></th>
                                </tfoot>
                            </table>
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
        function recupda(idda, code, date, fournisseur, statutda, tabart) {

            document.getElementById("idda").value = idda;
            document.getElementById("codeda").value = code;
            document.getElementById("statutda").value = statutda;
            document.getElementById("dateda").value = date;
            document.getElementById("fournisseurda").value = fournisseur;
            console.log(fournisseur);
            const tbodyElmnt3 = document.querySelector("#bodart");

            tbodyElmnt3.innerHTML = '';
            tabart.forEach(addToTable);

             if (document.getElementById("statutda").value.includes("En Cours"))
             {

                document.getElementById('show3').style.display = 'none';
                document.getElementById('show4').style.display = 'block';
                document.getElementById('showart').style.display = 'block';
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
                    <input class="form-control form-control-sm montant-ht" name="mntht[]" id="mntht"   value="${element['mntht']}" placeholder=""  type="text" readonly>
                    </td>
                    <td>
                    <input class="form-control form-control-sm montant-ttc" name="mntttc[]" id="mntttc"   value="${element['mntttc']}"placeholder="" type="text" readonly>
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
        function consultda(idda, code, date, fournisseur, statutda, tabart) {

            document.getElementById("idda").value = idda;
            document.getElementById("codeda").value = code;
            document.getElementById("statutda").value = statutda;
            document.getElementById("dateda").value = date;
            document.getElementById("fournisseurda").value = fournisseur;
            document.getElementById('showart').style.display = 'none';
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
                    <input class="form-control form-control-sm montant-ht" name="mntht[]" id="mntht"   value="${element['mntht']}" placeholder=""  type="text" readonly>
                    </td>
                    <td>
                    <input class="form-control form-control-sm montant-ttc" name="mntttc[]" id="mntttc"   value="${element['mntttc']}"placeholder="" type="text" readonly>
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
    

        function onDeleteRow(e) {
            if (!e.target.classList.contains("deleteBtn")) {
                return;
            }

            const btn = e.target;
            btn.closest("tr").remove();
        }
        const tbodyElmnt = document.querySelector("#bodart");
   const tableElmnt = document.querySelector("#tabart");
        tableElmnt.addEventListener("click", onDeleteRow);

        // document.getElementById("reff").value = "p1";
        function myfdisplay(sign) {
            const tbodyElmnt3 = document.querySelector("#bodart"); //important
            tbodyElmnt3.innerHTML = '';

            document.getElementById('formUp').action = "{{ route('da.store') }}";
            document.getElementById('formUp').method = "post";

            document.getElementById("codeda").value = '';
            document.getElementById("dateda").value = "{{ date('Y-m-d H:i', strtotime(now()->toDateTimeString())) }}";;
            document.getElementById("fournisseurda").value = '';
            document.getElementById('show3').style.display = 'block';
            document.getElementById('show4').style.display = 'none';
            document.getElementById('showart').style.display = 'block';

           

            }

            function triggerModif() {

                // document.getElementById('show5').style.display = 'block';
                document.getElementById('formUp').action = "{{ route('ModificationDa') }}";
                document.getElementById('formUp').method = "post";

                return true;

            }
    </script>
     <script>
        $('#modasupp').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            console.log(id);
            // var num_id = button.data('code_id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            // modal.find('.modal-body #num_id').val(num_id);
        })
        </script>
<script>
    $('#tabart').keyup(function() {
            
        $("input[name='prix_u[]']").keyup(function() {
            
            var row_params = {},
                row = $(this).closest("tr"),
                montantHT,montantTTC;

            row_params.quantite = $(row).find("input.form-control[name='qte[]']").val().replace(/,/g,
                ".");
                

            row_params.pu = $(row).find("input.form-control[name='prix_u[]']").val().replace(/,/g,
                ".");

            montantHT = row_params.quantite * row_params.pu;
            tva= (row_params.quantite * row_params.pu) * 0.19;
            montantTTC=montantHT + tva ;

            console.log(montantTTC);
            

            $(row).find("input.form-control[name='mntht[]']").val(montantHT);
            $(row).find("input.form-control[name='mntttc[]']").val(montantTTC).toFixed(2);

        });

        $("input[name='qte[]']").keyup(function() {
            var row_params = {},
                row = $(this).closest("tr"),
                montantHT,montantTTC;

            row_params.quantite = $(row).find("input.form-control[name='qte[]']").val().replace(/,/g,
                ".");
            row_params.pu = $(row).find("input.form-control[name='prix_u[]']").val().replace(/,/g,
                ".");

            montantHT = row_params.quantite * row_params.pu;
            tva= (row_params.quantite * row_params.pu) * 0.19;
            montantTTC=montantHT + tva ;

            console.log(montantTTC);

           

            $(row).find("input.form-control[name='mntht[]']").val(montantHT);
            $(row).find("input.form-control[name='mntttc[]']").val(montantTTC);

        })
    });
</script>

<script>
 
</script>

<script>
  

        function ajouterLigne (j, i, k, z, p)  {
            var modal = $('#modalarticle');
            const table = document.getElementById('tabart').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            const cell1 = newRow.insertCell(0);
            const cell2 = newRow.insertCell(1);
            const cell3 = newRow.insertCell(2);
            const cell4 = newRow.insertCell(3);
            const cell5 = newRow.insertCell(4);
            const cell6 = newRow.insertCell(5);
            const cell7 = newRow.insertCell(6);
            console.log(j);
            cell1.innerHTML = '<input class="form-control form-control-sm" id="codeart" name="code[]" value="' + j + '" type="text" readonly>';
            
            cell2.innerHTML = ' <input class="form-control form-control-sm" name="article_id[]" id="idart" value="' + i + '" type="text" readonly style="display:none;"><input class="form-control form-control-sm" name="libart[]" id="libart" value="' + k + '" type="text" readonly>';
            cell3.innerHTML = '<input class="form-control form-control-sm" name="qte[]" id="qteart" value="0" placeholder="" type="number" min="1" >';
            cell4.innerHTML = '<input class="form-control form-control-sm prix_uart" name="prix_u[]" id="prix_uart"   value="' + p +'"placeholder="" type="text" >';
            cell5.innerHTML = '<input class="form-control form-control-sm montant-ht" name="mntht[]" id="mntht"   value="" placeholder=""  type="text" readonly>';
            cell6.innerHTML = '<input class="form-control form-control-sm montant-ttc" name="mntttc[]" id="mntttc"   value=""placeholder="" type="text" readonly>';
            cell7.innerHTML = '<a class="deleteBtn modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-toggle="modal" href="#modaldemo9" title="Delete"><i class="fa fa-trash"></i></a>';
            
            $('#modalarticle').modal('hide'); };
        document.getElementById('ajouter-ligne').addEventListener('click', ajouterLigne);
</script>

       
@endpush
