<div class="row ">
    <div class="col-xs-12 ">
        <form  action="" method="get" class="dropdown-page-selection">
            <div class="form-group col-xs-6 pull-right">
                <label class="control-label col-xs-4">Navigation Groups:</label>
                <div class="col-xs-8">
                    <select class="form-control  mb15" onchange="this.form.submit()" name="sort" >
                        <option selected="selected" disabled="">Choose</option>
                        <?php foreach ($nav_groups as $t): ?>

                            <option value="<?= $t->id; ?>" <?php if ($id == $t->id) echo ' selected="selected"' ?>    ><?= $t->group_title; ?></option>
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