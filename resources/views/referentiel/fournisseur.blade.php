@extends('admin_layout')

@section('title','fournisseur')

@section('content')
 <div class="container-fluid">
        <div class="row">
          <div class="col-6">
            <!-- /.card -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">fournisseur</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Code</th>
                    <th>nom</th>
                    <th>adresse</th>
                    <th>rc</th>
                    <th>ai</th>
                    <th>nif</th>
                    <th>payment</th>
                    <th>Action</th>
                  </tr>
              
                  </thead>
                  <tbody>
                  @foreach($fournisseurs as $fournisseur)
                  <tr>
                    <td>{{$fournisseur->code}}</td>
				    <td>{{$fournisseur->nom}}</td>
                    <td>{{$fournisseur->adresse}}</td>
				    <td>{{$fournisseur->rc}}</td>
                    <td>{{$fournisseur->ai}}</td>
				    <td>{{$fournisseur->nif}}</td>
                    <td>{{$fournisseur->payment}}</td>
					<td class="project-actions text-left">
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default{{ $fournisseur->id }}">
                         <i class="fas fa-pencil-alt" ></i>
                        </button>
                        <div class="modal fade" id="modal-default{{ $fournisseur->id }}">
					        <div class="modal-dialog">
					          <div class="modal-content">
					          	<form method="post" action="{{ route('fournisseur.update',$fournisseur->id )}}" autocomplete="off" class="form-horizontal">
                                @csrf
                                @method('PATCH')
					            <div class="modal-header " >
					              <h4 class="modal-title">Modifier fournisseur</h4>
					              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                <span aria-hidden="true">&times;</span>
					              </button>
					            </div>
					            <div class="modal-body">
					              <div class="form-group">
									<label>Code</label>
									<input type="text" class="form-control" name="code" id="codefournisseur" value="{{$fournisseur->code}}">
								  </div>
								  <div class="form-group">
									<label>nom</label>
									<input type="text" class="form-control" name="nom" id="nomfournisseur" value="{{$fournisseur->nom}}">
								  </div>
                                  <div class="form-group">
									<label>adresse</label>
									<input type="text" class="form-control" name="adresse" id="adressefournisseur" value="{{$fournisseur->adresse}}">
								  </div>
                                  <div class="form-group">
									<label>rc</label>
									<input type="text" class="form-control" name="rc" id="rcfournisseur" value="{{$fournisseur->rc}}">
								  </div>
                                  <div class="form-group">
									<label>ai</label>
									<input type="text" class="form-control" name="ai" id="aifournisseur" value="{{$fournisseur->ai}}">
								  </div>
                                  <div class="form-group">
									<label>nif</label>
									<input type="text" class="form-control" name="nif" id="niffournisseur" value="{{$fournisseur->nif}}">
								  </div>
                                  <div class="form-group">
									<label>payment</label>
                                    <select name="payment"  class="form-control custom-select">
                                        <option value="">{{$fournisseur->payment}}</option>
                                            <option value="Chèque" >Chèque</option>
                                            <option value="Virement" >Virement</option>
                                            <option value="Espèce" >Espèce</option>
                                    </select>
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
                              onclick="recup('{{ $fournisseur->code }}','{{ $fournisseur->nom }}','{{ $fournisseur->adresse }}','{{ $fournisseur->rc }}','{{ $fournisseur->ai }}','{{ $fournisseur->nif }}','{{ $fournisseur->payment }}')"
                              href="#hh" title="Edit"><i class="fa fa-eye"></i></a>

                          <a class="btn btn-danger btn-sm" href="#deletefournisseurModal{{ $fournisseur->id }}" class="delete" data-toggle="modal">
                              <i class="fas fa-trash" data-toggle="tooltip" title="Supprimer">
                              </i></a>

                          <form action="{{ route('fournisseur.destroy',$fournisseur->id)}}" method="post">
									  @csrf
									  @method('DELETE')
                            <!-- Delete Modal HTML -->
						  <div id="deletefournisseurModal{{ $fournisseur->id }}" class="modal fade">
							<div class="modal-dialog">
								<div class="modal-content">
									    <div class="modal-header">			  <h4 class="modal-title">Supprimer fournisseur</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											</div>
											<div class="modal-body">
												<p>Etes vous sur de vouloir supprimer le fournisseur</p>

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
                <h3 class="card-title">Ajouter fournisseur</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{ route('fournisseur.store') }}" autocomplete="off" class="form-horizontal">
	            @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="Codefournisseur">Code</label>
                    <input type="text" class="form-control" name="code" id="Codefournisseur" placeholder="Entrez le code">
                  </div>
                  <div class="form-group">
                    <label for="LibelleCarb">Nom</label>
                    <input type="text" class="form-control" name="nom" id="Nomfournisseur" placeholder="Entrez le nom">
                  </div>
                  <div class="form-group">
                    <label for="Adressefournisseur">Adresse</label>
                    <input type="text" class="form-control" name="adresse" id="Adressefournisseur" placeholder="Entrez l'adresse">
                  </div>
                  <div class="form-group">
                    <label for="Rcfournisseur">Registre de commerce</label>
                    <input type="text" class="form-control" name="rc" id="Rcfournisseur" placeholder="Entrez le registre de commerce">
                  </div>
                  <div class="form-group">
                    <label for="Aifournisseur">A I</label>
                    <input type="text" class="form-control" name="ai" id="Aifournisseur" placeholder="Entrez le AI">
                  </div>
                  <div class="form-group">
                    <label for="Niffournisseur">Nif</label>
                    <input type="text" class="form-control" name="nif" id="Niffournisseur" placeholder="Entrez le NIF">
                  </div>
                  <div class="form-group">
                    <label for="Paymentfournisseur">Méthode de payement</label>
                    <select name="payment"  class="form-control custom-select">
                      <option value="" selected>Séléctionnez la méthode de payment</option>
                        <option value="Chèque" >Chèque</option>
                        <option value="Virement" >Virement</option>
                        <option value="Espèce" >Espèce</option>
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
function recup(code,nom,adresse,rc,ai,nif,payment) {

    document.getElementById("codefournisseur").value =code;
    document.getElementById("nomfournisseur").value = nom;
    document.getElementById("adressefournisseur").value =adresse;
    document.getElementById("rcfournisseur").value =rc;
    document.getElementById("aifournisseur").value =ai;
    document.getElementById("niffournisseur").value =nif;
    document.getElementById("paymentfournisseur").value =payment;

  }

  </script>
@endpush



