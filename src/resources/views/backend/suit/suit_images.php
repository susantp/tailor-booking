<div class="col-lg-12 col-md-6">
    <div class="form-group">
        <h3>Climber Images</h3>
    </div>
    <div class="form-group" id="selectImages">
        <?php
        $post_images = (object) session('post_images');
        session(['post_images' => '']);
//        pr($post_images);
        if (isset($post_images->image) && !empty($post_images->image)) {
            $data_counter = sizeof($post_images->image);
            foreach ($post_images->image as $key => $val) {
                ?> 
                <div class="mediaWrapper col-lg-6 col-md-3">
                    <div class="row">
                        <div class="col-md-4">
                            <img class="img-responsive img<?php echo $key ?>" src="<?php echo asset('assets/') . '/' . $val ?>">
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <input id="image_gallery<?php echo $key ?>" data-img="img<?php echo $key ?>" type="text" onclick="BrowseServer(this)" data-resource-type="image" data-multiple="false" name="image[]" value="<?php echo $val; ?>" class="form-control"  placeholder="Image" data-validation="required">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Title"  value="<?php echo $post_images->title[$key] ?>" name="title[]" data-validation="required"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Display Order"  value="<?php echo $post_images->ordering[$key] ?>" name="ordering[]" data-validation=""/>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Description" name="content[]" data-validation="required"><?php echo trim($post_images->content[$key]) ?></textarea>
                            </div>
                        </div>                       
                    </div>                        
                    <a href="javascript:void(0);" class="deleteMedia" >Delete</a>     
                </div>

                <?php
            }
        } else if (isset($data) && !empty($data)) {
//            pr($data[0]->name);
            $data_counter = sizeof($data);
            ?>
            <?php foreach ($data as $key => $gallery) { ?>
                <div class="mediaWrapper col-lg-6 col-md-3">
                    <div class="row">
                        <div class="col-md-4">
                            <img class="img-responsive img<?php echo $key ?>" src="<?php echo asset('assets/') . '/' . $gallery->image   ?>">
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <input id="image_gallery<?php echo $key ?>" data-img="img<?php echo $key ?>" type="text" onclick="BrowseServer(this)" data-resource-type="image" data-multiple="false" name="image[]" value="<?php echo $gallery->image ?>" class="form-control"  placeholder="Image" data-validation="required">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Title"  value="<?php echo $gallery->title ?>" name="title[]" data-validation="required"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Display Order"  value="<?php echo $gallery->ordering ?>" name="ordering[]" data-validation=""/>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Description" name="content[]" data-validation="required"><?php echo $gallery->content ?></textarea>
                            </div>
                        </div>                       
                    </div>                        
                    <a href="javascript:void(0);" class="deleteMedia" >Delete</a>     
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="mediaWrapper col-lg-6 col-md-3">
                <div class="row">
                    <div class="col-md-4">
                        <img class="img-responsive img" src="">
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input id="image_gallery" data-img="img" type="text" onclick="BrowseServer(this)" data-resource-type="image" data-multiple="false" name="image[]" value="" class="form-control"  placeholder="Image" data-validation="required">
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Title"  value="" name="title[]" data-validation="required"/>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Display Order"  value="" name="ordering[]" data-validation=""/>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="Description" name="content[]" data-validation="required"></textarea>
                        </div>
                    </div>                         
                </div>

                <a href="javascript:void(0);" class="deleteMedia">Delete</a>     
            </div>
        <?php } ?>
    </div>
</div>
<div class="col-lg-12 col-md-6">  
    <div class="form-group">
        <span class="pull-right btn btn-info add-images" data-counter="<?php echo isset($data_counter) ? $data_counter : 0 ?>" >+Add More Images</span>
    </div>
</div>