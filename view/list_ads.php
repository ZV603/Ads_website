<?php
$userRegistry = new \AdsWebsite\Service\UserRegistry();
$user = $userRegistry->getCurrentlyLoggedInUser();

$currentCustomerId = null;
if ($user !== null) {
    $currentCustomerId = $user['id'];
}
?>

<?php foreach($ads as $ad): ?>
    <div style="padding-bottom: 10px;">
        <div >
            <div style="display: flex;max-width: 200px;justify-content: space-between;align-items: center">
                <div>
                    <?php if ($ad['customer_id'] === $currentCustomerId): ?>
                        <a href="/ad/<?= $ad['id']; ?>/edit">
                            <h3><?= $ad['title'] ?? null; ?></h3>
                        </a>
                    <?php else: ?>
                        <h3><?= $ad['title'] ?? null; ?></h3>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if ($ad['customer_id'] === $currentCustomerId): ?>
                        <a href="/ad/<?= $ad['id']; ?>/delete">Delete</a>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if ($currentCustomerId !== null && $ad['customer_id'] !== $currentCustomerId): ?>
                        <a href="/ad/<?= $ad['id']; ?>/saved-ad">Save</a>
                    <?php endif; ?>
                </div>
            </div>
            <div>
                <?= $ad['description'] ?? null; ?>
            </div>
            <div>
                Price: <?= $ad['price'] ?? null; ?> eur
            </div>
            <div>
                Contact phone: <?= $ad['contact_phone'] ?? null; ?>
            </div>
            <div>
                Created At: <?= $ad['created_at'] ?? null; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
