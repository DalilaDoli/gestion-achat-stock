@extends('admin_layout')

@section('title', 'article')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <!-- /.card -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">article</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>libelle</th>
                                    <th>qte</th>
                                    <th>pmp</th>
                                    <th>famille article</th>
                                    <th>emplacement</th>
                                    <th>Action</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($articles as $article)
                                    <tr>
                                        <td>{{ $article->code }}</td>
                                        <td>{{ $article->libelle }}</td>
                                        <td>{{ $article->qte }}</td>
                                        <td>{{ $article->pmp }}</td>
                                        <td>{{ $article->famillearticle->libelle }}</td>
                                        <td>{{ $article->emplacement->libelle }}</td>
                                        <td class="project-actions text-left">
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-default{{ $article->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <div class="modal fade" id="modal-default{{ $article->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post"
                                                            action="{{ route('article.update', $article->id) }}"
                                                            autocomplete="off" class="form-horizontal">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-header ">
                                                                <h4 class="modal-title">Modifier article</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Code</label>
                                                                    <input type="text" class="form-control"
                                                                        name="code" id="codearticle"
                                                                        value="{{ $article->code }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>libelle</label>
                                                                    <input type="text" class="form-control"
                                                                        name="libelle" id="libellearticle"
                                                                        value="{{ $article->libelle }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>qte</label>
                                                                    <input type="text" class="form-control"
                                                                        name="qte" id="qtearticle"
                                                                        value="{{ $article->qte }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>pmp</label>
                                                                    <input type="text" class="form-control"
                                                                        name="pmp" id="pmparticle"
                                                                        value="{{ $article->pmp }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>famille d'article</label>
                                                                    <select name="famillearticle_id"
                                                                        class="form-control custom-select">
                                                                        <option value="{{ $article->famillearticle_id }}">
                                                                            {{ $article->famillearticle->libelle }}</option>
                                                                        @foreach ($famillearticles as $famillearticle)
                                                                            <option value="{{ $famillearticle->id }}">
                                                                                {{ $famillearticle->libelle }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>emplacement</label>
                                                                    <select name="emplacement_id"
                                                                        class="form-control custom-select">
                                                                        <option value="{{ $article->emplacement_id }}">
                                                                            {{ $article->emplacement->libelle }}</option>
                                                                        @foreach ($emplacements as $emplacement)
                                                                            <option value="{{ $emplacement->id }}">
                                                                                {{ $emplacement->libelle }}{{ $emplacement->id }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-info"
                                                                    data-dismiss="modal">Fermer</button>
                                                                <button type="submit"
                                                                    class="btn btn-info">Enregistrer</button>
                                                            </div>
                                                    </div>
                                                    </form>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>

                                            <a class="modal-effect btn btn-sm btn-info"
                                                onclick=""
                                                href="#hh" title="Edit"><i class="fa fa-eye"></i></a>

                                            <a class="btn btn-danger btn-sm" href="#deletearticleModal{{ $article->id }}"
                                                class="delete" data-toggle="modal">
                                                <i class="fas fa-trash" data-toggle="tooltip" title="Supprimer">
                                                </i></a>

                                            <form action="{{ route('article.destroy', $article->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <!-- Delete Modal HTML -->
                                                <div id="deletearticleModal{{ $article->id }}" class="modal fade">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Supprimer article</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-hidden="true">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Etes vous sur de vouloir supprimer le article</p>

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
                <h3 class="card-title">Ajouter article</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="{{ route('article.store') }}" autocomplete="off" class="form-horizontal">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="Codearticle">Code</label>
                        <input type="text" class="form-control" name="code" id="Codearticle"
                            placeholder="Entrez le code">
                    </div>
                    <div class="form-group">
                        <label for="Libellearticle">Libelle</label>
                        <input type="text" class="form-control" name="libelle" id="Libellearticle"
                            placeholder="Entrez le libelle">
                    </div>
                    <div class="form-group">
                        <label for="qtearticle">qte</label>
                        <input type="number" class="form-control" name="qte" id="qtearticle" min="1"
                            placeholder="Entrez la qte" required>
                    </div>
                    <div class="form-group">
                        <label for="pmparticle">pmp</label>
                        <input type="text" class="form-control" name="pmp" id="pmparticle"
                            placeholder="Entrez le pmp">
                    </div>
                    <div class="form-group">
                      <label>famille d'article</label>
                      <select name="famillearticle_id" id='famillearticle'
                          class="form-control custom-select">
                          <option value="">selectionnez la famille d'article</option>
                          @foreach ($famillearticles as $famillearticle)
                              <option value="{{ $famillearticle->id }}">
                                  {{ $famillearticle->id }}  </option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group">
                      <label>emplacement</label>
                      <select name="emplacement_id" id="emplacementarticle"
                          class="form-control custom-select">
                          <option value="">selectionnez l'emplacement</option>
                          @foreach ($emplacements as $emplacement)
                              <option value="{{ $emplacement->id }}">
                                  {{ $emplacement->libelle }}</option>
                          @endforeach
                      </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Ajouter</button>
                </div>
            </form>
        </div>

        <!-- /.card -->


    </div>
    </div>
    <!-- /.row -->
    </div>
@endsection
@push('doli_script')
    <script>
        function recup(code, nomlibelle, qte, pmp, ) {

            document.getElementById("codearticle").value = code;
            document.getElementById("libellearticle").value = libelle;
            document.getElementById("qtearticle").value = qte;
            document.getElementById("pmparticle").value = pmp;
            // document.getElementById("famillearticle").value = famillearticle_id;
            // document.getElementById("emplacementarticle").value = emplacement_id;
          

        }
    </script>
@endpush
