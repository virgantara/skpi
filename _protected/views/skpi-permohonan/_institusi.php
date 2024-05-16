<table cellpadding="4" border="0" cellspacing="0" width="100%">
  <tr>
    <td colspan="2" style="border-top: 1px sold #7c7d7e;">
      <span style="font-weight: bold;">2. INFORMASI TENTANG IDENTITAS PENYELENGGARA PROGRAM</span><br>
      <span style="font-style: italic;">1. Information Identifying the Awarding Institution</span><br>
    </td>
  </tr>
</table>
<table cellpadding="0" border="0" cellspacing="0" width="100%">
  <tr>
    <td width="50%">
      <span  style="font-weight: bold;">SK Pendirian Perguruan Tinggi</span><br>
      <i>Awarding Institution's License</i><br>
      <div style="text-indent: 10px;">
        <?=!empty($data_universitas->sk_pendirian) ? strtoupper($data_universitas->sk_pendirian) : '<span style="color:red">No SK Pendirian belum diisi</span>';?><br>
        <?=(!empty($data_universitas->tanggal_sk_pendirian) ? \app\helpers\MyHelper::convertTanggalIndo($data_universitas->tanggal_sk_pendirian): '<span style="color:red">Tanggal SK Pendirian belum diisi</span>');?>          
        </div>
        <div style="text-indent: 10px;"><i><?=strtoupper($data_universitas->sk_pendirian);?>
        <?=(!empty($data_universitas->tanggal_sk_pendirian) ? date('M d, Y',strtotime($data_universitas->tanggal_sk_pendirian)): 'Tanggal SK Pendirian belum diisi');?>

        </i></div><br>
    </td>
    <td width="50%">
      <span  style="font-weight: bold;">Persyaratan Penerimaan</span><br>
      <i>Entry Requirements</i><br>
      <div style="font-weight: bold;"></div>
    </td>
  </tr>
  <tr>
    <td width="50%">
      <span  style="font-weight: bold;">Program Studi</span><br>
      <i>Department</i><br>
      <div style="text-indent: 10px;"><?=strtoupper($mhs->kodeProdi->nama_prodi);?>
        <br><i><?=$mhs->kodeProdi->nama_prodi_en?></i>
        </div><br>
    </td>
    <td width="50%">
      <span  style="font-weight: bold;">Sistem Penilaian</span><br>
      <i>Grading System</i><br>
      <div style="text-indent: 10px;">
         Skala 1-4: <?=$label_range_nilai?><br>
        <i>Scale 1-4: <?=$label_range_nilai?></i>
        </div>
    </td>
  </tr>
  <tr>
    <td width="50%">
      <span  style="font-weight: bold;">Jenis & Jenjang Pendidikan</span><br>
      <i>Types & Level of Education</i><br>
      <div style="text-indent: 10px;"><?=strtoupper((!empty($mhs->kodeProdi->jenjang) ? $mhs->kodeProdi->jenjang->label : '-'));?>
          <br><i><?=(!empty($mhs->kodeProdi->jenjang) ? $mhs->kodeProdi->jenjang->label_en : '-')?></i>
        </div><br>
    </td>
    <td width="50%">
      <span  style="font-weight: bold;">Lama Studi Reguler</span><br>
      <i>Regular Length of Study</i><br>
      <div style="text-indent: 10px;">
         8 Semester
        </div>

        
    </td>
  </tr>
  <tr>
    <td width="50%">
      <span  style="font-weight: bold;">Jenjang Kualifikasi Sesuai KKNI</span><br>
      <i>Level of Qualification in the National Qualificatio Framework</i><br>
      <div style="text-indent: 10px;">Level 6
          <br><i>Level 6</i>
        </div>
    </td>
    <td width="50%">
      <span  style="font-weight: bold;">Jenis dan Jenjang Pendidikan Lanjutan</span><br>
      <i>Access to Further Study</i><br>
      <div style="text-indent: 10px;">
        Program Magister & Doktoral<br>
        <i>Master & Doctorate Degree</i>
        </div>
        <br>
        
    </td>
  </tr>
  <tr>
    <td width="50%">
      
    </td>
    <td width="50%">
      <span  style="font-weight: bold;">Status Profesi (Bila Ada)</span><br>
      <i>Professional Status (If Applicable)</i><br>
      <div style="text-indent: 10px;">

        </div>

        
    </td>
  </tr>
</table>