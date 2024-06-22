<table cellpadding="2" border="0" cellspacing="0" width="100%">

  <tr>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8;text-align: justify">Pemegang Surat Keterangan Pendamping Ijazah ini telah menunjukkan dedikasi, komitmen, serta kemampuan yang luar biasa sehingga memperoleh berbagai macam pengakuan prestasi sebagai berikut:</td>
    <td width="2%"></td>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8;text-align: justify"><i>The holder of this supplement has demonstrated extraordinary dedication, commitment and ability to obtain various types of achievement recognition as follows:</i></td>
  </tr>
  <?php 

  foreach($list_prestasi as $q=>$item){
    $label = '';
    if(!empty($item->kegiatan) && !empty($item->kegiatan->kegiatan)){

        $label .= $item->kegiatan->tema;
        // $label .= $item->kegiatan->tema.' - '.$item->kegiatan->kegiatan->nama_kegiatan;

        // if(!empty($item->kegiatan->jenisKegiatan))
        //     $label .= ' - '.$item->kegiatan->jenisKegiatan->nama_jenis_kegiatan;
    }

   ?>
  <tr>
    <td style="text-align: justify;border:1px solid #7c7d7e"><?=$q+1?>. <?=$label?></td>
    <td></td>
    <td style="text-align: justify;border:1px solid #7c7d7e"><?=$q+1?>. <?=$label?></td>
  </tr>
  
<?php } ?>
</table>