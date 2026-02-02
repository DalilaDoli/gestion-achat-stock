@extends('admin_layout')

@section('title', 'commande')

@section('content')
    <style>
        .space {
            width: 10px;
            height: auto;
            display: inline-block;
        }

        .space1 {
            width: 280px;
            height: auto;
            display: inline-block;
        }
    </style>
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
                        <h3 class="card-title">Liste commande</h3>
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
                                            <td>{{ $cmd->statuts->last()->typestatut->libelle }}</td>
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
                                                onclick="recupcmd({{ $cmd->id }},'{{ $cmd->code }}','{{ date('Y-m-d H:i', strtotime($cmd->date)) }}','{{ $cmd->fournisseur->nom }}', @if ($cmd->dmachat_id == null) '{{ null }}'
                                                @else
                                                    {{ $cmd->dmachat_id }} @endif,@if ($cmd->statuts->sortBy('created_at')->last() == null) '{{ null }}'
                                            @else
                                                '{{ $cmd->statuts->last()->typestatut->libelle }}' @endif,@if ($cmd->dmachat_id == null) '{{ null }}'
                                            @else
                                                '{{ $cmd->dmachat->code }}' @endif,{{ $cmd->dt_commandes }})">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
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
                        <h3 class="card-title">Valider une commande</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="post" action="" autocomplete="off" class="form-horizontal" id="formUp">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="Codeda">Code Da</label>
                                <input type="text" class="form-control" name="code" id="codeda" value=""
                                    disabled>
                                    <label for="Codecmd">Code</label>
                                <input type="text" class="form-control" name="code" id="codecmd" value=""
                                    disabled>
                                <input type="text" class="form-control" name="idcmd" id="idcmd" value=""
                                   hidden >
                                    <input type="text" class="form-control" name="idda" id="idda" value=""
                                    hidden>
                                <input type="text" class="form-control" name="statutda" id="statutcmd" value=""
                                   hidden >
                            </div>
                            <div class="input-group col-ml-0 pl-0">

                                <div class="input-group-prepend">
                                    <div class="input-group-text" id="basic-addon1">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div><input class="form-control fom-control-sm" name="date" id="datecmd"
                                    value="" placeholder=" JJ/MM/AAAA" type="text" readonly>


                            </div>
                            <div class="form-group">
                                <label>Fournisseur</label>
                                <input class="form-control form-control-sm" name="fournisseur_id" id="fournisseurcmd"
                                    value="" type="text" readonly>
                            </div>

                            <div class="form-group" style="display:none;">

                                <input class="form-control form-control-sm" name="code" id="codeart" value=""
                                    type="text">

                                <input class="form-control form-control-sm" name="libelle" id="libart" value=""
                                    type="text">

                                <input class="form-control form-control-sm" id="idart" value="" type="text">

                                <input class="form-control form-control-sm" value="" id="pmpart" type="text">
                                <input class="form-control form-control-sm" name="valide_cmd" value=""
                                    id="valide_cmd" type="text">
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
                        <div class="space1">
                        </div>
                        <button type="submit" class="btn btn-success" id="show4" style="display: none"
                            onclick="return triggerModif1('Valide')">Valider </button>

                        <div class="space">
                        </div>
                        <button type="submit" class="btn btn-danger" name="reject_da" id="show5"
                            style="display: none" onclick="return triggerModif2('Reject')">Rejeter</button>


                    </div>
                    </form>
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
            </div>
            <!-- /.row -->
        </div>
    @endsection
    @push('doli_script')
        <script>
              function recupcmd(idcmd, code, date, fournisseur,idda, statutcmd,codeda, tabart) {

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
document.getElementById('show5').style.display = 'block';
} else {
document.getElementById('show4').style.display = 'none';
document.getElementById('show5').style.display = 'none';
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
            // document.getElementById("reff").value = "p1";

            function triggerModif1(V) {

                // document.getElementById('show5').style.display = 'block';
                document.getElementById("valide_cmd").value = V;
                document.getElementById('formUp').action = "{{ route('ValidationCmd') }}";
                document.getElementById('formUp').method = "post";

                return true;

            }

            function triggerModif2(R) {

                // document.getElementById('show5').style.display = 'block';
                document.getElementById("valide_cmd").value = R;
                document.getElementById('formUp').action = "{{ route('ValidationCmd') }}";
                document.getElementById('formUp').method = "post";

                return true;

            }
        </script>
    @endpush
