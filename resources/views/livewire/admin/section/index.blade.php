<div class="panel-body table-responsive">
@include('livewire/message/message')
@include('livewire/admin/section.create')
@include('livewire/admin/section.edit')

    <table class="table table-bordered table-striped ">
        <thead>
        <tr>
            <th>{{trans('tictic/user/fields.list.id')}}</th>
            <th>{{trans('tictic/user/fields.list.name')}}</th>
            <th>{{trans('tictic/user/fields.list.delete')}}</th>

        </tr>
        </thead>

        <tbody>
        @foreach ($sections as $res)

            <tr >
                <td> {{$res->id}} </td>
                <td field-key='name'>{{ $res->name }}</td>
                    <td>
                        <button data-toggle="modal" data-target="#updateModal" class="btn btn-primary btn-xs" wire:click="edit({{ $res->id }})">Edit</button>

                     <button wire:click ="destroy({{$res->id}})" class="btn btn-xs btn-danger btn-outline-danger py-0" > Delete</button>
                    </td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>
