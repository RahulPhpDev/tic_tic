<div wire:ignore.self id="detailsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">User Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
        @if($this->user_id)
            <div class="modal-body">
                <table class="table table-bordered table-striped ">
                    <tr>
                        <th>Name</th>
                        <td>{{$this->detail->fullName}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$this->detail->email}}</td>
                    </tr>
                    <tr>
                        <th>fb_id</th>
                        <td>{{$this->detail->fb_id}}</td>
                    </tr>
                    <tr>
                        <th>Follower</th>
                           <td>
                            <button wire:click ="counts('follower')" @if($this->detail->followers_count == 0) disabled @endif class="btn btn-xs btn-primary btn-outline-danger py-0" data-toggle="modal" data-target = "#countModal" >
                                {{$this->detail->followers_count}}
                            </button>

                          </td>
                    </tr>
                    <tr>
                        <th>Follow</th>
                        <td>
                            <button wire:click ="counts('follow')" @if($this->detail->follow_count == 0) disabled @endif class="btn btn-xs btn-primary btn-outline-danger py-0" data-toggle="modal" data-target = "#countModal" > {{$this->detail->follow_count}}</button>

                        </td>
                    </tr>
                    <tr>
                        <th>Videos</th>
                        <td>
                            {{$this->detail->video_count}}
                        </td>
                    </tr>

                </table>

            </div>

            @endif
        </div>
    </div>

</div>
