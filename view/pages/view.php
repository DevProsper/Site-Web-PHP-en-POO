<?php $title_for_layout = $page->name; ?>
<h1>Bienvenue su la page d'accueil</h1>
<?php
echo $page->name;
echo $page->content;
?>

<h3><?= debug($page); ?></h3>