<h2>Editer un article</h2>
<form action="<?php echo Rooter::url('admin/posts/edit/'.$id); ?>" method="post">
	<?= $this->Form->input('name', 'Votre nom', array('class'	=> 'form-control')); ?>
	<?= $this->Form->input('slug', 'Url', array('class'	=> 'form-control')); ?>
	<?= $this->Form->input('id','hidden'); ?>
	<?= $this->Form->input('content', 'Contenu', array(
	'type' 	=> 'textarea',
	'class'	=> 'form-control',
	'rows'	=>5
	)
	); ?>
	<?= $this->Form->input('online', 'En ligne', array('class'=>'checkbox', 'type' => 'checkbox')); ?>
	<br/><br/>
	<input type="submit" class="btn btn-success" value="Soumette"/>
</form>
<br/>
<a type="button" href="<?= Rooter::url('admin/posts/edit') ?>" class="btn btn-primary btn-lg">Ajouter Un post</a>