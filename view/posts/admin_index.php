<h2><?= $total; ?> Articles</h2>
<a type="button" href="<?= Rooter::url('admin/posts/edit') ?>" class="btn btn-primary btn-lg">Ajouter Un post</a>
<br/>
<table class="table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Titre</th>
			<th>En ligne</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($posts as $k => $v): ?>
			<tr>
				<td><?= $v->id ?></td>
				<td><?= $v->name ?></td>
				<td class="<?php echo ($v->online == 1) ? 'success' : 'danger' ?>"><?= $v->name ?></td>
				<td>
					<a href="<?= Rooter::url('admin/posts/edit/' .$v->id) ?>">Editer</a>
					<a onclick="retun confirm('Voulez vous vraiment supprimer ce post ?')" href="<?= Rooter::url('admin/posts/delete/' .$v->id) ?>">Supprimer</a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>