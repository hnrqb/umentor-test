<!-- Modal de Edição -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-user-form">
                    <input type="hidden" id="edit-user-id" name="id">
                    <div class="form-group">
                        <label for="edit-name">Nome</label>
                        <input type="text" class="form-control" id="edit-name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="edit-email">Email</label>
                        <input type="email" class="form-control" id="edit-email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="edit-status">Situação</label>
                        <input type="text" class="form-control" id="edit-status" name="status">
                    </div>
                    <div class="form-group">
                        <label for="edit-admission-date">Data de Admissão</label>
                        <input type="date" class="form-control" id="edit-admission-date" name="admission_date">
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>
