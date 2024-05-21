<table cellpadding="4" border="0" cellspacing="0" width="100%">
  <tr>
    <td colspan="2" style="border-top: 1px sold #7c7d7e;"><span style="font-weight: bold;">6. PENGESAHAN SKPI</span><br><span style="font-style: italic;color:#176da7">6. SKPI Legalization</span><br>
    </td>
  </tr>
</table>
<table cellpadding="2" border="0" cellspacing="0" width="100%">
   <tr>
    <td width="47%" style=";">PONOROGO, <?=(isset($model->tanggal_pengesahan) ? \app\helpers\MyHelper::convertTanggalIndo($model->tanggal_pengesahan): '-')?>
      <br><i style="color:#176da7">PONOROGO, <?=(isset($model->tanggal_pengesahan) ? date('d-m-Y',strtotime($model->tanggal_pengesahan)): '-')?></i>
      <br><br><br><br><br><br>
    </td>
    <td width="6%"></td>
    <td width="47%" style=";"></td>
  </tr>
  <tr>
    <td><?=$nama_dekan?><br><?=strtoupper($label_dekan_id.' '.$mhs->kodeProdi->kodeFakultas->nama_fakultas)?><br><i style="color:#176da7"><?=$label_dekan_en.' '.$mhs->kodeProdi->kodeFakultas->nama_fakultas_en?></i><br><br>NOMOR INDUK YAYASAN: <?=$niy_dekan?><br><i style="color:#176da7">Foundation ID Number: <?=$niy_dekan?></i>
    </td>
    <td></td>
    <td><?=$mhs->kodeProdi->kaprodi->nama_dosen?><br><?=strtoupper('Ketua Program Studi '.$mhs->kodeProdi->nama_prodi)?><br><i style="color:#176da7"><?='Head of Department of '.$mhs->kodeProdi->nama_prodi_en?></i><br><br>NOMOR INDUK YAYASAN: <?=$mhs->kodeProdi->kaprodi->niy?><br><i style="color:#176da7">Foundation ID Number: <?=$mhs->kodeProdi->kaprodi->niy?></i>
    </td>
  </tr>
</table>
<br><br>
<table cellpadding="2" border="0" cellspacing="0" width="100%">
   <tr>
    <td width="47%" style="text-align: justify;">CATATAN RESMI<br><?=$data_universitas->catatan_resmi;?>
    </td>
    <td width="6%"></td>
    <td width="47%" style="text-align: justify;">ALAMAT<br><i style="color:#176da7">Contact Details</i><br><br><?=strtoupper($data_universitas->nama_institusi);?><br><br><?=$data_universitas->alamat?>
    </td>
  </tr>
  <tr>
    <td width="47%" style="text-align: justify;"><i style="color:#176da7">Offcial Notes</i><br><?=$data_universitas->catatan_resmi_en;?>
    </td>
    <td width="6%"></td>
    <td width="47%" style="text-align: justify;">
    </td>
  </tr>
</table>