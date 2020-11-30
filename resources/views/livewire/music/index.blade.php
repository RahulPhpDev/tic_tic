<div class="panel-body table-responsive">
@if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <table class="table table-bordered table-striped ">
        <thead>
        <tr>
            <th>{{trans('tictic/music/fields.list.id')}}</th>
            <th>{{trans('tictic/music/fields.list.name')}}</th>
            <th>{{trans('tictic/music/fields.list.description')}}</th>
            <th>{{trans('tictic/music/fields.list.section')}}</th>
            <th>Music</th>
            <th>{{trans('tictic/music/fields.list.delete')}}</th>

        </tr>
        </thead>

        <tbody>


        @foreach ($musics as $music)

            <tr >
                <td> {{$music->id}} </td>
                <td field-key='name'>{{ $music->name }}</td>
                <td field-key='description'>{!! $music->description !!}</td>
                <td field-key='created_by'>{!! optional($music->section)->name ?? 'Not Found'  !!} </td>
                <td field-key='created_by'>
                    <audio controls>
                        <source src = {{ Storage::url("/$music->mp3") }} type="audio/ogg">
                        <source src = {{ Storage::url("/$music->aac")  }} type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </td>
                    <td>
                            {{-- <a href="{{ route('admin.music.edit',[$music->id]) }}" class="btn btn-xs btn-primary">
                                {{trans('tictic/music/fields.list.edit')}}
                            </a> --}}
                     <button wire:click ="destroy({{$music->id}})" class="btn btn-sm btn-danger btn-outline-danger py-0" > Delete</button>
                    </td>

            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="paginate">{{ $musics->links() }}</div>
</div>
