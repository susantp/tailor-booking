<div class="row ">
    <div class="col-xs-12 ">
        <form  action="" method="get" class="dropdown-page-selection">
            <div class="form-group col-xs-6 pull-right">
                <label class="control-label col-xs-4">Gallery:</label>
                <div class="col-xs-8">
                    <select class="form-control  mb15" onchange="this.form.submit()" name="g" >
                        <option selected="selected" disabled="">Choose</option>
                        <?php foreach ($gallery as $t): ?>
                            <option value="<?= $t->id; ?>" <?php if ($gid == $t->id) echo ' selected="selected"' ?>    ><?= $t->gallery_name; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>
            </div>
            <div class="form-group col-xs-2 pull-right">
                <label class="control-label"><?php //if(($key!=''))echo 'Total rows: '. count($productInfo)          ?></label>
            </div>
        </form>
    </div>

</div>