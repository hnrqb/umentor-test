<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <title>Lista de Usuários</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="/js/main.js"></script>
    </head>
    <body>
        <div class="container-fluid mt-5">
            <h1 class="mb-4">Lista de Usuários</h1>
            <form id="search-form" class="form-inline mb-4">
                <div class="form-group mr-2">
                    <label for="search-name" class="mr-2">Nome:</label>
                    <input type="text" class="form-control" id="search-name" name="search_name">
                </div>                
                <div class="form-group mr-2">
                    <label for="search-email" class="mr-2">Email:</label>
                    <input type="text" class="form-control" id="search-email" name="search_email">
                </div>                
                <div class="form-group mr-2">
                    <label for="search-status" class="mr-2">Situação:</label>
                    <input type="text" class="form-control" id="search-status" name="search_status">
                </div>                
                <div class="form-group mr-2">
                    <label for="search-admission-date" class="mr-2">Data de Admissão:</label>
                    <input type="date" class="form-control" id="search-admission-date" name="search_admission_date">
                </div>
                <button type="submit" class="btn btn-primary mr-2">
                    <i class="fas fa-search"></i>
                </button>
                <button type="button" id="clear-filters" class="btn btn-secondary">
                    <i class="fas fa-ban"></i>
                </button>
            </form>
            <button id="add-user-button" type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#userModal">Adicionar Usuário</button>
            <table id="user-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Situação</th>
                        <th>Data de Admissão</th>
                        <th>Data e Hora (Cadastro)</th>
                        <th>Data e Hora (Atualização)</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?= View::factory('user/list')->set('users', $users); ?>
                </tbody>
            </table>
            <?= View::factory('user/create'); ?>        
            <?= View::factory('user/edit'); ?>        
        </div>
    </body>
</html>