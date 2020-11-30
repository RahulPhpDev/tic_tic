
<div wire:ignore.self id="imageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Edit {{$type}} Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form >
                    
                   @if(@photo && $this->filter_photo_id)
                        Photo Preview: 
                        <img src={{$photo}} width="200" />
                        @endif
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('file','Thumbnail', ['class' => 'control-label']) !!}
                            {{-- wire:model.defer="image" --}}
                            <input type="file" wire:model.defer="{{$type}}">
                            <p class="help-block"></p>
                            @if($errors->has('thumb'))
                                <p class="help-block">
                                    {{ $errors->first('thumb') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <button type = "submit" wire:click.prevent="updateImage()"  wire:loading.attr="disabled"
                     class="btn btn-success {{$this->disableBtn ? 'disableBtn' : 'non-disable'}}"
                     >Update</button>


                     {{-- wire:click="photoPreview({{ $filter->id }}, 'file')" --}}
                    <button type = "submit" wire:click.prevent="deleteImage()"  wire:loading.attr="disabled"
                    class="btn btn-success btn-danger {{$this->disableBtn ? 'disableBtn' : 'non-disable'}}"
                    >Delete Image</button>
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
