
<form action="/users/<?= $action ; ?>/<?= (isset($user['id'])) ? Helper::showText('id', $user) : ''; ?>" method="post">
    <div class="col-5">
        <label>Name :
            <input
                type="text"
                name="name"
                value="<?= (isset($user['name'])) ? Helper::showText('name', $user) : ''; ?>"
            >
        </label>

        <?= (isset($error['name'])) ? Helper::showErrors('name', $error) : '' ; ?>

    </div>
    <div class="col-5">
        <label>Email :
            <input
                type="text"
                name="email"
                value="<?= (isset($user['email'])) ? Helper::showText('email', $user) : ''; ?>"
            >
        </label>

        <?= (isset($error['email'])) ? Helper::showErrors('email', $error) : '' ; ?>

    </div>
    <div class="col-5">
        <label for="country_id">select country:</label>
        <select name="country_id">
            <option name="country_id" value="" selected>select country</option>

            <?php foreach ($countries as $country) : ?>

                <option name="country_id" value="<?= $country['id'] ?>"
                    <?= (isset($user['country_id']) && $user['country_id'] == $country['id']) ? 'selected' : ''; ?>
                ><?= $country['country'] ?></option>

            <?php endforeach; ?>
        </select>

        <?= (isset($error['country_id'])) ? Helper::showErrors('country_id', $error) : '' ; ?>

    </div>
    <button class="btn btn-primary" type="submit">add user</button>
</form>