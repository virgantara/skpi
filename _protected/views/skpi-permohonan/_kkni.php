<table cellpadding="4" border="0" cellspacing="0" width="100%">
  <tr>
    <td colspan="2" style="border-top: 1px sold #7c7d7e;"><span style="font-weight: bold;">5. KERANGKA KUALIFIKASI NASIONAL INDONESIA (KKNI)</span><br><span style="font-style: italic;color:#176da7">5. Indonesian Qualification Framework</span><br>
    </td>
  </tr>
</table>
<table cellpadding="2" border="0" cellspacing="0" width="100%">
  
  <?php 
  foreach($list_kkni as $q=>$item){
   ?>
  <tr>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8"><?=$item->header?></td>
    <td width="2%"></td>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8;font-style: italic;"><i><?=$item->header_en?></i></td>
  </tr>
  <tr>
    <td style="text-align: justify;border:1px solid #7c7d7e"><?=$q+1?>. <?=$item->nama?></td>
    <td></td>
    <td style="text-align: justify;border:1px solid #7c7d7e;color:#176da7;font-style: italic;"><?=$q+1?>. <?=$item->nama_en?></td>
  </tr>
  
<?php } ?>
</table>