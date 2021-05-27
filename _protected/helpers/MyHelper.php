<?php
namespace app\helpers;

use Yii;

/**
 * Css helper class.
 */
class MyHelper
{

	public static function getStatusEvent()
	{
		return [
			'0' => 'Not Started',
			'1' => 'On-progres',
			'2' => 'Finished',
			'3' => 'Postponed',
			'4' => 'Canceled'
		];
	}

	public static function getStatusEventColor()
	{
		return [
			'0' => 'warning',
			'1' => 'info',
			'2' => 'success',
			'3' => 'purple',
			'4' => 'inverse'
		];
	}

	public static function appendZeros($str, $charlength=6)
	{

		return str_pad($str, $charlength, '0', STR_PAD_LEFT);
	}
	public static function getStatusAktivitas()
    {
        $roles = [
        	'A' => 'AKTIF','C' => 'CUTI', 'D' => 'DO','K' => 'KELUAR' ,'L' => 'LULUS','N' => 'NON-AKTIF', 'G'=>'DOUBLE DEGREE','M'=>'MUTASI'
        ];
        

        return $roles;
    }

	public static function getKampusList()
    {
        $results = [];
        $list = \app\models\SimakKampus::find()->all();
        foreach ($list as $item_name) {
            $results[$item_name->kode_kampus] = $item_name->nama_kampus;
        }

        return $results;
    }

	public static function getProdiList()
    {
        $roles = [];
        $listProdi = \app\models\SimakMasterprogramstudi::find()->all();
        foreach ($listProdi as $item_name) {
            $roles[$item_name->kode_prodi] = $item_name->nama_prodi;
        }

        return $roles;
    }

	public static function dmYtoYmd($tgl,$dateonly=false){
		$date = str_replace('/', '-', $tgl);
	    if($dateonly)
	    	return date('Y-m-d',strtotime($date));
	    else
	    	return date('Y-m-d H:i:s',strtotime($date));
	}

	public static function YmdtodmY($tgl,$dateonly=false){
		if($dateonly)
			return date('d-m-Y',strtotime($tgl));
		else
			return date('d-m-Y H:i:s',strtotime($tgl));
	}

	public static function hitungSelisihHari($date1, $date2)
	{
		$date1 = new \DateTime($date1);
		$date2 = new \DateTime($date2);
		$interval = $date1->diff($date2);

		return $interval;
	}

	public static function hitungDurasi($date1, $date2)
	{
		$date1 = new \DateTime($date1);
		$date2 = new \DateTime($date2);
		$interval = $date1->diff($date2);

		$elapsed = '';
		if($interval->d > 0)
			$elapsed = $interval->format('%a hari %h jam %i menit %s detik');
		else if($interval->h > 0)
			$elapsed = $interval->format('%h jam %i menit %s detik');
		else
			$elapsed = $interval->format('%i menit %s detik');
		

		return $elapsed;
	}

	public static function logError($model)
	{
		$errors = '';
        foreach($model->getErrors() as $attribute){
            foreach($attribute as $error){
                $errors .= $error.' ';
            }
        }

        return $errors;
	}

	public static function formatRupiah($value,$decimal=0){
		return number_format($value, $decimal,',','.');
	}

    public static function getSelisihHariInap($old, $new)
    {
        $date1 = strtotime($old);
        $date2 = strtotime($new);
        $interval = $date2 - $date1;
        return round($interval / (60 * 60 * 24)) + 1; 

    }

    public static function getRandomString($minlength=12, $maxlength=12, $useupper=true, $usespecial=false, $usenumbers=true)
	{
		$key = '';
	    $charset = "abcdefghijklmnopqrstuvwxyz";

	    if ($useupper) $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

	    if ($usenumbers) $charset .= "0123456789";

	    if ($usespecial) $charset .= "~@#$%^*()_±={}|][";

	    for ($i=0; $i<$maxlength; $i++) $key .= $charset[(mt_rand(0,(strlen($charset)-1)))];

	    return $key;

	}
}