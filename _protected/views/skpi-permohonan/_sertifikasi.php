<table cellpadding="2" border="0" cellspacing="0" width="100%">
  <tr>
    <td width="49%" style=";background-color:#b8b8b8">B. AKTIVITAS PRESTASI DAN PENGHARGAAN</td>
    <td width="2%"></td>
    <td width="49%" style=";background-color:#b8b8b8"><i>B. Activities, Achievements and Awards</i></td>
  </tr>
  <tr>
    <td width="49%" style=";background-color:#b8b8b8;text-align: justify">Pemegang Surat Keterangan Pendamping Ijazah ini memiliki sertifikat professional:</td>
    <td width="2%"></td>
    <td width="49%" style=";background-color:#b8b8b8;text-align: justify"><i>The holder of this supplement has the following professional certifications:</i></td>
  </tr>
  <?php 

  foreach($list_sertifikasi as $q=>$item){

   ?>
  <tr>
    <td style="text-align: justify;"><?=$q+1?>. <?=$item->lembaga_sertifikasi?></td>
    <td></td>
    <td style="text-align: justify;"><?=$q+1?>. <?=$item->lembaga_sertifikasi?></td>
  </tr>
  
<?php } ?>
</table>
<br><br>
<table cellpadding="2" border="0" cellspacing="0" width="100%">
  
  <tr>
    <td width="49%" style=";background-color:#b8b8b8;text-align: justify;">Pemegang Surat Keterangan Pendamping Ijazah ini telah mengikuti program kegiatan atau telah memenuhi tanggung jawab yang tercantum dalam Indeks Prestasi Kesantrian sebagai berikut:</td>
    <td width="2%"></td>
    <td width="49%" style=";background-color:#b8b8b8;text-align: justify"><i>The holder of this supplement has participated in the activity program or has fulfilled the responsibilities listed in the Kesantrian Achievement Index as follows:</i></td>
  </tr>
</table>
<table cellpadding="0" border="0" cellspacing="0" width="100%">
  
  <tr>
    <td width="49%" ><br><br><table cellpadding="2" border="0" cellspacing="0" width="100%">
        <tr>
          <td width="10%" style=";background-color:#b8b8b8">No</td>
          <td width="65%" style=";background-color:#b8b8b8">Program:</td>
          <td width="25%" style=";background-color:#b8b8b8">Nilai</td>
        </tr>
        <?php 
  
        foreach($nilai_akpam['items'] as $q=>$item){
          // foreach($akpam as $item){



         ?>
        <tr>
          <td style="text-align: justify;"><?=$q+1?>. </td>
          <td style="text-align: justify;"><?=$item['nama']?></td>
          <td style="text-align: justify;"><?=$item['nilai']?></td>
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
          <td width="10%" style=";background-color:#b8b8b8">No</td>
          <td width="65%" style=";background-color:#b8b8b8"><i>Program:</i></td>
          <td width="25%" style=";background-color:#b8b8b8"><i>Score</i></td>
        </tr>
        <?php 
  
        foreach($nilai_akpam['items'] as $q=>$item){
          // foreach($akpam as $item){



         ?>
        <tr>
          <td style="text-align: justify;;color:#176da7;font-style:italic;"><?=$q+1?>. </td>
          <td style="text-align: justify;;color:#176da7;font-style:italic;"><i><?=$item['nama_en']?></i></td>
          <td style="text-align: justify;;color:#176da7;font-style:italic;"><?=$item['nilai']?></td>
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
    <td width="49%" style=";background-color:#b8b8b8;text-align: justify;">Pemegang Surat Keterangan Pendamping Ijazah ini telah memperoleh penilaian kompetensi non-akademik sebagai berikut:</td>
    <td width="2%"></td>
    <td width="49%" style=";background-color:#b8b8b8;text-align: justify"><i>The holder of this supplement has received non-academic competency assessment as follows:</i></td>
  </tr>
</table>
<table cellpadding="0" border="0" cellspacing="0" width="100%">

  <tr>
    <td width="49%"><br><br><table cellpadding="2" border="0" cellspacing="0" width="100%">
        <tr>
          <td width="10%" style=";background-color:#b8b8b8">No</td>
          <td width="65%" style=";background-color:#b8b8b8">Kompetensi:</td>
          <td width="25%" style=";background-color:#b8b8b8">Predikat</td>
        </tr>
        <?php 
  
        foreach($nilai_kompetensi['items'] as $q=>$item){
          


         ?>
        <tr>
          <td style="text-align: justify;"><?=$q+1?>. </td>
          <td style="text-align: justify;"><i><?=$item['nama']?></i></td>
          <td style="text-align: justify;"><?=$item['label']?></td>
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
          <td width="10%" style=";background-color:#b8b8b8">No</td>
          <td width="65%" style=";background-color:#b8b8b8"><i>Competency:</i></td>
          <td width="25%" style=";background-color:#b8b8b8"><i>Predicate</i></td>
        </tr>
        <?php 
  
        foreach($nilai_kompetensi['items'] as $q=>$item){



         ?>
        <tr>
          <td style="text-align: justify;;color:#176da7;font-style:italic;"><?=$q+1?>. </td>
          <td style="text-align: justify;;color:#176da7;font-style:italic;"><i><?=$item['nama_en']?></i></td>
          <td style="text-align: justify;;color:#176da7;font-style:italic;"><?=$item['label_en']?></td>
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
          <td width="10%" style=";background-color:#b8b8b8">No</td>
          <td width="65%" style=";background-color:#b8b8b8">Induk</td>
          <td width="25%" style=";background-color:#b8b8b8">Predikat</td>
        </tr>
        <?php 
        $counter = 0;
        foreach($nilai_induk_kompetensi as $q=>$item){
          $counter++;


         ?>
        <tr>
          <td style="text-align: justify;"><?=$counter?>. </td>
          <td style="text-align: justify;"><i><?=$item['induk']?></i></td>
          <td style="text-align: justify;"><?=$item['label']?></td>
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
          <td width="10%" style=";background-color:#b8b8b8">No</td>
          <td width="65%" style=";background-color:#b8b8b8;color:#176da7"><i>Main</i></td>
          <td width="25%" style=";background-color:#b8b8b8;color:#176da7;font-style: italic;"><i>Predicate</i></td>
        </tr>
        <?php 
        $counter = 0;
        foreach($nilai_induk_kompetensi as $q=>$item){
          $counter++;


         ?>
        <tr>
          <td style="text-align: justify;;color:#176da7;font-style:italic;"><?=$counter;?>. </td>
          <td style="text-align: justify;;color:#176da7"><i><?=$item['induk_en']?></i></td>
          <td style="text-align: justify;;color:#176da7;font-style: italic;"><?=$item['label_en']?></td>
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
    <td width="49%" style=";background-color:#b8b8b8;text-align: justify;">Berdasarkan hasil penilaian kompetensi non-akademik yang telah disebutkan sebelumnya, kemudian dapat disimpulkan bahwa Pemegang Surat Keterangan Pendamping Ijazah ini:</td>
    <td width="2%"></td>
    <td width="49%" style=";background-color:#b8b8b8;text-align: justify"><i>Based on the results of the previously mentioned non-academic competency assessment, it can be concluded that the holder of this supplement:</i></td>
  </tr>
  <tr>
    <td style=";text-align: justify;">
      <?php 
        $label_header = "Mahasiswa ini memiliki keunggulan terbesar dalam ".$nilai_kompetensi['list_top_skills']." Sementara itu, kemampuan terendah terletak pada ".$nilai_kompetensi['list_bottom_skills'];
        $label_header_en = "<i>Students have the greatest advantage in ".strip_tags($nilai_kompetensi['list_top_skills_en']).". Meanwhile, the lowest ability lies in ".strip_tags($nilai_kompetensi['list_bottom_skills_en'])."</i>" ;
        $label_eval_id = "";
        $label_eval_en = "";

        foreach($nilai_kompetensi['top3_evaluasi'] as $obj){

            $label_eval_id .= $obj['id'];
            $label_eval_en .= $obj['en'];
        }

        $label_eval_id .= "<br><br>";
        $label_eval_en .= "<br><br>";

        foreach($nilai_kompetensi['bottom3_evaluasi'] as $obj){

            $label_eval_id .= $obj['id'];
            $label_eval_en .= $obj['en'];
        }
          
        echo $label_header.".<br><br> ".$label_eval_id;
            
       ?>
    </td>
    <td></td>
    <td style=";text-align: justify;color:#176da7">
      <i><?php echo $label_header_en.".<br><br> ".$label_eval_en; ?></i>
    </td>
  </tr>
</table>