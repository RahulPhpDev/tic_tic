<div>
    <form method="post" wire:submit.prevent="saveContact">

    @foreach ($inputs as $roundKey => $round)

        <div class="panel panel-default">
        <div class ="panel-heading"> <h5> {{$round}} Music </h5></div>
            <div class="panel-body">
                <div class="col-sm-12 col-xs-12">
                    <div class="col-xs-6 form-group">
                        {!! Form::label('name', trans('tictic/music/fields.title').'', ['class' => 'control-label']) !!}

                    <input type ="text" wire:model.defer ="name.{{$roundKey}}" class="form-control"/>
                        <p class="help-block"></p>
                        {{-- @error('email.'.$value) --}}
                        @if($errors->has('name.'.$round) )
                            <p class="help-block">
                                {{ $errors->first('name.'.$roundKey) }}
                            </p>
                        @endif
                    </div>

                    <div class="col-xs-6 form-group">
                        {!! Form::label('section', trans('tictic/music/fields.section').'', ['class' => 'control-label']) !!}

                        <select class="form-control" wire:model.defer="section_id.{{$roundKey}}">
                        <option>Select Section</option>
                           @foreach($sections as $key => $value)
                               <option value ={{$key}}> {{$value}}</option>
                            @endforeach
                        </select>
                        <p class="help-block"></p>
                        @if($errors->has('section_id.'.$roundKey))
                            <p class="help-block">
                                {{ $errors->first('section_id.'.$roundKey) }}
                            </p>
                        @endif
                    </div>

                    <div class="col-xs-6 form-group">
                        {!! Form::label('description', trans('tictic/music/fields.description').'', ['class' => 'control-label']) !!}
                        <textarea class="form-control" wire:model.defer="description.{{$roundKey}}">{{old('description')}}</textarea>
                        <p class="help-block"></p>
                        @if($errors->has('description.'.$roundKey))
                            <p class="help-block">
                                {{ $errors->first('description.'.$roundKey) }}
                            </p>
                        @endif
                    </div>

                    <div class="col-xs-6 form-group">
                        {!! Form::label('file', trans('tictic/music/fields.upload').'', ['class' => 'control-label']) !!}
                        <input type="file" wire:model.defer="file.{{$roundKey}}">
                        <p class="help-block"></p>
                        @if($errors->has('file.'.$roundKey))
                            <p class="help-block">
                                {{ $errors->first('file.'.$roundKey) }}
                            </p>
                        @endif
                    </div>
            </div>
            @if (! $loop->first )
            <div  class="float-right" style="float: right;margin:0px 20px 20px 0px">
                <button wire:click="remove({{$roundKey}})" type = "button" class=" btn-xs btn-danger">Remove</button>
            </div>
        </div>

      @endif
    </div>
        @endforeach

@if ($round < 5)
    <div  class="float-right" style="float: right;margin:0px 20px 20px 0px">
        <button wire:click="addMore({{$round}})" type = "button" class=" btn-sm btn-primary"> Add More</button>
    </div>
@endif
<div style="float:none"></div>



        <button type="submit" class="btn btn-primary">Save</button>

    </form>
{{--</div>--}}

