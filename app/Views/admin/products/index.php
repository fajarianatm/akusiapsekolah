<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Blog</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard') ?>">Catalogue</a></li>
					<li class="breadcrumb-item active">Blog</li>
				</ol>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<!-- /.row -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Data Blog</h3>
						<div class="card-tools">
							<div class="input-group input-group-sm" style="width: 150px;">
								<input type="text" name="table_search" class="form-control float-right" placeholder="Search">
								<div class="input-group-append">
									<button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body table-responsive p-0">
						<?= view('admin/shared/flash_message') ?>
						<table class="table table-hover text-nowrap">
							<thead>
								<tr>
									<th>id</th>
									<th>foto</th>
									<th>judul</th>
									<th style="width:30%;">deskripsi</th>
									<th style="width:15%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php if ($data) : ?>
									<?php foreach ($data as $product) : ?>
										<tr>
											<td><?= $product['id']; ?></td>
											<td><img style="width:15%;height:auto" src="/thumbnail/<?= $product['foto']; ?>"></td>
											<td><?= $product['judul']; ?></td>
											<td style="max-width:100px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= $product['isi_teks']; ?></td>
											<td>
												<a href="<?= site_url('admin/products/edit/' . $product['slug']) ?>" class="badge bg-info">edit</a>
												<form method="POST" action="<?= site_url('admin/products/' . $product['id']) ?>" accept-charset="UTF-8" class="delete" style="display:inline-block">
													<input name="_method" type="hidden" value="DELETE">
													<button class="badge bg-danger" style="border:none !important">delete</button>
												</form>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php else : ?>
									<tr>
										<td colspan="5">No record found</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
					<!-- /.card-body -->
					<div class="card-footer clearfix">
						<div class="row">
							<div class="col-8">
								<?php echo $pager->links('blog', 'orang_pagination') ?>
							</div>
							<div class="col-4 text-right">
								<a href="<?= site_url('admin/products/create') ?>" class="btn btn-success">Tambah Blog</a>
							</div>
						</div>
					</div>
				</div>
				<!-- /.card -->
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<?= $this->endSection() ?>