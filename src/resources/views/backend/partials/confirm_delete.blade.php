<div class="modal modal-warning fade" id="modal-delete" tabIndex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Please Confirm</h4>
            </div>
            <div class="modal-body">
                <p class="">
                    <i class="fa fa-question-circle"></i>
                    Are you sure you want to delete this {{ $item }}?
                </p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route($module.'.destroy', ['id' => $data->$field_id]) }}" id='confirmDelete'>
                    {{ csrf_field() }}
                    <!--<input type="hidden" name="_method" value="DELETE">-->
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-outline">
                        <i class="fa fa-check-square"></i> Yes
                    </button>
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

