<table cellpadding="4" border="0" cellspacing="0" width="100%">
  <tr>
    <td colspan="2" style="border-top: 1px sold #7c7d7e;"><span style="font-weight: bold;">2. INFORMASI TENTANG IDENTITAS PENYELENGGARA PROGRAM</span><br><span style="font-style: italic; color:#176da7">2. Information Identifying the Awarding Institution</span><br>
    </td>
  </tr>
</table>
<table cellpadding="0" border="0" cellspacing="0" width="100%">
  <tr>
    <td width="50%">
      <span  style="font-weight: bold;">SK Pendirian Perguruan Tinggi</span><br>
      <i style="color:#176da7">Awarding Institution's License</i><br>
      <div style="">
        <?=!empty($data_universitas->sk_pendirian) ? strtoupper($data_universitas->sk_pendirian) : '<span style="color:red">No SK Pendirian belum diisi</span>';?><br>
        <?=(!empty($data_universitas->tanggal_sk_pendirian) ? \app\helpers\MyHelper::convertTanggalIndo($data_universitas->tanggal_sk_pendirian): '<span style="color:red">Tanggal SK Pendirian belum diisi</span>');?>          
        </div>
        <br>
    </td>
    <td width="50%">
      <span  style="font-weight: bold;">Persyaratan Penerimaan</span><br>
      <i style="color:#176da7">Entry Requirements</i><br>
      <span><?=(!empty($syarat_penerimaan) ? $syarat_penerimaan->keterangan : 'Syarat Penerimaan Jenjang ini belum ada')?></span><br><span>
        <i><?=(!empty($syarat_penerimaan) ? $syarat_penerimaan->keterangan_en : 'Syarat Penerimaan Jenjang ini belum ada')?></i></span>
    </td>
  </tr>
  <tr>
    <td width="50%">
      <span  style="font-weight: bold;">NAMA PERGURUAN TINGGI</span><br>
      <i style="color:#176da7">Awarding Institution</i><br><span>
        UNIVERSITAS DARUSSALAM GONTOR</span>
        
    </td>
    <td width="50%">
      <span  style="font-weight: bold;">BAHASA PENGANTAR KULIAH</span><br>
      <i style="color:#176da7">Language of Instruction</i><br>
      <span>Indonesia, Inggris, dan Arab</span><br><span>
        <i>Indonesia, English, and Arabic</i></span>
        <br>
    </td>
  </tr>
  <tr>
    <td width="50%">
      <span  style="font-weight: bold;">AKREDITASI PERGURUAN TINGGI</span><br>
      <i style="color:#176da7">Institution Accreditation</i><br>
      <?=$data_universitas->peringkat_akreditasi?> - <?=$data_universitas->lembaga_akreditasi?>
      <br>
      <span><i><?=$data_universitas->peringkat_akreditasi_en?> - <?=$data_universitas->lembaga_akreditasi_en?></i></span>
        <br>
    </td>
    <td width="50%">
      <span  style="font-weight: bold;">Sistem Penilaian</span><br>
      <i style="color:#176da7">Grading System</i><br>
      
         Skala 1-4: <?=$label_range_nilai?><br>
        <i>Scale 1-4: <?=$label_range_nilai?></i>
        
    </td>
  </tr>
  <tr>
    <td width="50%">
      <span  style="font-weight: bold;">Program Studi</span><br>
      <i style="color:#176da7">Department</i><br>
      <?=strtoupper($mhs->kodeProdi->nama_prodi);?><br>
      <span><i><?=$mhs->kodeProdi->nama_prodi_en?></i></span>
        <br>
    </td>
    
    <td width="50%">
      <span  style="font-weight: bold;">Lama Studi Reguler</span><br>
      <i style="color:#176da7">Regular Length of Study</i><br><span>
         <?=$masa_studi->masa_studi?> Semester
        </span>

        
    </td>
  </tr>
  <tr>
    <td width="50%">

      <span  style="font-weight: bold;">Jenis & Jenjang Pendidikan</span><br>
      <i style="color:#176da7">Types & Level of Education</i><br><span>
        <?=strtoupper((!empty($mhs->kodeProdi->jenjang) ? $mhs->kodeProdi->jenjang->label : '-'));?></span>
          <br><span>
            <i><?=(!empty($mhs->kodeProdi->jenjang) ? $mhs->kodeProdi->jenjang->label_en : '-')?></i>
        </span><br>
    </td>
    <td width="50%">
      <span  style="font-weight: bold;">Status Profesi (Bila Ada)</span><br>
      <i style="color:#176da7">Professional Status (If Applicable)</i><br>
      <div style="">

        </div>

        
    </td>
  </tr>
  <tr>
    <td width="50%">
      <span  style="font-weight: bold;">AKREDITASI PROGRAM STUDI</span><br>
      <i style="color:#176da7">Major Accreditation</i><br><span style="">
        <?php 
        $label_id = '';
        $label_en = '';
        foreach($akreditasi['nasional'] as $akr){
          $label_id .= 'Nasional - '.$akr['status_akreditasi'].' - '.$akr['lembaga'];
          $label_en .= 'National - '.$akr['status_akreditasi_en'].' - '.$akr['lembaga'];
        }

        echo $label_id;
        
        foreach($akreditasi['internasional'] as $akr){
          $label_id .= '<br>Internasional - '.$akr['status_akreditasi'].' - '.$akr['lembaga'];
          $label_en .= 'International - '.$akr['status_akreditasi_en'].' - '.$akr['lembaga'];
        }
        ?>
        </span><br><span>
          <i><?=$label_en?></i>
          </span>
        
    </td>
    <td width="50%">
      <span  style="font-weight: bold;">Jenis dan Jenjang Pendidikan Lanjutan</span><br>
      <i style="color:#176da7">Access to Further Study</i><br><span>
        Program Magister & Doktoral<br>
        <i>Master & Doctorate Degree</i>
        </span>
        <br>
        
    </td>
  </tr>
  <tr>
    <td width="50%">
      <span  style="font-weight: bold;">Jenjang Kualifikasi Sesuai KKNI</span><br>
      <i style="color:#176da7">Level of Qualification in the National Qualificatio Framework</i><br><span style="">
        <?=(!empty($level_kkni) ? $level_kkni->header : 'KKNI Jenjang ini belum ada')?>
        </span>
          <br><span>
            <i><?=(!empty($level_kkni) ? $level_kkni->header_en : 'KKNI Jenjang ini belum ada')?></i>
          </span>
        
    </td>
    <td width="50%">
      
    </td>
  </tr>
</table>