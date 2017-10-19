<div class="page-header">
	<h1>Blog</h1>
</div>
<?php foreach ($posts as $k => $v): ?>
	<h2><?= $v->name ?></h2>
	<p><?= $v->content ?></p>
	<?php //echo Rooter::url("posts/view/{$v->id}/$v->slug"); ?>
	<p><a href="<?php echo Rooter::url("posts/view/id:{$v->id}/slug:$v->slug"); ?>">Lire la suite &rarr;</a></p>
<?php endforeach ?>

<div class="pagination">
  <ul>
    <?php for($i = 1; $i <= $page; $i++): ?>
    	<li <?php if($i==$this->request->page) echo 'class="active"'; ?>><a href="?page=<?= $i ?>"><?= $i ?></a></li>
    <?php endfor?>
  </ul>
</div>