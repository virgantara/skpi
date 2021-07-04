
    <div class="col-xs-6 col-sm-4 col-md-3">
        <div class="thumbnail search-thumbnail">
            <!-- <span class="search-promotion label label-success arrowed-in arrowed-in-right">Sponsored</span>
 -->
            <img class="media-object" src="<?=!empty($model->file_path) ? $model->file_path : $empty_image;?>" width="150px" />
            <div class="caption">
                <div class="clearfix">
                    <span class="pull-right label label-grey info-label"><?=$model->venue;?></span>

                    <div class="pull-left bigger-110">
                        <i class="ace-icon fa fa-star orange2"></i>

                        <i class="ace-icon fa fa-star orange2"></i>

                        <i class="ace-icon fa fa-star orange2"></i>

                        <i class="ace-icon fa fa-star-half-o orange2"></i>

                        <i class="ace-icon fa fa-star light-grey"></i>
                    </div>
                </div>

                <h3 class="search-title">
                    <a href="#" class="blue"><?=!empty($model->kegiatan) ? $model->kegiatan->nama_kegiatan : '-';?></a>
                </h3>
                <p><?=substr($model->nama, 0,35);?> ...</p>
            </div>
        </div>
    </div>

   
