<div class="content">
    <div class="container" >
        <div class="col-md-2">
            <a href="/users/create/">Add user</a>
        </div>
        <div class="row">
            <?php foreach($users as $user) : ?>
                <div class="col-md-3"><?= $user['name']; ?></div>
                <div class="col-md-3"><?= $user['email']; ?></div>
                <div class="col-md-3"><?= $user['country']; ?></div>
                <div class="col-md-1">
                    <a href="/users/update/<?= $user['id']; ?>">Update</a>
                </div>
                <div class="col-md-1">
                    <a href="/users/delete/<?= $user['id']; ?>">Delete</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>