<div class="panel-body table-responsive">
@include('livewire/message/message')
@include('livewire/admin/user.create')
@include('livewire/admin/user.detail')
@include('livewire/admin/user.counts')
@include('livewire/admin/user.edit')

    <table class="table table-bordered table-striped ">
        <thead>
        <tr>
            <th>{{trans('tictic/user/fields.list.id')}}</th>
            <th> FB Id</th>
            <th>{{trans('tictic/user/fields.list.name')}}</th>
            <th>{{trans('tictic/user/fields.list.email')}}</th>
            <th> Details </th>
            <th>{{trans('tictic/user/fields.list.delete')}}</th>

        </tr>
        </thead>

        <tbody>
        @foreach ($users as $user)

            <tr >
                <td> {{$user->id}} </td>
                <td field-key='name'>{{ $user->fullName }}</td>
                <td field-key='name'>{{ $user->fb_id }}</td>
                <td field-key='description'>{!! $user->email !!}</td>
                <td field-key='created_by'>{!! $user->gender !!} </td>
                <td field-key='created_by'>
                    <button wire:click ="detail({{$user->id}})" class="btn btn-xs btn-primary btn-outline-danger py-0" data-toggle="modal" data-target = "#detailsModal" > Details</button>
                 </td>
                    <td>
                            <button wire:click="edit({{$user->id}})" class="btn btn-xs btn-primary btn-outline-danger py-0" data-toggle="modal" data-target="#updateModal">
                                {{trans('tictic/music/fields.list.edit')}}
                            </button>
                     <button wire:click ="destroy({{$user->id}})" class="btn btn-xs btn-danger btn-outline-danger py-0" > Delete</button>
                    </td>

            </tr>
        @endforeach
        </tbody>
    </table>
    <div>{{$users->links()}} </div>
</div>
