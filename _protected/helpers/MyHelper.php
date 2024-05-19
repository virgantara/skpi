<?php

namespace app\helpers;

use Yii;

/**
 * Css helper class.
 */
class MyHelper
{

    
	public static function setAkreditasi()
    {

        $result = [
            'nomor_sk' => '363/SK/BAN-PT/Ak/PT/V/2023',
            'kualifikasi' => 'UNGGUL'
        ];

        return $result;
    }
    
	public static function getStatusValidasi()
    {
        return [
            '0' => 'Belum Divalidasi',
            '1' => 'Valid',
            '2' => 'Tidak Valid'
        ];
    }
	public static function getStatusPengajuan()
	{
		return [
		    '0' => 'BELUM DIAJUKAN',
		    '1' => 'DIPROSES',
		    '2' => 'DISETUJUI',
		    '3' => 'DITOLAK'
		];
	}
	public static function getJenisTes()
    {
        return [
            '1' => 'IELTS',
            '2' => 'TOEFL iBT',
            '3' => 'TOEFL ITP',
            '4' => 'TOEIC',
            '5' => 'TOAFL'
        ];
    }

    public static function getJenisSertifikasi()
    {
        return [
            '1' => 'Sertifikasi Kompetensi',
            '2' => 'Sertifikasi Profesi',
        ];
    }
    		
	public static function listAkreditasi()
    {
        $list = [
            'U' => 'Unggul',
            'BS' => 'Baik Sekali',
            'BK' => 'Baik',
            'A' => 'A',
            'B' => 'B',
            'C' => 'C'

        ];

        return $list;
    }
    
	public static function getListHeaderSurat()
    {
        return [
            1 => 'Permohonan Surat Keterangan Aktif',
            2 => 'Permohonan Surat Keterangan Bebas Sanksi Disiplin',
            3 => 'Permohonan Surat Keterangan Lulus AKPAM',
            4 => 'Permohonan Surat Keterangan Bebas Asrama'
        ];
    }
    public static function getListKeperluan()
    {

        $list_keperluan = [
            1 => [
                1 => 'mengurus tunjangan gaji orang tua/to request a statement of parental salary',
                2 => 'mengurus tunjangan pensiun orang tua/to request a statement of parental pension fund',
                3 => 'mengurus BPJS/asuransi kesehatan/to propose BPJS/health insurance',
                4 => 'mengurus beasiswa/for applying for a scholarship',
                5 => 'mengurus kehilangan KTM/to file a report for missing student ID card',
                6 => 'melamar pekerjaan/for applying for a job',
                7 => 'mengurus laporan kehilangan ke kepolisian/to file a report for missing property',
                8 => 'mengurus visa/to apply for a visa',
                9 => 'mengikuti lomba/for following a competition',
                10 => 'mengurus laporan kehilangan KTM ke kepolisian/to file a report for missing student card property',
                99 => 'lain-lain/etc.'    
            ],
            2 => [
                1 => 'Sidang Skripsi/Undergraduate Thesis Defense',
                2 => 'Sidang Tesis/Thesis Defense',
                3 => 'Sidang Disertasi/Dissertation Defense',
                4 => 'Cuti/Student Leave',
                5 => 'Beasiswa/Scholarship',
                6 => 'Transkrip Perkuliahan/Academic Transcript',
                7 => 'Persyaratan Wisuda/Graduation Requirements',
                99 => 'lain-lain/etc.'
            ],
            3 => [
                1 => 'Sidang Skripsi/Undergraduate Thesis Defense',
                2 => 'Sidang Tesis/Thesis Defense',
                3 => 'Sidang Disertasi/Dissertation Defense',
                4 => 'Cuti/Student Leave',
                5 => 'Beasiswa/Scholarship',
                6 => 'Transkrip Perkuliahan/Academic Transcript',
                7 => 'Persyaratan Wisuda/Graduation Requirements',
                99 => 'lain-lain/etc.'
            ],
            4 => [
                7 => 'Persyaratan Wisuda/Graduation Requirements',
                99 => 'lain-lain/etc.'
            ]
        ];

        return $list_keperluan;
    }

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

	public static function listHasilPenelitian()
	{
		return [
			0 => 'Prosiding',
			1 => 'Artikel Jurnal (Submit / Review / Accept / Publish)',
		];
	}

	public static function setHttpUrl($urlLengkap)
	{
		$url = substr($urlLengkap, 0, 4);
		if ($url == 'http') {
			return $urlLengkap;
		}else {
			return 'http://' . $urlLengkap;
		}
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

	public static function getYears()
	{
		$currentDate = date('Y-m-d');
		$oneYearAhead = date('Y', strtotime('+1 year', strtotime($currentDate)));
		$fourYearsAgo = date('Y', strtotime('-3 years', strtotime($currentDate)));

		$years = array_reverse(range($fourYearsAgo, $oneYearAhead));

		return array_combine($years, $years);
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


	public static function convertTanggalIndo($date)
	{
		$bulan = array(
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$date = date("Y-m-d", strtotime($date));
		$pecahkan = explode('-', $date);

		// variabel pecahkan 0 = tanggal
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tahun
		if (!empty($pecahkan[2]) && !empty($pecahkan[1]) && !empty($pecahkan[0]))
			return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
		else
			return 'invalid date format';
	}

	public static function converTanggalIndoLengkap($date)
	{
		$timestamp = strtotime($date);

		// Convert the day name to Indonesian
		$dayName = date("l", $timestamp);
		$dayNames = array(
			'Sunday' => 'Ahad',
			'Monday' => 'Senin',
			'Tuesday' => 'Selasa',
			'Wednesday' => 'Rabu',
			'Thursday' => 'Kamis',
			'Friday' => 'Jum`at',
			'Saturday' => 'Sabtu'
		);
		$dayNameIndonesian = $dayNames[$dayName];
		return $dayNameIndonesian . ', ' . MyHelper::convertTanggalIndo($date);
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
