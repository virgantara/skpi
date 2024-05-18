<table cellpadding="2" border="0" cellspacing="0" width="100%">
  <tr>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8">B. AKTIVITAS PRESTASI DAN PENGHARGAAN</td>
    <td width="2%"></td>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8"><i>B. Activities, Achievements and Awards</i></td>
  </tr>
  <tr>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8;text-align: justify">Pemegang Surat Keterangan Pendamping Ijazah ini memiliki sertifikat professional:</td>
    <td width="2%"></td>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8;text-align: justify"><i>The holder of this supplement has the following professional certifications:</i></td>
  </tr>
  <?php 

  foreach($list_sertifikasi as $q=>$item){

   ?>
  <tr>
    <td style="text-align: justify;border:1px solid #7c7d7e"><?=$q+1?>. <?=$item->lembaga_sertifikasi?></td>
    <td></td>
    <td style="text-align: justify;border:1px solid #7c7d7e"><?=$q+1?>. <?=$item->lembaga_sertifikasi?></td>
  </tr>
  
<?php } ?>
</table>
<br><br>
<table cellpadding="2" border="0" cellspacing="0" width="100%">
  
  <tr>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8;text-align: justify;">Pemegang Surat Keterangan Pendamping Ijazah ini telah mengikuti program kegiatan atau telah memenuhi tanggung jawab yang tercantum dalam Indeks Prestasi Kesantrian sebagai berikut:</td>
    <td width="2%"></td>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8;text-align: justify"><i>The holder of this supplement has participated in the activity program or has fulfilled the responsibilities listed in the Kesantrian Achievement Index as follows:</i></td>
  </tr>
</table>
<table cellpadding="0" border="0" cellspacing="0" width="100%">
  
  <tr>
    <td width="49%" ><br><br><table cellpadding="2" border="0" cellspacing="0" width="100%">
        <tr>
          <td width="10%" style="border:1px solid #7c7d7e;background-color:#b8b8b8">No</td>
          <td width="65%" style="border:1px solid #7c7d7e;background-color:#b8b8b8">Program:</td>
          <td width="25%" style="border:1px solid #7c7d7e;background-color:#b8b8b8">Nilai</td>
        </tr>
        <?php 
  
        foreach($nilai_akpam['items'] as $q=>$item){
          // foreach($akpam as $item){



         ?>
        <tr>
          <td style="text-align: justify;border:1px solid #7c7d7e"><?=$q+1?>. </td>
          <td style="text-align: justify;border:1px solid #7c7d7e"><?=$item['nama']?></td>
          <td style="text-align: justify;border:1px solid #7c7d7e"><?=$item['nilai']?></td>
        </tr>
        
      <?php 
          // } 
        }
        ?>
      </table>
    </td>
    <td width="2%" ></td>
    <td width="49%" ><br><br><table cellpadding="2" border="0" cellspacing="0" width="100%">
        <tr>
          <td width="10%" style="border:1px solid #7c7d7e;background-color:#b8b8b8">No</td>
          <td width="65%" style="border:1px solid #7c7d7e;background-color:#b8b8b8"><i>Program:</i></td>
          <td width="25%" style="border:1px solid #7c7d7e;background-color:#b8b8b8"><i>Score</i></td>
        </tr>
        <?php 
  
        foreach($nilai_akpam['items'] as $q=>$item){
          // foreach($akpam as $item){



         ?>
        <tr>
          <td style="text-align: justify;border:1px solid #7c7d7e"><?=$q+1?>. </td>
          <td style="text-align: justify;border:1px solid #7c7d7e"><i><?=$item['nama_en']?></i></td>
          <td style="text-align: justify;border:1px solid #7c7d7e"><?=$item['nilai']?></td>
        </tr>
        
      <?php 
          // } 
        }
        ?>
      </table>
      
    </td>
  </tr>
</table>
<br><br>
<table cellpadding="2" border="0" cellspacing="0" width="100%">

  <tr>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8;text-align: justify;">Pemegang Surat Keterangan Pendamping Ijazah ini telah memperoleh penilaian kompetensi non-akademik sebagai berikut:</td>
    <td width="2%"></td>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8;text-align: justify"><i>The holder of this supplement has received non-academic competency assessment as follows:</i></td>
  </tr>
</table>
<table cellpadding="0" border="0" cellspacing="0" width="100%">

  <tr>
    <td width="49%"><br><br><table cellpadding="2" border="0" cellspacing="0" width="100%">
        <tr>
          <td width="10%" style="border:1px solid #7c7d7e;background-color:#b8b8b8">No</td>
          <td width="65%" style="border:1px solid #7c7d7e;background-color:#b8b8b8">Kompetensi:</td>
          <td width="25%" style="border:1px solid #7c7d7e;background-color:#b8b8b8">Predikat</td>
        </tr>
        <?php 
  
        foreach($nilai_kompetensi as $q=>$item){
          


         ?>
        <tr>
          <td style="text-align: justify;border:1px solid #7c7d7e"><?=$q+1?>. </td>
          <td style="text-align: justify;border:1px solid #7c7d7e"><i><?=$item['nama']?></i></td>
          <td style="text-align: justify;border:1px solid #7c7d7e"><?=$item['label']?></td>
        </tr>
        
      <?php 
          // } 
        }
        ?>
      </table>
    </td>
    <td width="2%"></td>
    <td width="49%"><br><br><table cellpadding="2" border="0" cellspacing="0" width="100%">
        <tr>
          <td width="10%" style="border:1px solid #7c7d7e;background-color:#b8b8b8">No</td>
          <td width="65%" style="border:1px solid #7c7d7e;background-color:#b8b8b8"><i>Competency:</i></td>
          <td width="25%" style="border:1px solid #7c7d7e;background-color:#b8b8b8"><i>Predicate</i></td>
        </tr>
        <?php 
  
        foreach($nilai_kompetensi as $q=>$item){



         ?>
        <tr>
          <td style="text-align: justify;border:1px solid #7c7d7e"><?=$q+1?>. </td>
          <td style="text-align: justify;border:1px solid #7c7d7e"><i><?=$item['nama_en']?></i></td>
          <td style="text-align: justify;border:1px solid #7c7d7e"><?=$item['label_en']?></td>
        </tr>
        
      <?php 
          // } 
        }
        ?>
      </table>
      
    </td>
  </tr>


</table>
<br>
<table cellpadding="0" border="0" cellspacing="0" width="100%">

  <tr>
    <td width="49%"><br><br><table cellpadding="2" border="0" cellspacing="0" width="100%">
        <tr>
          <td width="10%" style="border:1px solid #7c7d7e;background-color:#b8b8b8">No</td>
          <td width="65%" style="border:1px solid #7c7d7e;background-color:#b8b8b8">Induk:</td>
          <td width="25%" style="border:1px solid #7c7d7e;background-color:#b8b8b8">Predikat</td>
        </tr>
        <?php 
        $counter = 0;
        foreach($nilai_induk_kompetensi as $q=>$item){
          $counter++;


         ?>
        <tr>
          <td style="text-align: justify;border:1px solid #7c7d7e"><?=$counter?>. </td>
          <td style="text-align: justify;border:1px solid #7c7d7e"><i><?=$item['induk']?></i></td>
          <td style="text-align: justify;border:1px solid #7c7d7e"><?=$item['label']?></td>
        </tr>
        
      <?php 
          // } 
        }
        ?>
      </table>
    </td>
    <td width="2%"></td>
    <td width="49%"><br><br><table cellpadding="2" border="0" cellspacing="0" width="100%">
        <tr>
          <td width="10%" style="border:1px solid #7c7d7e;background-color:#b8b8b8">No</td>
          <td width="65%" style="border:1px solid #7c7d7e;background-color:#b8b8b8"><i>Main:</i></td>
          <td width="25%" style="border:1px solid #7c7d7e;background-color:#b8b8b8"><i>Predicate</i></td>
        </tr>
        <?php 
        $counter = 0;
        foreach($nilai_induk_kompetensi as $q=>$item){
          $counter++;


         ?>
        <tr>
          <td style="text-align: justify;border:1px solid #7c7d7e"><?=$counter;?>. </td>
          <td style="text-align: justify;border:1px solid #7c7d7e"><i><?=$item['induk_en']?></i></td>
          <td style="text-align: justify;border:1px solid #7c7d7e"><?=$item['label_en']?></td>
        </tr>
        
      <?php 
        }
        ?>
      </table>
      
    </td>
  </tr>

  
</table>
<br><br>
<table cellpadding="2" border="0" cellspacing="0" width="100%">

  <tr>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8;text-align: justify;">Berdasarkan hasil penilaian kompetensi non-akademik yang telah disebutkan sebelumnya, kemudian dapat disimpulkan bahwa Pemegang Surat Keterangan Pendamping Ijazah ini:</td>
    <td width="2%"></td>
    <td width="49%" style="border:1px solid #7c7d7e;background-color:#b8b8b8;text-align: justify"><i>Based on the results of the previously mentioned non-academic competency assessment, it can be concluded that the holder of this supplement:</i></td>
  </tr>
  <tr>
    <td style="border:1px solid #7c7d7e;text-align: justify;"><?=$model->deskripsi?></td>
    <td></td>
    <td style="border:1px solid #7c7d7e;text-align: justify;"><?=$model->deskripsi_en?></td>
  </tr>
</table>