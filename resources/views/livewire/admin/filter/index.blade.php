<div class="panel-body table-responsive">
    @include('livewire/message/message')
    @include('livewire/admin/filter.create')
    @include('livewire/admin/filter.edit')
    @include('livewire/admin/filter.image')

    <table class="table table-bordered table-striped ">
        <thead>
        <tr>
            <th> Id</th>
            <th> Name </th>
            <th> Category </th>
            <th> Description </th>
            <th> Thumb</th>
            <th> File </th>
            <th> Action </th>

        </tr>
        </thead>

        <tbody>
        @foreach ($filters as $filter)

            <tr >
                <td> {{$filter->id}} </td>
                <td field-key='name'>{{ $filter->name }}</td>
                <td field-key='name'>{{ optional($filter->category)->title ?? 'not found' }}</td>

                <td field-key='name'>{{ $filter->description }}</td>
                {{-- src = "{{$this->detail->gif}}" --}}
                <td field-key='thumb'> <img src="{{ $filter->thumb}}" width="200" /></td>
                <td field-key='image'> <img src="{{ $filter->file}}" width="200" /></td>

                    <td>
                     <button data-toggle="modal" data-target="#updateModal" class="btn btn-primary btn-xs" wire:click="edit({{ $filter->id }})">Edit</button>
                     <button  class="btn btn-xs btn-danger btn-outline-danger py-0"  onclick="confirm('Are you sure you want to delete the filter?') || event.stopImmediatePropagation()" wire:click ="delete({{ $filter->id }})"> Delete</button>

                     <button wire:click="photoPreview({{ $filter->id }}, 'thumb')" style ="display:block!important;margin-top:10px"   data-toggle="modal" class="btn btn-xs btn-success btn-outline-danger py-0" data-target="#imageModal"> Edit/Delete Thumb</button>

                     <button wire:click="photoPreview({{ $filter->id }}, 'file')"  data-toggle="modal"  data-target="#imageModal" class="btn btn-xs btn-danger btn-outline-danger py-0" > Edit/Delete File </button>
                    </td>

            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="paginate">{{ $filters->links() }}</div>
</div>


{{--

    <table class="table table-bordered table-striped ">
        <thead>
        <tr>
            <th> Id</th>
            <th> Name </th>
            <th> Description </th>
            <th> Thumb</th>
            <th> Action </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($filters as $filter)
            <tr>
                <td> {{$filter->id}} </td>
                <td field-key='name'>{{ $filter->name }}</td>
                <td field-key='description'>{{ $filter->description }}</td>
                <td><img src = ""/></td>
                    <td>
                        <button data-toggle="modal" data-target="#updateModal" class="btn btn-primary btn-xs" wire:click="edit({{ $filter->id }})">Edit</button>

                     <button wire:click ="destroy({{$filter->id}})" class="btn btn-xs btn-danger btn-outline-danger py-0" > Delete</button>
                    </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="paginate">{{ $filters->links() }}</div>
    </div> --}}
