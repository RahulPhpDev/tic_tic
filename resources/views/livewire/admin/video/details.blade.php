<div wire:ignore.self id="detailsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Video Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
        @if($this->video_id)
            <div class="modal-body">
                <table class="table table-bordered table-striped ">
                    <tr>
                        <th>Name</th>
                        <td>{{$this->detail->description}}</td>
                    </tr>
                    <tr>
                        <th>Music</th>
                        <td>{{optional($this->detail->music)->name ?? 'not found'}}</td>
                    </tr>
                    <tr>
                        <th>Section</th>
                        <td>{{optional($this->detail->section)->name ?? 'not found'}}</td>
                    </tr>
                    <tr>
                        <th>Gif</th>
                        <td>
                            <img src = "{{$this->detail->gif}}"  class="center img-thumbnail img-rounded" width="50%"/>
                        </td>
                    </tr>
                    <tr>
                        <th>Thumb</th>
                        <td>
                            {{-- {{ "/$music->aac") --}}
                            <img src = "{{$this->detail->thum}}"  class="center img-thumbnail img-rounded" width="50%"/>
                        </td>
                    </tr>
                    <tr>
                        <th>Video</th>
                        <td>
                            <video width="320" height="240" key="{{$this->detail->video}}" id ="myVideo" controls>
                                <source id ="mp4_src" src="{{$this->detail->video}}" type="video/mp4"/>
                                <source id ="ogg_src"  src="{{$this->detail->video}}" type="video/ogg" />
                                Your browser does not support the video tag.
                              </video>
                        </td>
                    </tr>

                </table>

            </div>

            @endif
        </div>
    </div>

</div>

