<?php
    $isHolder = Session::get('IS_HOLDER');
    $shipList = Session::get('shipList');
?>

<div class="row">
    <div class="space-4"></div>
    <div class="col-md-12">
        <textarea class="form-control" name="Remarks" style="resize: none;" rows="20">{{ isset($shipInfo['Remarks']) ? $shipInfo['Remarks'] : '' }}</textarea>
    </div>
</div>
