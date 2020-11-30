

<div wire:ignore.self id="updateModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Edit Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Name</label>
                        <input type="text" id="exampleFormControlInput1" class="form-control"  placeholder="Enter First Name" wire:model="description" />
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('section', trans('tictic/music/fields.section').'', ['class' => 'control-label']) !!}

                        <select name="section" class="form-control" wire:model="section_id">
                        <option>Select Section</option>
                           @foreach($sections as $key => $value)
                               <option value ={{$key}}> {{$value}}</option>
                            @endforeach
                        </select>
                        <p class="help-block"></p>
                        @if($errors->has('section_id'))
                            <p class="help-block">
                                {{ $errors->first('section_id') }}
                            </p>
                        @endif
                    </div>
                </div>
                  

                  <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('music', trans('tictic/music/fields.section').'', ['class' => 'control-label']) !!}

                        <select name="music_id" class="form-control" wire:model="music_id">
                        <option>Select Music</option>
                           @foreach($musics as $key => $value)
                               <option value ={{$key}}> {{$value}}</option>
                            @endforeach
                        </select>
                        <p class="help-block"></p>
                        @if($errors->has('music_id'))
                            <p class="help-block">
                                {{ $errors->first('music_id') }}
                            </p>
                        @endif
                    </div>
                </div>



                 
                    <button wire:click.prevent="update()"  wire:loading.attr="disabled"
                     class="btn btn-success {{$this->disableBtn ? 'disableBtn' : 'non-disable'}}"
                     >Update</button>
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                </form>

            </div>
        </div>
    </div>
</div>