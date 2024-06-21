<table cellpadding="4" border="0" cellspacing="0" width="100%">
  <tr>
    <td colspan="2" style="border-top: 1px sold #7c7d7e;"><span style="font-weight: bold;">6. PENGESAHAN SKPI</span><br><span style="font-style: italic;color:#176da7">6. SKPI Legalization</span><br>
    </td>
  </tr>
</table>
<table cellpadding="0" border="0" cellspacing="0" width="100%">
   <tr>
    <td width="47%" style=";"><span>
      PONOROGO, <?=(isset($mhs->tgl_sk_yudisium) ? \app\helpers\MyHelper::convertTanggalIndo($mhs->tgl_sk_yudisium): '-')?></span>
      <br>
      <span><i style="color:#176da7">PONOROGO, <?=(isset($mhs->tgl_sk_yudisium) ? date('d-m-Y',strtotime($mhs->tgl_sk_yudisium)): '-')?></i></span>
      <br><br><br><br><br><br>
    </td>
    <td width="6%"></td>
    <td width="47%" style=";"></td>
  </tr>
  <tr>
    <td><span>
      <?=$nama_dekan?>
        
      </span>
      <br><span>
        <?=strtoupper($label_dekan_id.' '.$mhs->kodeProdi->kodeFakultas->nama_fakultas)?></span><br>
       <span><i style="color:#176da7"><?=$label_dekan_en.' '.$mhs->kodeProdi->kodeFakultas->nama_fakultas_en?></i></span>

        <br><br><span>
          NOMOR INDUK YAYASAN: <?=$niy_dekan?></span>
          <br><span>
            <i style="color:#176da7">Foundation ID Number: <?=$niy_dekan?></i></span>
    </td>
    <td></td>
    <td><span>
      <?=$mhs->kodeProdi->kaprodi->nama_dosen?></span>
      <br><span>
        <?=strtoupper('Ketua Program Studi '.$mhs->kodeProdi->nama_prodi)?></span>
        <br><span>
          <i style="color:#176da7"><?='Head of Department of '.$mhs->kodeProdi->nama_prodi_en?></i></span>
          <br><br><span>
            NOMOR INDUK YAYASAN: <?=$mhs->kodeProdi->kaprodi->niy?></span>
            <br><span>
              <i style="color:#176da7">Foundation ID Number: <?=$mhs->kodeProdi->kaprodi->niy?></i></span>
    </td>
  </tr>
</table>
<br><br>
<table cellpadding="0" border="0" cellspacing="0" width="100%">
   <tr>
    <td width="47%" style="text-align: justify;"><span>
      CATATAN RESMI</span>
      <br><span>
        <?=$data_universitas->catatan_resmi;?></span>
    </td>
    <td width="6%"></td>
    <td width="47%" style="text-align: justify;"><span>
      ALAMAT</span>
      <br><span>
        <i style="color:#176da7">Contact Details</i></span>
        <br><br><span>
          <?=strtoupper($data_universitas->nama_institusi);?></span>
          <br><br><span><?=$data_universitas->alamat?></span>
    </td>
  </tr>
  <tr>
    <td width="47%" style="text-align: justify;">
      <span><i style="color:#176da7">Offcial Notes</i></span>
      <br><span>
        <?=$data_universitas->catatan_resmi_en;?></span>
    </td>
    <td width="6%"></td>
    <td width="47%" style="text-align: justify;">
    </td>
  </tr>
</table>