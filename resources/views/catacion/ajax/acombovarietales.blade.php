<div class="form-group">
  <label class="col-sm-3 control-label">Varietales :</label>
  <div class="col-sm-6">
    {!! Form::select( 'varietal_id', $combo_varietales_especies, array(),
                      [
                        'class'       => 'form-control control input-sm' ,
                        'id'          => 'varietal_id',
                        'required'    => ''
                      ]) !!}
  </div>
</div>