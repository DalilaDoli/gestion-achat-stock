@extends('admin_layout')

@section('title','Famille Article')

@section('content')
 <div class="container-fluid">
        <div class="row">
          <div class="col-6">
            <!-- /.card -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Famille Article</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Code</th>
                    <th>Libelle</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($familles as $famille)
                  <tr>
                    <td>{{$famille->code}}</td>
				            <td>{{$famille->libelle}}</td>
					<td class="project-actions text-left">
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default{{ $famille->id }}">
                         <i class="fas fa-pencil-alt" ></i>
                        </button>
                        <div class="modal fade" id="modal-default{{ $famille->id }}">
					        <div class="modal-dialog">
					          <div class="modal-content">
					          	<form method="post" action="{{ route('famillearticle.update',$famille->id )}}" autocomplete="off" class="form-horizontal">
                                @csrf
                                @method('PATCH')
					            <div class="modal-header " >
					              <h4 class="modal-title">Modifier famillearticle</h4>
					              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                <span aria-hidden="true">&times;</span>
					              </button>
					            </div>
					            <div class="modal-body">
					              <div class="form-group">
									<label>Code</label>
									<input type="text" class="form-control" name="code" id="codefamille" value="{{$famille->code}}">
								  </div>
								  <div class="form-group">
									<label>Libelle</label>
									<input type="text" class="form-control" name="libelle" id="libellefamille" value="{{$famille->libelle}}">
								  </div>
					            </div>
					            <div class="modal-footer justify-content-between">
					              <button type="button" class="btn btn-info" data-dismiss="modal">Fermer</button>
					              <button type="submit" class="btn btn-info">Enregistrer</button>
					            </div>
					          </div>
					          </form>
					          <!-- /.modal-content -->
					        </div>
					        <!-- /.modal-dialog -->
					    </div>

              <a class="modal-effect btn btn-sm btn-info"
                              onclick="recup('{{ $famille->code }}','{{ $famille->libelle }}')"
                              href="#hh" title="Edit"><i class="fa fa-eye"></i></a>

                          <a class="btn btn-danger btn-sm" href="#deletefamilleModal{{ $famille->id }}" class="delete" data-toggle="modal">
                              <i class="fas fa-trash" data-toggle="tooltip" title="Supprimer">
                              </i></a>

                          <form action="{{ route('famillearticle.destroy',$famille->id)}}" method="post">
									  @csrf
									  @method('DELETE')
                            <!-- Delete Modal HTML -->
						  <div id="deletefamilleModal{{ $famille->id }}" class="modal fade">
							<div class="modal-dialog">
								<div class="modal-content">
									    <div class="modal-header">			  <h4 class="modal-title">Supprimer famille article</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											</div>
											<div class="modal-body">
												<p>Etes vous sur de vouloir supprimer cette famille d'article</p>

											</div>
											<div class="modal-footer">
												<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
												<input type="submit" class="btn btn-danger" value="Supprimer">
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
                <h3 class="card-title">Ajouter famille article</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{ route('famillearticle.store') }}" autocomplete="off" class="form-horizontal">
	            @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="Codefamille">Code</label>
                    <input type="text" class="form-control" name="code" id="Codefamille" placeholder="Entrez le code">
                  </div>
                  <div class="form-group">
                    <label for="Libellefamille">Libelle</label>
                    <input type="text" class="form-control" name="libelle" id="Libellefamille" placeholder="Entrez le libelle">
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
function recup(code,libelle) {

    document.getElementById("Codefamille").value =code;
    document.getElementById("Libellefamille").value = libelle;

  }

  </script>


    @endpush
