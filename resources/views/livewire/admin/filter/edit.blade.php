
<div wire:ignore.self id="updateModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Edit Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form >
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Name</label>
                        <input type="text" id="exampleFormControlInput1" class="form-control"  placeholder="Name" wire:model.defer="name" />
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('cat_id','Category Id', ['class' => 'control-label']) !!}

                            <select class="form-control" wire:model.defer="cat_id">
                        <option>Select Category</option>

                               @foreach($categories  as $key => $value)
                               <option value ={{$key}}> {{$value}}</option>
                               @endforeach
                          </select>
                            <p class="help-block"></p>
                            @if($errors->has('cat_id'))
                                <p class="help-block">
                                    {{ $errors->first('cat_id') }}
                                </p>
                            @endif
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="comment" class="p-r-mute">Description</label>
                        <textarea id="comment" wire:model.defer="description" class="form-control" placeholder="type.." rows="4"></textarea>
                        @error('description')<span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('file','Thumbnail', ['class' => 'control-label']) !!}
                            <input type="file" wire:model.defer="thumb">
                            <p class="help-block"></p>
                            @if($errors->has('thumb'))
                                <p class="help-block">
                                    {{ $errors->first('thumb') }}
                                </p>
                            @endif
                        </div>
                    </div> --}}

                    <button type = "submit" wire:click.prevent="update()"  wire:loading.attr="disabled"
                     class="btn btn-success {{$this->disableBtn ? 'disableBtn' : 'non-disable'}}"
                     >Save</button>
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
