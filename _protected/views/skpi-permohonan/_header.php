<table cellpadding="4" border="0" cellspacing="0" width="100%">
  <tr>
    <td width="70%" style="border-top: 1px sold #7c7d7e;"><span style="font-size: 24px;color:#176da7">SURAT KETERANGAN PENDAMPING IJAZAH</span><br><br><span style="font-size: 12px;font-style: italic;">Diploma Supplement</span>
    </td>
    <td width="30%" style="border-top: 1px sold #7c7d7e;">
      Nomor: <?=($model->nomor_skpi ?: '<span style="color:red">Nomor SKPI belum diisi</span>')?>
    </td>
  </tr>
</table>

<table cellpadding="2" border="0" cellspacing="0" width="100%">
  <tr>
    <td style="text-align: justify;border-top: 1px sold #7c7d7e;"><?=(!empty($data_universitas) ? $data_universitas->deskripsi_skpi : '-')?></td>
  </tr>
  <tr>
    <td style="font-style: italic;text-align: justify;"><?=(!empty($data_universitas) ? $data_universitas->deskripsi_skpi_en : '-')?></td>
  </tr>
</table>