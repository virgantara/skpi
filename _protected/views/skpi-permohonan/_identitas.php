<table cellpadding="4" border="0" cellspacing="0" width="100%">
  <tr>
    <td colspan="2" style="border-top: 1px sold #7c7d7e;"><span style="font-weight: bold;">1. INFORMASI TENTANG IDENTITAS DIRI PEMEGANG SKPI</span><br><span style="font-style: italic; color:#176da7">1. Information Identifying the Holder of Diploma Supplement</span><br>
    </td>
  </tr>
</table>
<table cellpadding="0" border="0" cellspacing="0" width="100%">
  <tr>
    <td width="50%">
      NAMA LENGKAP<br>
      <i style="color:#176da7">Fullname</i><br><span style="font-weight: bold;">
        <?=strtoupper($mhs->nama_mahasiswa);?>
        </span><br>
    </td>
    <td width="50%">
      Tahun Lulus<br>
      <i style="color:#176da7">Year of Completion</i><br><span style="font-weight: bold;">
        <?=(isset($mhs->tgl_lulus) ? date('Y',strtotime($mhs->tgl_lulus)) : null)?>
          
        </span>
    </td>
  </tr>
  <tr>
    <td width="50%">
      TEMPAT DAN TANGGAL LAHIR<br>
      <i style="color:#176da7">Place and Date of Birth</i><br><span style="font-weight: bold;">
        <?=$mhs->tempat_lahir.', '.\app\helpers\MyHelper::convertTanggalIndo($mhs->tgl_lahir)?>
          
        </span><br>
    </td>
    <td width="50%">
      NOMOR IJAZAH<br>
      <i style="color:#176da7">Diploma Number</i><br><span style="font-weight: bold;">
        <?=($mhs->nina)?>
          
        </span>
    </td>
  </tr>
  <tr>
    <td width="50%">
      NOMOR INDUK MAHASISWA<br>
      <i style="color:#176da7">Student Identification Number</i><br><span style="font-weight: bold;">
        <?=$mhs->nim_mhs?>
          
        </span><br>
    </td>
    <td width="50%">
      GELAR<br>
      <i style="color:#176da7">Name of Qualification</i><br>
       <b><?=ucwords(strtolower($mhs->kodeProdi->gelar_lulusan));?> (<?=$mhs->kodeProdi->gelar_lulusan_short;?>)</b><br>
       <i><?=ucwords(strtolower($mhs->kodeProdi->gelar_lulusan_en));?></i>
          
        
    </td>
  </tr>
</table>