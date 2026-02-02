@extends('admin_layout')

@section('title','client')

@section('content')
 <div class="container-fluid">
        <div class="row">
          <div class="col-6">
            <!-- /.card -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Client</h3>
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
                  @foreach($clients as $client)
                  <tr>
                    <td>{{$client->code}}</td>
				    <td>{{$client->nom}}</td>
                    <td>{{$client->adresse}}</td>
				    <td>{{$client->rc}}</td>
                    <td>{{$client->ai}}</td>
				    <td>{{$client->nif}}</td>
                    <td>{{$client->payment}}</td>
					<td class="project-actions text-left">
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default{{ $client->id }}">
                         <i class="fas fa-pencil-alt" ></i>
                        </button>
                        <div class="modal fade" id="modal-default{{ $client->id }}">
					        <div class="modal-dialog">
					          <div class="modal-content">
					          	<form method="post" action="{{ route('client.update',$client->id )}}" autocomplete="off" class="form-horizontal">
                                @csrf
                                @method('PATCH')
					            <div class="modal-header " >
					              <h4 class="modal-title">Modifier Client</h4>
					              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                <span aria-hidden="true">&times;</span>
					              </button>
					            </div>
					            <div class="modal-body">
					              <div class="form-group">
									<label>Code</label>
									<input type="text" class="form-control" name="code" id="codeclient" value="{{$client->code}}">
								  </div>
								  <div class="form-group">
									<label>nom</label>
									<input type="text" class="form-control" name="nom" id="nomclient" value="{{$client->nom}}">
								  </div>
                                  <div class="form-group">
									<label>adresse</label>
									<input type="text" class="form-control" name="adresse" id="adresseclient" value="{{$client->adresse}}">
								  </div>
                                  <div class="form-group">
									<label>rc</label>
									<input type="text" class="form-control" name="rc" id="rcclient" value="{{$client->rc}}">
								  </div>
                                  <div class="form-group">
									<label>ai</label>
									<input type="text" class="form-control" name="ai" id="aiclient" value="{{$client->ai}}">
								  </div>
                                  <div class="form-group">
									<label>nif</label>
									<input type="text" class="form-control" name="nif" id="nifclient" value="{{$client->nif}}">
								  </div>
                                  <div class="form-group">
									<label>payment</label>
                                    <select name="payment"  class="form-control custom-select">
                                        <option value="">{{$client->payment}}</option>
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
                              onclick="recup('{{ $client->code }}','{{ $client->nom }}','{{ $client->adresse }}','{{ $client->rc }}','{{ $client->ai }}','{{ $client->nif }}','{{ $client->payment }}')"
                              href="#hh" title="Edit"><i class="fa fa-eye"></i></a>

                          <a class="btn btn-danger btn-sm" href="#deleteClientModal{{ $client->id }}" class="delete" data-toggle="modal">
                              <i class="fas fa-trash" data-toggle="tooltip" title="Supprimer">
                              </i></a>

                          <form action="{{ route('client.destroy',$client->id)}}" method="post">
									  @csrf
									  @method('DELETE')
                            <!-- Delete Modal HTML -->
						  <div id="deleteClientModal{{ $client->id }}" class="modal fade">
							<div class="modal-dialog">
								<div class="modal-content">
									    <div class="modal-header">			  <h4 class="modal-title">Supprimer Client</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											</div>
											<div class="modal-body">
												<p>Etes vous sur de vouloir supprimer le client</p>

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
                <h3 class="card-title">Ajouter Client</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{ route('client.store') }}" autocomplete="off" class="form-horizontal">
	            @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="CodeClient">Code</label>
                    <input type="text" class="form-control" name="code" id="CodeClient" placeholder="Entrez le code">
                  </div>
                  <div class="form-group">
                    <label for="LibelleCarb">Nom</label>
                    <input type="text" class="form-control" name="nom" id="NomClient" placeholder="Entrez le nom">
                  </div>
                  <div class="form-group">
                    <label for="AdresseClient">Adresse</label>
                    <input type="text" class="form-control" name="adresse" id="adresseclient1" placeholder="Entrez l'adresse">
                  </div>
                  <div class="form-group">
                    <label for="RcClient">Registre de commerce</label>
                    <input type="text" class="form-control" name="rc" id="RcClient" placeholder="Entrez le registre de commerce">
                  </div>
                  <div class="form-group">
                    <label for="AiClient">A I</label>
                    <input type="text" class="form-control" name="ai" id="AiClient" placeholder="Entrez le AI">
                  </div>
                  <div class="form-group">
                    <label for="NifClient">Nif</label>
                    <input type="text" class="form-control" name="nif" id="NifClient" placeholder="Entrez le NIF">
                  </div>
                  <div class="form-group">
                    <label for="PaymentClient">Méthode de payement</label>
                    <select name="payment"  class="form-control custom-select" id="paymentclient">
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

    document.getElementById("codeclient").value =code;
    document.getElementById("nomclient").value = nom;
    document.getElementById("adresseclient1").value =adresse;
    document.getElementById("rcclient").value =rc;
    document.getElementById("aiclient").value =ai;
    document.getElementById("nifclient").value =nif;
    document.getElementById("paymentclient").value =payment;

  }

  </script>

@endpush



