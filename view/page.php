<?php

$userRegistry = new \AdsWebsite\Service\UserRegistry();
$user = $userRegistry->getCurrentlyLoggedInUser();

$email = null;
if ($user !== null) {
    $email = $user['email'];
}
?>
<!DOCTYPE html>
<html>
    <body style="max-width: 1200px;margin: auto;">
        <nav style="background: bisque;padding: 25px;">
            <h2 style="display: flex;justify-content: space-around;">
                <a href="/">Ad portal</a>
            </h2>
            <div style="display: flex;justify-content: space-around;">
                <?php if ($user !== null): ?>
                    <div>
                        <a href="/ad/create">Create new ad</a>
                    </div>
                <?php endif; ?>
                <div>
                    <a href="/ad/list">List ads</a>
                </div>
                <?php if ($user === null): ?>
                    <div>
                        <a href="/login">Login</a>
                    </div>
                    <div>
                        <a href="/registration">Register</a>
                    </div>
                <?php else: ?>
                    <div>
                        <a href="/logout">Logout</a>
                    </div>
                    <div>
                        <a href="/my-ads">My Ads</a>
                    </div>
                    <div>
                        <a href="/saved-ads">Saved Ads</a>
                    </div>
                    <div>
                    <?php echo $email ?>
                    </div>
                <?php endif; ?>
            </div>
        </nav>
        <div>
            <?php if (isset($innerTemplate) && file_exists($innerTemplate)): ?>
                <?php require $innerTemplate; ?>
            <?php endif; ?>
        </div>
    </body>
</html>