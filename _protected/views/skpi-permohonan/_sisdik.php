<table cellpadding="4" border="0" cellspacing="0" width="100%">
  <tr>
    <td colspan="2" style="border-top: 1px sold #7c7d7e;"><span style="font-weight: bold;">4. INFORMASI TENTANG SISTEM PENDIDIKAN TINGGI DI INDONESIA</span><br><span style="font-style: italic;color:#176da7">4. Information on the Indonesian Higher Education System and the Indonesian National Qualifications Framework</span><br>
    </td>
  </tr>
</table>
<table cellpadding="2" border="0" cellspacing="0" width="100%">
  <tr>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8">SISTEM PENDIDIKAN</td>
    <td width="2%"></td>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8"><i>EDUCATION SYSTEM</i></td>
  </tr>
  <?php 
  foreach($list_sistem_pendidikan as $q=>$item){
   ?>
  <tr>
    <td style="text-align: justify;border:1px solid #7c7d7e"><?=$q+1?>. <?=$item->nama?></td>
    <td></td>
    <td style="text-align: justify;border:1px solid #7c7d7e;font-style: italic;color:#176da7"><?=$q+1?>. <?=$item->nama_en?></td>
  </tr>
  
<?php } ?>
</table>