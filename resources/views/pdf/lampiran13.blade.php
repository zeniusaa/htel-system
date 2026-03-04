<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    @page { margin: 1cm 1.7cm; }
    body { font-family: "Times New Roman"; font-size: 10pt; }
</style>
</head>
<body>

<p>Bandung, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>

<p>
Kepada Yth:<br>
Kepala Kantor Pertanahan<br>
{{ $pengajuan->kantor_pertanahan }}<br>
Di Tempat
</p>

<br>

<p>Yang bertanda tangan di bawah ini :</p>

<table>
<tr><td width="120">Nama</td><td>: Andi Pratama Wijaya</td></tr>
<tr><td>Umur</td><td>: 15-04-1985</td></tr>
<tr><td>Pekerjaan</td><td>: Wiraswasta</td></tr>
<tr><td>Nomor KTP</td><td>: 3175091504850001</td></tr>
<tr><td>Alamat</td><td>: Jl. Melati Indah No. 12 RT/RW 003/005 Kel. Sukamaju, Kec. Sukasari, Kota Bandung</td></tr>
</table>
<br>

<p>Selaku kuasa dari :</p>

<table>
<tr><td width="120">Nama</td><td>: {{ $pengajuan->nama_debitur }}</td></tr>
<tr><td>Umur</td><td>: {{ $pengajuan->tanggal_lahir }}</td></tr>
<tr><td>Pekerjaan</td><td>: {{ $pengajuan->pekerjaan }}</td></tr>
<tr><td>Nomor KTP</td><td>: {{ $pengajuan->nik }}</td></tr>
<tr><td>Alamat</td><td>: {{ $pengajuan->alamat }}</td></tr>
</table>

<br>

<p>Atas bidang tanah :</p>

<table>
<tr><td width="140">Desa</td><td>: {{ $pengajuan->desa }}</td></tr>
<tr><td>Kecamatan</td><td>: {{ $pengajuan->kecamatan }}</td></tr>
<tr><td>Kota</td><td>: {{ $pengajuan->kota }}</td></tr>
<tr><td>Nomor Hak</td><td>: {{ $pengajuan->no_sertifikat }}</td></tr>
</table>

<br>

<p>Lampiran:</p>
<p>APHT No {{ $pengajuan->no_apht }} Tanggal {{ $pengajuan->tanggal_apht }} diikat denga HT peringkat {{ $pengajuan->peringkat_apht }} Senilai Rp. {{ $pengajuan->nominal }}
</p>

<br><br>

<p>Hormat Kami,</p>
<br><br>

<b>Budhi Haryanto Agus Setiawan</b><br>
FC MANAGER

</body>
</html>