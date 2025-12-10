<div class="row product-attribute-set" style="margin-bottom:8px;">
    <div class="col-xs-2">
        <select class="form-control" name="attributes[section_id][]">
            <option value="">---Select Section---</option>
            <?php if(isset($sections)) foreach($sections as $section){ ?>
                <option value="<?php echo $section->id; ?>" <?php if(isset($attr['section_id']) && $attr['section_id']==$section->id){ ?>selected<?php } ?>><?php echo stripslashes($section->name); ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-xs-2">
        <select class="form-control" name="attributes[price_id][]">
            <option value="">---Select Price---</option>
            <?php if(isset($prices)) foreach($prices as $price){ ?>
                <option value="<?php echo $price->id; ?>" <?php if(isset($attr['price_id']) && $attr['price_id']==$price->id){ ?>selected<?php } ?>><?php echo stripslashes($price->name); ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-xs-1">
        <select class="form-control" name="attributes[size_id][]">
            <option value="">---Size---</option>
            <?php if(isset($sizes)) foreach($sizes as $size){ ?>
                <option value="<?php echo $size->id; ?>" <?php if(isset($attr['size_id']) && $attr['size_id']==$size->id){ ?>selected<?php } ?>><?php echo stripslashes($size->name); ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-xs-2">
        <select class="form-control" name="attributes[color_id][]">
            <option value="">---Select Color---</option>
            <?php if(isset($colors)) foreach($colors as $color){ ?>
                <option value="<?php echo $color->id; ?>" <?php if(isset($attr['color_id']) && $attr['color_id']==$color->id){ ?>selected<?php } ?>><?php echo stripslashes($color->name); ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-xs-2">
        <select class="form-control" name="attributes[coupon_id][]">
            <option value="">---Select Coupon---</option>
            <?php if(isset($coupons)) foreach($coupons as $coupon){ ?>
                <option value="<?php echo $coupon->id; ?>" <?php if(isset($attr['coupon_id']) && $attr['coupon_id']==$coupon->id){ ?>selected<?php } ?>><?php echo stripslashes($coupon->code); ?></option>
            <?php } ?>
        </select>
    </div>

    
    <div class="col-xs-2">
        <input type="file" name="attributes[image][]" class="form-control" />
    </div>


    <div class="col-xs-1">
        <?php if (isset($showRemove) && $showRemove): ?>
            <button type="button" class="btn btn-danger btn-remove-attribute"><i class="fa fa-minus"></i></button>
        <?php else: ?>
            <button type="button" class="btn btn-success btn-add-attribute"><i class="fa fa-plus"></i></button>
        <?php endif; ?>
    </div>
</div>
