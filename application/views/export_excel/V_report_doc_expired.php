<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$nama.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table>
	<tr>
		<td bgcolor="yellow">Nomor Dokumen</td>
		<td bgcolor="yellow">Nama Dokumen</td>
		<td bgcolor="yellow">Kategori</td>
		<td bgcolor="yellow">Jenis</td>
		<td bgcolor="yellow">Tipe</td>
		<td bgcolor="yellow">Pencipta</td>
		<td bgcolor="yellow">Tanggal Efektif</td>
		<td bgcolor="yellow">Tanggal Kadaluarsa</td>
		<td bgcolor="yellow">Status</td>
	</tr>
	<?php for ($i=0; $i < $jumlah; $i++): ?>
	<?php $dokumen = $this->M_library_report->GET_DOCUMENT($document[$i]); ?>
	<?php if(!empty($dokumen)): ?>
	<?php foreach ($dokumen as $dokumen): ?>
	<tr>
		<td><?= $dokumen->DOC_NOMOR; ?></td>
		<td><?=	$dokumen->DOC_NAMA; ?></td>
		<td><?= $dokumen->DTSEKI_KATEGORI; ?></td>
		<td><?= $dokumen->DTSEJS_JENIS; ?></td>
		<td><?= $dokumen->DTSETE_TIPE; ?></td>
		<td><?= $dokumen->DOC_MAKER; ?></td>
		<td><?= date('d/m/Y', strtotime($dokumen->DOC_TGL_EFEKTIF)); ?></td>
		<td><?= date('d/m/Y', strtotime($dokumen->DOC_TGL_EXPIRED)); ?></td>
		<td><?= $dokumen->DOC_STATUS; ?></td>
	</tr>
	<?php endforeach; ?>
	<?php endif; ?>
	<?php endfor; ?>
</table>