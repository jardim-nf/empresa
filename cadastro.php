    <!doctype html>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
    <div class ="container">
        <div class ="row">
            <div class ="col">
                <h1>Cadastro</h1>
                <form action ="cadastro_script.php" method="POST">
    <div class="form-group">
    <label for="nome" class="form-label">Nome Completo</label>
    <input type="text" class="form-control" name="nome" required >
    </div>
    <div class="form-group">
    <label for="endereco" class="form-label">Endereço</label>
    <input type="text" class="form-control" name="endereco">
    </div>
    <div class="form-group">
    <label for="nome" class="form-label">Telefone</label>
    <input type="text" class="form-control" name="telefone">
    </div>
    <div class="form-group">
    <label for="nome" class="form-label">Email</label>
    <input type="email" class="form-control" name="email">
    </div>

    <div class="form-group">
    <input type="submit" class="btn btn-success">
    </div>
    </form>
    <a href="index.php" class="btn btn-info"> Voltar ao inicio</a>
    </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    </body>
    </html>
