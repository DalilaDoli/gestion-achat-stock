@extends('admin_layout')

@section('title', 'utilisateur')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <!-- /.card -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">utilisateur</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>nom</th>
                                    <th>username</th>
                                    <th>matricule</th>
                                    <th>fonction</th>
                                    <th>Action</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($utilisateurs as $utilisateur)
                                    <tr>
                                        <td>{{ $utilisateur->name }}</td>
                                        <td>{{ $utilisateur->username }}</td>
                                        <td>{{ $utilisateur->personnel->matricule }}</td>
                                        <td>{{ $utilisateur->personnel->fonction }}</td>
                                        <td class="project-actions text-left">
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-default{{ $utilisateur->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <div class="modal fade" id="modal-default{{ $utilisateur->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post"
                                                            action="{{ route('utilisateur.update', $utilisateur->id) }}"
                                                            autocomplete="off" class="form-horizontal">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-header ">
                                                                <h4 class="modal-title">Modifier utilisateur</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="name">nom</label>
                                                                    <input id="name" type="text"
                                                                        class="form-control @error('name') is-invalid @enderror"
                                                                        name="name" value="{{ $utilisateur->name }}"
                                                                        required autocomplete="name" autofocus>

                                                                    @error('name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="username">username</label>


                                                                    <input type="text" id="username"
                                                                        placeholder="Nom complet"
                                                                        class="form-control @error('username') is-invalid @enderror"
                                                                        name="username" value="{{ $utilisateur->username }}"
                                                                        required autocomplete="username" autofocus>

                                                                    @error('username')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Personnel</label>
                                                                    <select name="personnel_id"
                                                                        class="form-control custom-select">
                                                                        <option value="{{ $utilisateur->personnel_id }}">
                                                                            {{ $utilisateur->personnel->nom }} {{ $utilisateur->personnel->prenom }}</option>
                                                                        @foreach ($personnels as $personnel)
                                                                            <option value="{{ $personnel->id }}">
                                                                                {{ $personnel->nom }} {{ $personnel->prenom }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                            
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-info"
                                                            data-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-info">Enregistrer</button>
                                                    </div>
                                                </div>
                                                </form>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                    </div>

                    <a class="modal-effect btn btn-sm btn-info" onclick="" href="#hh" title="Edit"><i
                            class="fa fa-eye"></i></a>

                    <a class="btn btn-danger btn-sm" href="#deleteutilisateurModal{{ $utilisateur->id }}" class="delete"
                        data-toggle="modal">
                        <i class="fas fa-trash" data-toggle="tooltip" title="Supprimer">
                        </i></a>

                    <form action="{{ route('utilisateur.destroy', $utilisateur->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <!-- Delete Modal HTML -->
                        <div id="deleteutilisateurModal{{ $utilisateur->id }}" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Supprimer utilisateur</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Etes vous sur de vouloir supprimer le utilisateur</p>

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
                <h3 class="card-title">Ajouter utilisateur</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="{{ route('utilisateur.store') }}" autocomplete="off" class="form-horizontal">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" placeholder="Nom complet"
                            class="form-control @error('username') is-invalid @enderror" name="username"
                            value="{{ old('username') }}" required autocomplete="username" autofocus>

                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">password</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">confirmez le password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <label>Personnel</label>
                        <select name="personnel_id" id='perssonel' class="form-control custom-select">
                            <option value="">selectionnez le nom du personnel</option>
                            @foreach ($personnels as $personnel)
                                <option value="{{ $personnel->id }}">
                                    {{ $personnel->nom }} {{ $personnel->prenom }}</option>
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
    {{-- <script>
        function recup(code, nomlibelle, qte, pmp, ) {

            document.getElementById("codeutilisateur").value = code;
            document.getElementById("libelleutilisateur").value = libelle;
            document.getElementById("qteutilisateur").value = qte;
            document.getElementById("pmputilisateur").value = pmp;
            // document.getElementById("familleutilisateur").value = familleutilisateur_id;
            // document.getElementById("emplacementutilisateur").value = emplacement_id;
          

        }
    </script> --}}
@endpush
