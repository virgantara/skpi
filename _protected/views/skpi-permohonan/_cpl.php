<table cellpadding="4" border="0" cellspacing="0" width="100%">
  <tr>
    <td colspan="2" style="border-top: 1px sold #7c7d7e;"><span style="font-weight: bold;">3. INFORMASI TENTANG KUALIFIKASI DAN HASIL YANG DICAPAI</span><br><span style="font-style: italic;color:#176da7">3. Information Identifying the Qualification and Outcomes Obtained
</span><br>
    </td>
  </tr>
</table>
<table cellpadding="2" border="0" cellspacing="0" width="100%">
  <tr>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8">A. CAPAIAN PEMBELAJARAN</td>
    <td width="2%"></td>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8"><i>A. LEARNING OUTCOMES</i></td>
  </tr>
  <?php 
  foreach($list_cpl as $q=>$item){
   ?>
  <tr>
    <td style="text-align: justify;border:1px solid #7c7d7e"><?=$q+1?>. <?=$item->deskripsi?></td>
    <td></td>
    <td style="text-align: justify;border:1px solid #7c7d7e"><?=$q+1?>. <?=$item->deskripsi_en?></td>
  </tr>
  
<?php } ?>
</table>