<div class="panel-body table-responsive">
    @include('livewire/message/message')
    @include('livewire/admin/category.create')
    @include('livewire/admin/category.edit')

    <table class="table table-bordered table-striped ">
        <thead>
        <tr>
            <th> Id</th>
            <th> Name </th>
            <th> Filter </th>
            <th> Action </th>

        </tr>
        </thead>

        <tbody>
        @foreach ($categories as $category)

            <tr >
                <td> {{$category->id}} </td>
                <td field-key='name'>{{ $category->title }}</td>
                <td field-key='name'>
                    @if($category->filter_count  > 0)
                   {{ $category->filter_count}}
                    @else
                   {{ $category->filter_count}}
                        <a href = {{route('admin.filter')}} >Add Filter </a>
                    @endIf
                </td>
                    <td>
                     <button data-toggle="modal" data-target="#updateModal" class="btn btn-primary btn-xs" wire:click="edit({{ $category->id }})">Edit</button>
                     <button  class="btn btn-xs btn-danger btn-outline-danger py-0"  onclick="confirm('Are you sure you want to delete the category?') || event.stopImmediatePropagation()" wire:click ="delete({{ $category->id }})"> Delete</button>
                    </td>

            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="paginate">{{ $categories->links() }}</div>
</div>
