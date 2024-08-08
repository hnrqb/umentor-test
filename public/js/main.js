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

    