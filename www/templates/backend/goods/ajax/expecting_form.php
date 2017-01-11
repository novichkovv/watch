<div style="overflow-x: auto">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>N</th>
            <th>Код</th>
            <th>Артикул</th>
            <th>Номенклатура</th>
            <th>Количество, шт</th>
            <th>Закупочная стоимость, руб.</th>
            <th>Цена продажи</th>
            <th>Сумма,</th>
            <th>Ставка НДС,%</th>
            <th>Сумма НДС, руб.</th>
            <th>Всего</th>
            <th></th>
        </tr>
        </thead>
        <tbody id="expecting_tbody"></tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-6">
        <label>Товар</label>
        <select class="form-control" name="expecting[good_id]">
            <option value=""></option>
            <?php foreach ($goods as $good): ?>
                <option value="<?php echo $good['id']; ?>"><?php echo $good['good_name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2">
        <label>Количество</label>
        <input type="text" name="expecting[quantity]" class="form-control" value="">
    </div>
    <div class="col-md-2">
        <label>Цена</label>
        <input type="text" name="expecting[price]" class="form-control" value="">
    </div>
    <div class="col-md-2">
        <br>
        <button class="btn red outline" type="button" id="add_expecting_row"><i class="fa fa-plus"></i> </button>
    </div>
</div>

