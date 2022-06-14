<?= $pageTitle;?>
<div>
    <!-- reikia paduoti teisinga route'a, priklausomai nuo to, ar tai create-add ar edit-add -->
    <form method="POST" action="<?= $actionRoute; ?>">
        <input type="text" name="title" placeholder="Title" value='<?= $ad['title'] ?? null;?>'/>
        <br/>
        <textarea name="description" placeholder="Description"><?= $ad['description'] ?? null;?></textarea>
        <br/>
        <input type="number" name="price" placeholder="Price" value='<?= $ad['price'] ?? null;?>'/>
        <br/>
        <input type="text" name="contact_phone" placeholder="Phone Number" value='<?= $ad['contact_phone'] ?? null;?>'/>
        <br/>
        <input type="submit" />
    </form>
</div>
