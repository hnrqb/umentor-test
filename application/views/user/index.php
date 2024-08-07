<!DOCTYPE html>
<html>
<head>
    <title>Lista de Usuários</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <script>

        function loadUsers(filters = {}) {
            $.ajax({
                url: 'user/list',
                data: filters,
                success: function(data) {
                    $('#user-table tbody').html(data);
                }
            });
        }

        $(document).ready(function() {

            // Inicializa a validação do formulário de criação
            $('#create-user-form').validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    status: {
                        required: true
                    },
                    admission_date: {
                        required: true
                    }
                },
                messages: {
                    name: "Por favor, insira o nome.",
                    email: "Por favor, insira um endereço de e-mail válido.",
                    status: "Por favor, insira a situação.",
                    admission_date: "Por favor, selecione a data de admissão."
                },
                submitHandler: function(form) {

                    $.ajax({
                        url: 'user/create',
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {

                            if (response.error) {
                                Swal.fire({
                                    title: 'Erro!',
                                    text: response.error,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                loadUsers();
                                $('#userModal').modal('hide');
                                $(form)[0].reset();
                                Swal.fire({
                                    title: 'Sucesso!',
                                    text: 'Usuário adicionado com sucesso.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Erro!',
                                text: 'Ocorreu um erro ao adicionar o usuário.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });

            // Carrega os usuários ao inicializar
            loadUsers();

            // Manipula o envio do formulário de pesquisa
            $('#search-form').on('submit', function(event) {
                event.preventDefault();
                const filters = $(this).serialize();
                loadUsers(filters);
            });

            // Manipula o clique no botão "Limpar Filtro"
            $('#clear-filters').on('click', function() {
                $('#search-form')[0].reset();
                loadUsers();
            });
            
            // Manipula o clique no botão de edição
            $(document).on('click', '.edit-user', function() {

                const userId = $(this).data('id');

                $.ajax({
                    url: 'user/get',
                    type: 'GET',
                    data: { id: userId },
                    success: function(data) {

                        const user = JSON.parse(data);
                        $('#edit-user-id').val(user.id);
                        $('#edit-name').val(user.name);
                        $('#edit-email').val(user.email);
                        $('#edit-status').val(user.status);
                        $('#edit-admission-date').val(user.admission_date);
                        $('#editUserModal').modal('show');                        
                    },
                    error: function() {

                        Swal.fire({
                            title: 'Erro!',
                            text: 'Ocorreu um erro ao carregar os dados do usuário.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Inicializa a validação do formulário de edição
            $('#edit-user-form').validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    status: {
                        required: true
                    },
                    admission_date: {
                        required: true
                    }
                },
                messages: {
                    name: "Por favor, insira o nome.",
                    email: "Por favor, insira um endereço de e-mail válido.",
                    status: "Por favor, insira a situação.",
                    admission_date: "Por favor, selecione a data de admissão."
                },
                submitHandler: function(form) {
                    
                    $.ajax({
                        url: 'user/update',
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            
                            if (response.error) {
                                Swal.fire({
                                    title: 'Erro!',
                                    text: response.error,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                loadUsers();
                                $('#editUserModal').modal('hide');
                                $(form)[0].reset();
                                Swal.fire({
                                    title: 'Sucesso!',
                                    text: 'Usuário atualizado com sucesso.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Erro!',
                                text: 'Ocorreu um erro ao atualizar o usuário.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });           
        
            // Manipula o clique no botão de exclusão
            $(document).on('click', '.delete-user', function() {

                const userId = $(this).data('id');
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Você não poderá reverter isso!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, confirmar!',
                    cancelButtonText: 'Não, cancelar!'
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: 'user/delete',
                            type: 'POST',
                            data: { id: userId },
                            success: function(response) {

                                if (response.error) {
                                    Swal.fire({
                                        title: 'Erro!',
                                        text: response.error,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    loadUsers();
                                    Swal.fire({
                                        title: 'Excluído!',
                                        text: 'O usuário foi excluído.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    title: 'Erro!',
                                    text: 'Ocorreu um erro ao excluir o usuário.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
        });

    </script>
</body>
</html>