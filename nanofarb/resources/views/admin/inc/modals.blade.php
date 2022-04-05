<div class="modal fade" id="modal-edit-values">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Редактировать значение атрибута</h4>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label>Значение</label>
                        <input type="text" name="value" class="form-control" autocomplete="off" required placeholder="Пример: Красный">
                    </div>
                    <div class="form-group">
                        <label>Суффикс значения</label>
                        <input type="text" name="suffix" class="form-control" autocomplete="off" placeholder="Пример: см">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-menu">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Редактировать название</h4>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label>Название</label>
                        <input type="text" class="form-control" name="name" autocomplete="off" required placeholder="Пример: Какое-то название">
                    </div>
                    {{--
                    <div class="checkbox">
                        <label>
                            <input type="hidden" name="publish" value="0">
                            <input name="publish" type="checkbox" value="1" style="cursor:pointer;">
                            Публиковать
                        </label>
                    </div>
                    --}}
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-attributes">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Редактировать атрибут</h4>
            </div>
            <div class="modal-body">
                <form action="#" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label>Название атрибута</label>
                        <input type="text" name="title" class="form-control" autocomplete="off" required placeholder="Пример: Длина">
                    </div>
                    <div class="form-group">
                        <label>Суффикс значений атрибута</label>
                        <input type="text" name="suffix" class="form-control" autocomplete="off" placeholder="Пример: см">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</div>