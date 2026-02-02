@extends('admin_layout')

@section('title','personnel')

@section('content')
 <div class="container-fluid">
        <div class="row">
          <div class="col-6">
            <!-- /.card -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">personnel</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Matricule</th>
                    <th>nom</th>
                    <th>Prénom</th>
                    <th>Fonction</th>
                    <th>Action</th>
                  </tr>
              
                  </thead>
                  <tbody>
                  @foreach($personnels as $personnel)
                  <tr>
                    <td>{{$personnel->matricule}}</td>
                    <td>{{$personnel->nom}}</td>
                    <td>{{$personnel->prenom}}</td>
                    <td>{{$personnel->fonction}}</td>
					<td class="project-actions text-left">
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default{{ $personnel->id }}">
                         <i class="fas fa-pencil-alt" ></i>
                        </button>
                        <div class="modal fade" id="modal-default{{ $personnel->id }}">
					        <div class="modal-dialog">
					          <div class="modal-content">
					          	<form method="post" action="{{ route('personnel.update',$personnel->id )}}" autocomplete="off" class="form-horizontal">
                                @csrf
                                @method('PATCH')
					            <div class="modal-header " >
					              <h4 class="modal-title">Modifier personnel</h4>
					              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                <span aria-hidden="true">&times;</span>
					              </button>
					            </div>
					            <div class="modal-body">
					              <div class="form-group">
									<label>Matricule</label>
									<input type="text" class="form-control" name="matricule" id="matriculepersonnel" value="{{$personnel->matricule}}">
								  </div>
								  <div class="form-group">
									<label>nom</label>
									<input type="text" class="form-control" name="nom" id="nompersonnel" value="{{$personnel->nom}}">
								  </div>
                                  <div class="form-group">
									<label>Prénom</label>
									<input type="text" class="form-control" name="prenom" id="prenompersonnel" value="{{$personnel->prenom}}">
								  </div>
                                  <div class="form-group">
									<label>Fonction</label>
									<input type="text" class="form-control" name="fonction" id="fonctionpersonnel" value="{{$personnel->fonction}}">
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
                              onclick="recup('{{ $personnel->matricule }}','{{ $personnel->nom }}','{{ $personnel->prenom }}','{{ $personnel->fonction }}')"
                              href="#hh" title="Edit"><i class="fa fa-eye"></i></a>

                          <a class="btn btn-danger btn-sm" href="#deletepersonnelModal{{ $personnel->id }}" class="delete" data-toggle="modal">
                              <i class="fas fa-trash" data-toggle="tooltip" title="Supprimer">
                              </i></a>

                          <form action="{{ route('personnel.destroy',$personnel->id)}}" method="post">
									  @csrf
									  @method('DELETE')
                            <!-- Delete Modal HTML -->
						  <div id="deletepersonnelModal{{ $personnel->id }}" class="modal fade">
							<div class="modal-dialog">
								<div class="modal-content">
									    <div class="modal-header">			  <h4 class="modal-title">Supprimer personnel</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											</div>
											<div class="modal-body">
												<p>Etes vous sur de vouloir supprimer le personnel</p>

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
                <h3 class="card-title">Ajouter personnel</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{ route('personnel.store') }}" autocomplete="off" class="form-horizontal">
	            @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="Matriculepersonnel">Matricule</label>
                    <input type="text" class="form-control" name="matricule" id="Matriculepersonnel" placeholder="Entrez le matricule">
                  </div>
                  <div class="form-group">
                    <label for="Nompersonnel">Nom</label>
                    <input type="text" class="form-control" name="nom" id="Nompersonnel" placeholder="Entrez le nom">
                  </div>
                  <div class="form-group">
                    <label for="Prenompersonnel">Prénom</label>
                    <input type="text" class="form-control" name="prenom" id="Prenompersonnel" placeholder="Entrez le prénom">
                  </div>
                  <div class="form-group">
                    <label for="fonctionpersonnel">fonction</label>
                    <input type="text" class="form-control" name="fonction" id="fonctionpersonnel" placeholder="Entrez la fonction">
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
function recup(matricule,nom,prenom,fonction) {

    document.getElementById("matriculepersonnel").value =matricule;
    document.getElementById("nompersonnel").value = nom;
    document.getElementById("prenompersonnel").value =prenom;
    document.getElementById("fonctionpersonnel").value =fonction;

  }

  </script>
@endpush



