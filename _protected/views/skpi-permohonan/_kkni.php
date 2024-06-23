<table cellpadding="4" border="0" cellspacing="0" width="100%">
  <tr>
    <td colspan="2" style="border-top: 1px sold #7c7d7e;"><span style="font-weight: bold;">4. KERANGKA KUALIFIKASI NASIONAL INDONESIA (KKNI)</span><br><span style="font-style: italic;color:#176da7">4. Indonesian Qualification Framework</span><br>
    </td>
  </tr>
</table>
<table cellpadding="2" border="0" cellspacing="0" width="100%">
  <tr>
    <td width="49%" style=";background-color:#b8b8b8">Kerangka Kualifikasi Nasional Indonesia (KKNI)</td>
    <td width="2%"></td>
    <td width="49%" style=";background-color:#b8b8b8;font-style: italic;"><i>The Indonesian National Qualifications Framework (KKNI)</i></td>
  </tr>
  <tr>
    <td style="text-align: justify;"><p>1. Kerangka Kualifikasi Nasional Indonesia (KKNI) adalah kerangka penjenjangan kualifikasi kompetensi yang dapat menyandingkan, menyetarakan, dan mengintegrasikan antara bidang pendidikan, pelatihan kerja, dan pengalaman kerja. KKNI terdiri dari 9 (sembilan) level kualifikasi, dimulai dari Level 1 sebagai kualifikasi terendah hingga Level 9 sebagai kualifikasi tertinggi.</p>
</td>
    <td></td>
    <td style="text-align: justify;;color:#176da7;font-style: italic;"><p>1. The Indonesian National Qualifications Framework (KKNI) is a framework for competency qualification levels to match, equalize, and integrate the education, job training as well as work experience in order to provide recognition of work competencies in accordance with the work structure in various sectors. KKNI consists of 9 (nine) levels of qualification, starting from Level 1 as the lowest qualification to Level 9 as the highest qualification.</p>
</td>
  </tr>
  
  <?php 
  $counter = 1;
  foreach($list_kkni as $q=>$item){
    $counter++;
   ?>
  <tr>
    <td width="49%" style=";background-color:#b8b8b8"><?=$item->header?></td>
    <td width="2%"></td>
    <td width="49%" style=";background-color:#b8b8b8;font-style: italic;"><i><?=$item->header_en?></i></td>
  </tr>
  <tr>
    <td style="text-align: justify;"><?=$counter?>. <?=$item->nama?></td>
    <td></td>
    <td style="text-align: justify;;color:#176da7;font-style: italic;"><?=$q+1?>. <?=$item->nama_en?></td>
  </tr>
  
<?php } ?>
</table>