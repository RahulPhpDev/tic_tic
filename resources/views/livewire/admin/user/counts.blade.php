<div wire:ignore.self id="countModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">{{$this->countType}} Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
        @if($this->countType)
            <div class="modal-body">
                <table class="table table-bordered table-striped ">

                    <tr>
                        <th>Email</th>
                        <td>{{$this->detail->email}}</td>
                    </tr>
                </table>
                    @foreach($this->detail->{$this->countType} as $follow)
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-striped ">
                                <tr>
                                    <th>Name</th>
                                    <td>{{$follow->fullName}}</td>
                                </tr>
                                <tr>
                                    <th>Fb Id</th>
                                    <td>{{$follow->fb_id}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @endForeach



                </table>

            </div>

            @endif
        </div>
    </div>

</div>
