<form method="post" id="product_modal_form" class="form-horizontal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Товар <?php echo $product['product_name']; ?></h4>
    </div>
    <div class="modal-body with-padding">
        <div class="portlet light bproducted">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <i class="icon-settings font-red-sunglo"></i>
                    <span class="caption-subject bold uppercase"> Информация о Товаре</span>
                </div>
                <div class="actions">
                </div>
            </div>
            <div class="portlet-body">
                <div class="form-group">
                    <label class="control-label col-md-4">Название Товара</label>
                    <div class="col-md-6">
                        <input type="text" name="product[product_name]" class="form-control" value="<?php echo $product['product_name']; ?>">
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="form-group">
                    <label class="control-label col-md-4">Url Товара</label>
                    <div class="col-md-6">
                        <input type="text" name="product[product_key]" class="form-control" value="<?php echo $product['product_key']; ?>">
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="form-group">
                    <label class="control-label col-md-4">Ключ Лендинга</label>
                    <div class="col-md-6">
                        <input type="text" name="product[landing_key]" class="form-control" value="<?php echo $product['landing_key']; ?>">
                    </div>
                </div>
            </div>
<!--            <div class="portlet-body">-->
<!--                <div class="form-group">-->
<!--                    <label class="control-label col-md-4">Товары</label>-->
<!--                    <div class="col-md-6">-->
<!--                        <select name="product[goods][]" class="form-control select2me" multiple>-->
<!--                            --><?php //foreach ($goods as $good): ?>
<!--                                <option value="--><?php //echo $good['id']; ?><!--"-->
<!--                                --><?php //if ($product['goods'][$good['id']] == $good['id']): ?>
<!--                                    selected-->
<!--                                --><?php //endif; ?><!-->-->
<!--                                    --><?php //echo $good['good_name']; ?>
<!--                                </option>-->
<!--                            --><?php //endforeach; ?>
<!--                        </select>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            <div class="portlet-body">
                <div class="form-group">
                    <label class="control-label col-md-4">Ключ Лендинга 2</label>
                    <div class="col-md-6">
                        <input type="text" name="product[success_landing_key]" class="form-control" value="<?php echo $product['success_landing_key']; ?>">
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="form-group">
                    <label class="control-label col-md-4">Cross Товар</label>
                    <div class="col-md-6">
                        <select name="product[cross_product_id]" class="form-control">
                            <option value=""></option>
                            <?php if ($products): ?>
                                <?php foreach ($products as $p): ?>
                                    <option value="<?php echo $p['id']; ?>"
                                        <?php if ($p['id'] == $product['cross_product_id']) echo ' selected' ?>
                                        >
                                        <?php echo $p['product_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="form-group">
                    <label class="control-label col-md-4">ID товара в партнерке</label>
                    <div class="col-md-6">
                        <input type="text" name="product[affiliate_id]" class="form-control" value="<?php echo $product['affiliate_id']; ?>">
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="form-group">
                    <label class="control-label col-md-4">Webmaster ID</label>
                    <div class="col-md-6">
                        <input type="text" name="product[webmaster_id]" class="form-control" value="<?php echo $product['webmaster_id']; ?>">
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="form-group">
                    <label class="control-label col-md-4">Цена</label>
                    <div class="col-md-6">
                        <input type="text" name="product[price]" class="form-control" value="<?php echo $product['price']; ?>">
                    </div>
                </div>
            </div>
<!--            <div class="portlet-body">-->
<!--                <div class="form-group">-->
<!--                    <label class="control-label col-md-4">Название Товара</label>-->
<!--                    <div class="col-md-6">-->
<!--                        <input type="text" name="product[product_name]" class="form-control" value="--><?php //echo $product['product_name']; ?><!--">-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="portlet-body">-->
<!--                <div class="form-group">-->
<!--                    <label class="control-label col-md-4">Название Товара</label>-->
<!--                    <div class="col-md-6">-->
<!--                        <input type="text" name="product[product_name]" class="form-control" value="--><?php //echo $product['product_name']; ?><!--">-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
    </div>
    <?php if (isset($product['id'])): ?>
        <input type="hidden" name="product[id]" value="<?php echo $product['id']; ?>">
    <?php endif; ?>
</form>
<script type="text/javascript">
    $ = jQuery.noConflict();
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>