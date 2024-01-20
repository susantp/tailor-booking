<div class="col-lg-12 col-md-6">
    <div class="form-group">
        <h3>Opening Hours</h3>
    </div>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Enter the opening hours below: <span class="instructions">Custom message will override opening hours.</span></h3>
        </div>
        <div class="box-body no-padding">
            <?php
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            ?>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Days</th>
                        <th>Hours</th>
                        <th>Custom Message</th>
                    </tr>
                    <?php
                    if (isset($data) && !empty($data)) {
                        $oh = json_decode($data);
                        foreach ($days as $sn => $day) {
                            ?>
                            <tr>
                                <td><?php echo $sn + 1; ?>.</td>
                                <td><?php echo $day; ?></td>
                                <td><input class="form-control" placeholder="Eg: 9:00am - 5:00pm"  value="<?php echo $oh->hrs[$sn] ?>" name="opening_hours[hrs][]" data-validation=""/></td>
                                <td><input class="form-control" placeholder="Custom Message"  value="<?php echo $oh->msg[$sn] ?>" name="opening_hours[msg][]" data-validation=""/></td>
                            </tr>
                            <?php
                        }
                    } else {
                        foreach ($days as $sn => $day) {
                            ?>
                            <tr>
                                <td><?php echo $sn + 1; ?>.</td>
                                <td><?php echo $day; ?></td>
                                <td><input class="form-control" placeholder="Eg: 9:00am - 5:00pm"  value="<?php //echo $post_images->ordering[$key]           ?>" name="opening_hours[hrs][]" data-validation=""/></td>
                                <td><input class="form-control" placeholder="Custom Message"  value="<?php //echo $post_images->ordering[$key]           ?>" name="opening_hours[msg][]" data-validation=""/></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>