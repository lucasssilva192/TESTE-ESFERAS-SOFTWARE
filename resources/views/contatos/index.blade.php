<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Teste Esferas</title>
    <script>
        function remover() {
            return confirm('Você deseja realmente excluir esse contato?');
        }
    </script>
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
                            <a class="nav-link active" aria-current="page" href="{{route('contacts.create')}}">Novo contato</a>
                        </li>
                    </ul>
                    <form class="d-flex" action="{{route('contacts.search')}}" method="post">
                        @csrf
                        <input class="form-control me-6" type="search" name="busca" placeholder="Busque um contato..." aria-label="Search">
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
        @if(isset($contatos))
        <h1>Lista de contatos</h1>
        @if(isset($busca))
        <h3>Exibindo resultados para {{$busca}}</h3>
        @endif
        <div class="row d-flex justify-content-center">
            <div class="col-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Sobrenome</th>
                            <th scope="col">CPF</th>
                            <th scope="col">Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contatos as $contato)
                        <tr>
                            <td>{{$contato->nome}}</td>
                            <td>{{$contato->sobrenome}}</td>
                            <td>{{substr($contato->cpf,0,3)}}.{{substr($contato->cpf,3,3)}}.{{substr($contato->cpf,6,3)}}-{{substr($contato->cpf,9,2)}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opções
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <a class="dropdown-item" href="{{route('contacts.show', $contato->id)}}">Visualizar</a>
                                        <a class="dropdown-item" href="{{route('contacts.edit', $contato->id)}}">Editar</a>
                                        <form class="d-inline" method="POST" action="{{ route('contacts.destroy', $contato->id) }}" onsubmit="return remover();">
                                            @csrf
                                            @method('DELETE')
                                            <input type="text" name="id_contato" class="d-none" value="{{$contato->id}}">
                                            <button type="submit" class="dropdown-item">Apagar</button>
                                        </form>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <h2>Você não possui nenhum contato cadastrado</h2>
        @endif
    </main>
</body>

</html>