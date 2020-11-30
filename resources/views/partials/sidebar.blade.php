@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">


            <li class="{{ $request->segment(1) == 'home' ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title"> {{ trans('tictic/title.title') }}</span>
                </a>
            </li>


             <li class="">
                <a href="{{route('admin.user.index')}}">
                    <i class="fa fa-user"></i>
                    <span class="title">
                     @lang('adminMenu.user')
                    </span>
                </a>
            </li>

             <li class="">
                <a href="{{route('admin.section')}}">
                    <i class="fa fa-cart-plus"></i>
                    <span class="title">
                     @lang('adminMenu.section')
                    </span>
                </a>
            </li>

            <li class="">
                <a href="{{route('admin.video')}}">
                    <i class="fa fa-video-camera"></i>
                    <span class="title">
                      {{ trans('tictic/title.video') }}
                    </span>
                </a>
            </li>


            <li class="">
                <a href="{{route('admin.music.index')}}">
                    <i class="fa fa-music"></i>
                    <span class="title">
                     @lang('adminMenu.music')
                    </span>
                </a>
            </li>

            <li class="">
                <a href="{{route('admin.category')}}">
                    <i class="fa fa-filter"></i>
                    <span class="title">
                     Category
                    </span>
                </a>
            </li>

            <li class="">
                <a href="{{route('admin.filter')}}">
                    <i class="fa fa-filter"></i>
                    <span class="title">
                     @lang('adminMenu.filter')
                    </span>
                </a>
            </li>

            <li class="">
                <a href="{{route('logout')}}">
                    <i class="fa fa-sign-out"></i>
                    <span class="title">
                     @lang('adminMenu.signOut')
                    </span>
                </a>
            </li>

        </ul>
    </section>
</aside>

