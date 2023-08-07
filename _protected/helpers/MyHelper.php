<?php

namespace app\helpers;

use Yii;

/**
 * Css helper class.
 */
class MyHelper
{

	public static function getTingkatUKM()
	{
		return ['1' => 'Lokal', '2' => 'Nasional', '3' => 'Internasional', '4' => 'Dalam Kampus'];
	}

	public static function listRekomendasi()
	{
		return [
			'0' => 'Dibina Tanpa Pemanggilan Orang Tua',
			'1' => 'Dibina dan Pemanggilan Orang Tua',
			'2' => 'Dikeluarkan',

		];
	}

	public static function getHari()
	{
		return [
			'Saturday' => 'Sabtu',
			'Sunday' => 'Ahad',
			'Monday' => 'Senin',
			'Tuesday' => 'Selasa',
			'Wednesday' => 'Rabu',
			'Thursday' => 'Kamis',
			'Friday' => 'Jum\'at'
		];
	}

	public static function listSimkatmawaApresiasi()
	{
		return [
			0 => 'Juara 1',
			1 => 'Juara 2',
			2 => 'Juara 3',
			3 => 'Harapan',
			4 => 'Partisipasi / Delegasi / Peserta Kejuaraan',
		];
	}

	public static function listSimkatmawaMbkm()
	{
		return [
			0 => 'Pertukaran Pelajar',
			1 => 'Magang / Praktik Kerja',
			2 => 'Mengajar di Sekolah',
			3 => 'Penelitian / Riset',
			4 => 'Proyek Kemanusiaan',
			5 => 'Proyek Desa',
			6 => 'Wirausaha',
			7 => 'Studi / Proyek Independen',
			8 => 'Pengabdian Mahasiswa kepada Masyarakat',
		];
	}

	public static function listSimkatmawaLevel()
	{
		return [
			0 => [
				0 => 'Provinsi',
				1 => 'Wilayah',
				2 => 'Nasional',
				3 => 'Internasional',
			],
			1 => [
				2 => 'Nasional',
				3 => 'Internasional',
			]
		];
	}
	
	public static function listStatusSks()
	{
		return [
			0 => 'Non-SKS',
			1 => 'SKS',
		];
	}

	public static function gen_uuid()
	{
		return sprintf(
			'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff),

			// 16 bits for "time_mid"
			mt_rand(0, 0xffff),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand(0, 0x0fff) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand(0, 0x3fff) | 0x8000,

			// 48 bits for "node"
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff)
		);
	}

	public static function getPeriodeEvent()
	{
		return [
			'1' => '1 bulan ke depan',
			'3' => '3 bulan ke depan',
			'6' => '6 bulan ke depan',
			'12' => '1 tahun ke depan',
			'-12' => '1 tahun yang lalu'
		];
	}

	public static function getTingkatEvent()
	{
		return ['Prodi' => 'Prodi', 'Fakultas' => 'Fakultas', 'Universitas' => 'Universitas', 'Lokal' => 'Lokal', 'Provinsi' => 'Provinsi', 'Nasional' => 'Nasional', 'Internasional' => 'Internasional'];
	}

	public static function getToleransiWaktu()
	{
		return [
			'5' => '5 menit',
			'10' => '10 menit',
			'15' => '15 menit',
			'30' => '30 menit',
			'60' => '1 jam'
		];
	}

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

	public static function appendZeros($str, $charlength = 6)
	{

		return str_pad($str, $charlength, '0', STR_PAD_LEFT);
	}
	public static function getStatusAktivitas()
	{
		$roles = [
			'A' => 'AKTIF', 'C' => 'CUTI', 'D' => 'DO', 'K' => 'KELUAR', 'L' => 'LULUS', 'N' => 'NON-AKTIF', 'G' => 'DOUBLE DEGREE', 'M' => 'MUTASI'
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

	public static function dmYtoYmd($tgl, $dateonly = false)
	{
		$date = str_replace('/', '-', $tgl);
		if ($dateonly)
			return date('Y-m-d', strtotime($date));
		else
			return date('Y-m-d H:i:s', strtotime($date));
	}

	public static function YmdtodmY($tgl, $dateonly = false)
	{
		if ($dateonly)
			return date('d-m-Y', strtotime($tgl));
		else
			return date('d-m-Y H:i:s', strtotime($tgl));
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
		if ($interval->d > 0)
			$elapsed = $interval->format('%a hari %h jam %i menit %s detik');
		else if ($interval->h > 0)
			$elapsed = $interval->format('%h jam %i menit %s detik');
		else
			$elapsed = $interval->format('%i menit %s detik');


		return $elapsed;
	}

	public static function logError($model)
	{
		$errors = '';
		foreach ($model->getErrors() as $attribute) {
			foreach ($attribute as $error) {
				$errors .= $error . ' ';
			}
		}

		return $errors;
	}

	public static function formatRupiah($value, $decimal = 0)
	{
		return number_format($value, $decimal, ',', '.');
	}

	public static function getSelisihHariInap($old, $new)
	{
		$date1 = strtotime($old);
		$date2 = strtotime($new);
		$interval = $date2 - $date1;
		return round($interval / (60 * 60 * 24)) + 1;
	}

	public static function getRandomString($minlength = 12, $maxlength = 12, $useupper = true, $usespecial = false, $usenumbers = true)
	{
		$key = '';
		$charset = "abcdefghijklmnopqrstuvwxyz";

		if ($useupper) $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

		if ($usenumbers) $charset .= "0123456789";

		if ($usespecial) $charset .= "~@#$%^*()_±={}|][";

		for ($i = 0; $i < $maxlength; $i++) $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];

		return $key;
	}
}
