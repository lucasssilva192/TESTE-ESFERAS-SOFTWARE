<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Atualizar Contato</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <script type="text/javascript">
        $("#telefone").mask("(00) 00000-0000");
        $("#cpf").mask("000.000.000-00");
    </script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{route('contacts.index')}}">Página inicial</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" style="font-weight: bold;" aria-current="page" href="{{route('contacts.create')}}">Novo contato</a>
                        </li>
                    </ul>
                    <form class="d-flex" action="{{route('contacts.search')}}">
                        <input class="form-control me-6" type="search" placeholder="Busque um contato..." aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <main>
        @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{session()->get('success')}}
        </div>
        @elseif(session()->has('error'))
        <div class="alert alert-danger" role="alert">
            {{session()->get('error')}}
        </div>
        @endif
        <div class="row d-flex justify-content-center">
            <div class="col-4">
                <h1>Dados do contato:</h1>
                <div class="card">
                    <a class="dropdown-item" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#modalTelefone">Adicionar telefone/email</a>
                    <div class="card-body">
                        <h5 class="card-title">Nome completo: {{$contato->nome}} {{$contato->sobrenome}}</h5>
                        <h5 class="card-title">Telefone: ({{substr($contato->phone,0,2)}}) {{substr($contato->phone,2,5)}}-{{substr($contato->phone,7,4)}} </h5>
                        <h5 class="card-title">Email: {{$contato->email}}</h5>
                        <h5 class="card-title">CPF: {{substr($contato->cpf,0,3)}}.{{substr($contato->cpf,3,3)}}.{{substr($contato->cpf,6,3)}}-{{substr($contato->cpf,9,2)}}</h5>
                    </div>
                    <div>
                        @if(isset($emails))
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Email</th>
                                    <th scope="col">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($emails as $email)
                                <tr>
                                    <th scope="row">{{$email->email}}</th>
                                    <td>
                                        <form class="d-inline" method="POST" action="{{ route('contacts.delete_email') }}">
                                            @csrf
                                            <input type="text" name="id_contato" class="d-none" value="{{$email->id}}">
                                            <button type="submit" class="dropdown-item">Apagar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @endif

                        @if(isset($phones))
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Telefone</th>
                                    <th scope="col">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($phones as $phone)
                                <tr>
                                    <th scope="row">({{substr($phone->phone,0,2)}}) {{substr($phone->phone,2,6)}}-{{substr($phone->phone,8,4)}}</th>
                                    <td>
                                        <form class="d-inline" method="POST" action="{{ route('contacts.delete_phone') }}">
                                            @csrf
                                            <input type="text" name="id_contato" class="d-none" value="{{$phone->id}}">
                                            <button type="submit" class="dropdown-item">Apagar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                    <div class="modal fade" id="modalTelefone" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Cadastrar telefone/email adicional</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="{{route('contacts.add_phone')}}">
                                    @csrf
                                    <div class="modal-body">
                                        <h5>Informe o telefone abaixo:</h5>
                                        <input type="text" class="form-control" name="telefone" id="telefone" placeholder="Ex.: (11)91234-1234">
                                        <input type="text" class="d-none" name="id" value="{{$contato->id}}">
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                        </div>
                                    </div>
                                </form>
                                <form method="post" action="{{route('contacts.add_email')}}">
                                    @csrf
                                    <div class="modal-body">
                                        <h5>Informe o email abaixo:</h5>
                                        <input type="text" class="form-control" name="email" placeholder="Ex.: joao@gmail.com">
                                        <input type="text" class="d-none" name="id" value="{{$contato->id}}">
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>