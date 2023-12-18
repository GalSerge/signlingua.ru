@foreach($items as $item)
    <div class="div-table-row">
        <div class="div-table-cell cell-1">
            <span @if($field_active != null && !$item[$field_active])style="color: darkgray;" @endif>
                {{ $item[$field_label] }}
            </span>
        </div>
        <div class="div-table-cell cell-2">
            <a class="btn" href="{{ route($resource.'.edit', $item['id']) }}">Редактировать</a>
        </div>
        @if(Route::has($resource.'.destroy'))
            <div class="div-table-cell cell-3">
                <button type="button" onclick="confirmDelete('{{ $item['id'] }}')" class="btn btn-secondry" data-toggle="modal" data-target="#confirmDelete">Удалить</button>
            </div>
        @endif
    </div>
@endforeach

<div id="confirmDelete" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Звонки</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Вы уверены, что хотите удалить запись?</p>
            </div>
            <div class="modal-footer">
                <form id="confirmFormModal" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondry">Удалить</button>
                </form><br>
                <button type="button" class="btn" data-dismiss="modal">Закрыть</button>
            </div>
        </div>

    </div>
</div>

<script>
    function confirmDelete(id)
    {
        document.getElementById('confirmFormModal').action = '{{ route($resource.'.index') }}/' + id;
    }
</script>