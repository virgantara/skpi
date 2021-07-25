<?php

namespace app\console\controllers;

use Yii;

use yii\helpers\Url;
use app\helpers\MyHelper;
use app\models\User;
use app\models\Events;
use app\models\Venue;
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
