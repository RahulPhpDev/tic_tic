
<x-button.create/>
<div wire:ignore.self id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <x-modal.create title="Category"/>
            <div class="modal-body">
                <form >
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Name</label>
                        <input type="text" id="exampleFormControlInput1" class="form-control"  placeholder="Name" wire:model.defer="title" />
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <button type = "submit" wire:click.prevent="store()"  wire:loading.attr="disabled"
                     class="btn btn-success {{$this->disableBtn ? 'disableBtn' : 'non-disable'}}"
                     >Save</button>
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
