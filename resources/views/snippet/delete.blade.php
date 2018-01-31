{{--@include('snippet.delete', ['id' => $assignment->camperid . '-' . $assignment->staffpositionid])--}}
<div class="mb-1 btn-group" data-toggle="buttons">
    <label class="btn btn-primary">
        <input type="checkbox" name="{{ $id }}-delete" autocomplete="off"/> Delete
    </label>
</div>