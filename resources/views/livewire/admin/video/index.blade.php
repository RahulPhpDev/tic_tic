<div class="panel-body table-responsive">
@include('livewire/message/message')
@include('livewire/admin/video.create')
@include('livewire/admin/video.edit')
@include('livewire/admin/video.details')

    <table class="table table-bordered table-striped ">
        <thead>
        <tr>
            <th>{{trans('tictic/video/fields.list.id')}}</th>
            <th>{{trans('tictic/video/fields.list.name')}}</th>
            <th>{{trans('tictic/video/fields.list.music')}}</th>
            <th>{{trans('tictic/video/fields.list.section')}}</th>
            <th> Details </th>
            <th>{{trans('tictic/video/fields.list.delete')}}</th>

        </tr>
        </thead>

        <tbody>
        @foreach ($videos as $video)

            <tr >
                <td> {{$video->id}} </td>
                <td field-key='name'>{{ $video->description }}</td>

                <td field-key='music'>{{ optional($video->music)->name ??' Not Found '}}</td>
                <td field-key='section'>{{ optional($video->section)->name ?? 'not found' }}</td>
                <td> <button data-toggle="modal" data-target ="#detailsModal"  class="btn btn-primary btn-xs" wire:click="details({{ $video->id }})">Details</button> </td>
                    <td>
                     <button data-toggle="modal" data-target="#updateModal" class="btn btn-primary btn-xs" wire:click="edit({{ $video->id }})">Edit</button>
                     <button  class="btn btn-xs btn-danger btn-outline-danger py-0"  onclick="confirm('Are you sure you want to delete the video?') || event.stopImmediatePropagation()" wire:click ="delete({{ $video->id }})"> Delete</button>
                    </td>

            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="paginate">{{ $videos->links() }}</div>
</div>

