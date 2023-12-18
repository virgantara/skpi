<?php 

setlocale(LC_ALL, 'id_ID', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');

use GeniusTS\HijriDate\Translations\English;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Date;

Date::setTranslation(new English);
$date_hijri = \GeniusTS\HijriDate\Hijri::convertToHijri($model->tanggal_disetujui);
$date_hijri = $date_hijri->format('d F o');

 ?>
<br><br><br><br><br>
<br><br><br><br><br>
<table border="0" style="font-size:9px;font-weight:bold;;font-family: 'Times'" width="100%">
  
    
      <tr>
        <td colspan="4" align="center">
          <strong style="font-size: 12px;"><u>SURAT KETERANGAN AKPAM MAHASISWA</u></strong>
          <br>
          <strong style="font-size: 12px;">UNIVERSITAS DARUSSALAM GONTOR</strong>
          <br>
          Nomor: <?=$model->nomor_surat?>
        </td>
      </tr>
       
   </table>
   
 <br>  <br>
 <table border="0" width="100%" style="font-family: 'Times';font-size: 12px;;">
      <tr>
        <td width="100%" style="text-align: left;font-style: italic;">Bismillahirrahmanirrahim<br>Assalamu'alaikum warahmatullahi wabarakatuh<br>
        </td>
      </tr>
      <tr>
        <td width="100%" style="text-align: justify;">Dengan ini Direktorat Kepesantrenan Universitas Darussalam Gontor, dengan ini menerangkan bahwa mahasiswa berikut:
        </td>
      </tr>
</table> 
 <br><br>
    <table border="0" width="100%" style="font-family: 'Times';font-size: 12px;;text-indent: 35px">
      <tr>
        <td width="60%">
          <table border="0" width="100%" >
            <tr>
            
           <td align="left" width="130px" style="font-weight: bold;"> NIM </td>
            <td align="center" width="10px">:</td>
            <td align="left" width="590px"><?php echo $mhs->nim_mhs;?></td>
         </tr>
         <tr>
           <td align="left"  style="font-weight: bold;"> Nama Mahasiswa</td>
           <td align="center" >:</td>
           <td align="left"  ><?php echo ucwords($mhs->nama_mahasiswa);?></td>
         </tr>
          
         <tr>
            
           <td align="left" style="font-weight: bold;"> Fakultas/Prodi/Semester </td>
            <td align="center">:</td>
            <td align="left"><?php echo $fakultas->nama_fakultas;?> / <?php echo $prodi->nama_prodi;?> / <?php echo $mhs->semester;?></td>
         </tr>
         <tr>
           <td align="left"  style="font-weight: bold;"> Kampus</td>
           <td align="center" >:</td>
           <td align="left" ><?php echo ucwords($mhs->kampus0->nama_kampus);?></td>
         </tr>
        <tr>
           <td align="left"  style="font-weight: bold;"> Keperluan</td>
           <td align="center" >:</td>
           <td align="left" ><?php echo ucwords($model->keperluan);?></td>
         </tr>
        </table>
        </td>
        <td align="center" width="40%">
         
        
        </td>
      </tr>
     
    </table>
<table border="0" width="100%" style="font-family: 'Times';font-size: 12px;;">
      <tr>
        <td width="100%" style="text-align: justify;">Mahasiswa di atas benar-benar telah mengikuti kegiatan yang diadakan oleh Direktorat Kepesantrenan dengan nilai kumulatif sebagai berikut:
          <br>
        <table border="1" width="100%" cellpadding="1" cellspacing="0">
                <tr>
                    <td align="center" style="background-color: lightgray;"><b>Jenis Kegiatan</b></td>
                    <td align="center" style="background-color: lightgray;"><b>Nilai</b></td>
                </tr>
                <?php 

                foreach($listJenisKegiatan as $jk)
                {
                 ?>
                <tr>
                    <td><?=$jk->nama_jenis_kegiatan?></td>
                    <td align="center"><?=round($list_ipks[$jk->id],2)?></td>
                </tr>
                <?php 
                }
                 ?>
                <tr>
                    <td style="background-color: lightgray;"><b>Total</b></td>
                    <td align="center" style="background-color: lightgray;"><b><?=round($subakpam,2)?></b></td>
                </tr>
                <tr>
                    <td style="background-color: lightgray;"><b>IPKs</b></td>
                    <td align="center" style="background-color: lightgray;"><b><?=round($ipks,2)?></b></td>
                </tr>
            
        </table>
            <br>Demikian surat ini kami buat agar dapat menjadi maklum adanya dan dapat dipergunakan sebagaimana mestinya.
          
        </td>
      </tr>
</table> <br><br>
 <table border="0" width="100%" style="font-family: 'Times';font-size: 12px;;">
      <tr>
        <td width="100%" style="text-align: left;font-style: italic;">Wassalamu’alaikum warahmatullahi wabarakatuh
        </td>
      </tr>
      
</table> 
<br><br>
   <table border="0" width="100%" style="font-size:12px;;font-family: 'Times'">
         <tr>
    <td width="20%">
      
      
    </td>
    <td  width="15%">
       
    </td>
    <td  width="65%" align="left" valign="top">
       <table>
         <tr>
            
           <td align="left"  width="30%">Dikeluarkan di </td>
            <td align="center" width="5%">:</td>
            <td align="left" width="65%">Ponorogo</td>
         </tr>
         <tr>
            
           <td align="left">Pada Tanggal </td>
            <td align="center">:</td>
            <td align="left" ><?php echo strftime('%d %B %Y', strtotime($model->tanggal_disetujui)); ?></td>
         </tr>
         <tr>
            
           <td align="left" style="border-bottom: 1px solid black;"> </td>
            <td align="center" style="border-bottom: 1px solid black;">:</td>
            <td align="left" style="border-bottom: 1px solid black;"><?=$date_hijri; ?></td>
         </tr>
         <tr>
           <td colspan="3">Direktur Kepesantrenan,
       <br>
       <br>
       <br>
       <br>
       <br>
       <br>
       <br>
       <u><strong><?=$nama_dekan;?></strong></u><br>
       NIY : <?=$niy;?>
     </td>
         </tr>
       </table>
       
       
    </td>
    
  </tr>
    </table>