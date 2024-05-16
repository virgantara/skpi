<table cellpadding="4" border="0" cellspacing="0" width="100%">
  <tr>
    <td colspan="2" style="border-top: 1px sold #7c7d7e;">
      <span style="font-weight: bold;">1. INFORMASI TENTANG IDENTITAS DIRI PEMEGANG SKPI</span><br>
      <span style="font-style: italic;">1. Information Identifying the Holder of Diploma Supplement</span><br>
    </td>
  </tr>
</table>
<table cellpadding="0" border="0" cellspacing="0" width="100%">
  <tr>
    <td width="50%">
      Nama Lengkap<br>
      <i>Fullname</i><br>
      <div style="font-weight: bold;text-indent: 10px;">
        <?=strtoupper($mhs->nama_mahasiswa);?>
        </div><br>
    </td>
    <td width="50%">
      Tahun Lulus<br>
      <i>Year of Completion</i><br>
      <div style="font-weight: bold;text-indent: 10px;">
        <?=(isset($mhs->tgl_lulus) ? date('Y',strtotime($mhs->tgl_lulus)) : null)?>
          
        </div>
    </td>
  </tr>
  <tr>
    <td width="50%">
      Tempat dan Tanggal Lahir<br>
      <i>Place and Date of Birth</i><br>
      <div style="font-weight: bold;text-indent: 10px;">
        <?=$mhs->tempat_lahir.', '.\app\helpers\MyHelper::convertTanggalIndo($mhs->tgl_lahir)?>
          
        </div><br>
    </td>
    <td width="50%">
      Nomor Ijazah<br>
      <i>Diploma Number</i><br>
      <div style="font-weight: bold;text-indent: 10px;">
        <?=($mhs->no_ijazah ?: '-')?>
          
        </div>
    </td>
  </tr>
  <tr>
    <td width="50%">
      Nomor Induk Mahasiswa<br>
      <i>Student Identification Number</i><br>
      <div style="font-weight: bold;text-indent: 10px;">
        <?=$mhs->nim_mhs?>
          
        </div><br>
    </td>
    <td width="50%">
      Gelar<br>
      <i>Name of Qualification</i><br>
      <div style="font-weight: bold;text-indent: 10px;">
       <b><?=ucwords(strtolower($mhs->kodeProdi->gelar_lulusan));?> (<?=$mhs->kodeProdi->gelar_lulusan_short;?>)</b><br>
       <i><?=ucwords(strtolower($mhs->kodeProdi->gelar_lulusan_en));?></i>
          
        </div>
    </td>
  </tr>
</table>