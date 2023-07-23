<div class="row">
    <div class="col-sm me-auto">
        <h3><strong>Pengguna</strong></h3>
    </div>
    <div class="col-sm">
        <button type="button" class="btn btn-outline-primary btn-xl float-end" data-bs-toggle="modal" data-bs-target="#addWorker">
            Tambah Pengguna
        </button>
    </div>
</div>
<hr>
<div class="table-responsive">
    <table class="table table-hover myTable">
        <thead class="thead-inverse">
            <tr>
                <th>Username</th>
                <th>Nama</th>
                <th>Level</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data['users'] as $user) {
            ?>
                <tr>
                    <td data-label="Username">
                        <?= $user['username']; ?>
                    </td>
                    <td data-label="Nama">
                        <?= $user['name']; ?>
                    </td>
                    <td data-label="Level">
                        <?= $user['level_user']; ?>
                    </td>
                    <td class="Aksi" data-label="Aksi">
                        <span>

                            <?php if ($user['level_user'] != 'admin' xor $_SESSION['user']['username'] == $user['username']) { ?>
                                <a href="<?= BASEURL ?>/Setting/user/editUser/<?= $user['username']; ?>/" class="btn btn-sm btn-warning fw-bold h4" title="Edit User">
                                    <span class="" aria-hidden="true">&#x270E;</span> Edit
                                </a>&nbsp;
                            <?php } ?>
                            <?php if ($user['level_user'] != 'admin') { ?>
                                <button type="button" class="btn btn-sm btn-danger fw-bold h3" title="Hapus Data" onclick="deleteUser('<?= $user['username'] ?>')">
                                    <span aria-hidden="true">&times;</span> Hapus
                                </button>
                            <?php } ?>
                        </span>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<div class="modal fade <?= (!isset($data['editUser'])) ? '' : 'addEdit' ?>" id="addWorker" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" id="userForm" name="userForm" action="<?= BASEURL ?>/User/submit">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        <?= (!isset($data['editUser'])) ? 'Tambah Petugas' : 'Edit Petugas' ?></h5>
                    <a class="btn btn-lg close" <?= (!isset($data['editUser'])) ? 'data-bs-dismiss="modal"' : 'href="' . BASEURL . '/Setting/user"' ?> aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Username" value="">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password" <?= (!isset($data['editUser'])) ? 'required' : '' ?>>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="name" placeholder="Nama" value="">
                    </div>
                    <div class="form-group center-input">
                        <label>Level User</label>
                        <select required name="level" id="level" class="form-control">
                            <option disabled selected>Level User</option>
                            <?php
                            foreach (USERS_LEVEL as $user_level) {
                                if ($user_level[0] == 'admin') continue;
                            ?>
                                <option value="<?= $user_level[0] ?>"><?= $user_level[1] ?></option>
                            <?php
                            }


                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php
                    if (!isset($data['editUser'])) {
                    ?>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <?php
                    } else {
                    ?>
                        <a class="btn btn-danger" href="<?= BASEURL ?>Setting/user">Batal</a>
                    <?php
                    }
                    ?>
                    <input type="submit" name="userForm" value="Simpan" class="btn btn-success">
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    <?php if (isset($data['editUser'])) { ?>
        const user = <?= json_encode($data['editUser']) ?>;
        document.querySelector('input[name="username"]').value = user['username']
        document.querySelector('input[name="name"]').value = user['name']
        level = document.querySelector('select[name="level"]')
        for (var i = 0; i < level.options.length; i++) {
            if (level.options[i].value == user['level_user']) {
                level.options[i].selected = true;
                break;
            }
        }
        document.querySelector('#userForm').addEventListener('submit', function(e) {
            e.preventDefault;
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'prevUsername';
            input.value = user['username'];
            e.currentTarget.appendChild(input);
            var input2 = document.createElement('input');
            input2.type = 'hidden';
            input2.name = 'prevPassword';
            input2.value = user['password'];
            e.currentTarget.appendChild(input2);
            e.currentTarget.submit();
        });
    <?php } ?>
    const deleteUser = (username) => {
        JSAlert.confirm(`Ingin Menghapus User ${username}...?`)
            .then(function(result) {
                if (!result) return;
                window.location.replace('<?= BASEURL ?>/User/delete/username/' + username)
            });
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("#pengguna-tab").classList.add("active");
    });
</script>