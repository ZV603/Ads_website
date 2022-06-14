<?php foreach($ads as $ad): ?>
    <div style="padding-bottom: 10px;">
        <div >
            <div style="display: flex;max-width: 200px;justify-content: space-between;align-items: center">
                <div>
                    <h3><?= $ad['title'] ?? null; ?></h3>
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