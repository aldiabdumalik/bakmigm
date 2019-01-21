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
		<td bgcolor="yellow">Pencipta</td>
		<td bgcolor="yellow">Dari</td>
		<td bgcolor="yellow">Komentar</td>
		<td bgcolor="yellow">Tanggal</td>
	</tr>
	<?php for ($i=0; $i < $jumlah; $i++): ?>
	<?php $komentar = $this->M_library_report->GET_COMMENT($document[$i]); ?>
	<?php if(!empty($komentar)): ?>
	<?php foreach ($komentar as $komentar): ?>
	<tr>
		<td><?= $komentar->DOC_NOMOR; ?></td>
		<td><?= $komentar->DOC_NAMA; ?></td>
		<td><?= $komentar->DOC_MAKER; ?></td>
		<td><?= $komentar->DTCT_USER; ?></td>
		<td><?= $komentar->DTCT_NOTE; ?></td>
		<td><?= date('d/m/Y H:i', strtotime($komentar->DTCT_DATE))." WIB"; ?></td>
	</tr>
	<?php endforeach; ?>
	<?php endif; ?>
	<?php endfor; ?>
</table>