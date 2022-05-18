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
                <h1>Edite o contato selecionado</h1>
                <form method="POST" action="{{Route('contacts.update', $contact->id)}}">
                    <input type="text" name="id" class="d-none" value="{{$contact->id}}">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex.: João" value="{{$contact->nome}}" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="sobrenome">Sobrenome:</label>
                                <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Ex.: Santos" value="{{$contact->sobrenome}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="telefone">Telefone:</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Ex.: (11)91234-5678" value="{{$contact->phone}}" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="cpf">CPF:</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Ex.: 123.123.123-12" value="{{$contact->cpf}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ex.: joao.santos@gmail.com" value="{{$contact->email}}">
                    </div>
                    <div style="margin-top:1vh">
                        <input type="submit" class="btn btn-primary" value="Salvar"></input>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>