<?php if(!count($users)) { ?>
    <tr>
        <td colspan="8" class="text-center">
            Nenhum usuário encontrado.
        </td>
    </tr>
<?php } ?>

<?php foreach ($users as $user) { ?>
    <tr>
        <td><?= $user->id; ?></td>
        <td><?= $user->name; ?></td>
        <td><?= $user->email; ?></td>
        <td><?= $user->status; ?></td>
        <td><?= date('d/m/Y', strtotime($user->admission_date)); ?></td>
        <td><?= date('d/m/Y H:i:s', strtotime($user->created_at)); ?></td>
        <td><?= date('d/m/Y H:i:s', strtotime($user->updated_at)); ?></td>
        <td>
            <button type="button" class="btn btn-warning btn-icon btn-sm edit-user" data-id="<?= $user->id ?>" data-toggle="modal" data-target="#editUserModal">
                <i class="fas fa-pen"></i>
            </button>
            <button type="button" class="btn btn-danger btn-icon btn-sm delete-user" data-id="<?= $user->id ?>">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
<?php } ?>