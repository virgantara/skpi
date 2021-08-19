<?php

namespace app\console\controllers;

use Yii;

use yii\helpers\Url;
use app\helpers\MyHelper;
use app\models\User;
use app\models\Events;
use app\models\Venue;
use app\models\SimakPropinsiBatas;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\web\NotFoundHttpException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Protection;

/**
 * TendikController implements the CRUD actions for Tendik model.
 */
class AccountController extends Controller
{
    public function actionKabupaten()
    {
        $tmp_name = \Yii::getAlias('@app').'/indonesia-prov.csv';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($tmp_name);
        $sheet = $spreadsheet->getSheet(0); 
        $highestRow = $sheet->getHighestDataRow();
        
        $counter = 0;
        for ($row = 1; $row <= $highestRow; $row++)
        {
            $kode = trim($sheet->getCell('A'.$row)->getValue());
            $coord = trim($sheet->getCell('C'.$row)->getValue());
            
            $list_coord = explode(",",$coord);

            $tmps = SimakPropinsiBatas::find()->where(['kode_prop' => $kode])->all();
            foreach($tmps as $tmp)
                $tmp->delete();

            $size = count($list_coord) / 2;
            $i = 0;
            while($i<$size)
            {
                $m = new SimakPropinsiBatas;
                $m->kode_prop = $kode;
                $m->latitude = $list_coord[$i+1];
                $m->longitude = $list_coord[$i];
                if($m->save())
                {
                    $counter++;
                    echo $counter." updated";
                    echo "\n";
                }

                else
                {
                    print_r($m->attributes);
                    print_r(MyHelper::logError($m));
                    exit;
                }

                $i += 2;

            }

            
        }

        echo "\n";
        return ExitCode::OK;
    }

    public function actionUpdateVenue()
    {
        $tmp_name = \Yii::getAlias('@app').'/erp_venue.csv';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($tmp_name);
        $sheet = $spreadsheet->getSheet(0); 
        $highestRow = $sheet->getHighestDataRow();
        
        $counter = 0;
        for ($row = 2; $row <= $highestRow; $row++)
        {
            $nama = trim($sheet->getCell('B'.$row)->getValue());
            $kode = trim($sheet->getCell('C'.$row)->getValue());

            $list = Events::find()->where(['venue' => $nama])->all();
            foreach($list as $evt)
            {  
                $evt->venue = $kode; 
                if($evt->save())
                {
                    $counter++;
                    echo $counter." updated";
                    echo "\n";
                }

                else{
                    print_r(MyHelper::logError($evt));
                    exit;
                    
                }    
            }
            
        }

        echo "\n";
        return ExitCode::OK;
    }

    
}
