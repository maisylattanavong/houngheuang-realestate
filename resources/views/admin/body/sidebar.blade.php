<div class="vertical-menu">
    @php
        $id = Auth::user()->id;
        $userId = App\Models\User::find($id);
        $role = $userId->role;

        $content = App\Models\Guide::latest()->first();
        // dd($content);
    @endphp
    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">@lang('backend.menu')</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i><span class="badge rounded-pill bg-success float-end">4</span>
                        <span>@lang('backend.dashboard')</span>
                    </a>
                </li>
                <!--Post Menu -->
                {{-- @if (Auth::user()->can('post.menu'))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="far fa-clipboard"></i>
                            <span>@lang('backend.posts')</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">

                            @if (Auth::user()->can('post.list'))
                                <li><a href="{{ route('post') }}">@lang('backend.all_posts')</a></li>
                            @endif
                            @if (Auth::user()->can('post.add'))
                                <li><a href="{{ route('create.post') }}">@lang('backend.add_post')</a></li>
                            @endif

                            @if (Auth::user()->can('category.menu'))
                                <li><a href="{{ route('category') }}">@lang('backend.categories')</a></li>
                            @endif
                            @if (Auth::user()->can('tag.menu'))
                                <li><a href="{{ route('tag') }}">@lang('backend.tag')</a></li>
                            @endif
                        </ul>
                    </li>
                @endif --}}

                <!--Real Estate Menu -->
                @if (Auth::user()->can('property.menu'))

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fa-solid fa-house"></i>
                            <span>@lang('backend.real_estate')</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">

                            @if (Auth::user()->can('property.list'))
                                <li><a href="{{ route('realestate') }}">@lang('backend.all_real_estate')</a></li>
                            @endif
                            @if (Auth::user()->can('property.add'))
                                <li><a href="{{ route('create.real.estate') }}">@lang('backend.add_real_estate')</a></li>
                            @endif
                            @if (Auth::user()->can('category.menu'))
                                <li><a href="{{ route('category') }}">@lang('backend.categories')</a></li>
                            @endif
                            @if (Auth::user()->can('tag.menu'))
                                <li><a href="{{ route('tag') }}">@lang('backend.tag')</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- dev edit  --}}
                @if (Auth::user()->can('media.menu'))
                    <li>
                        <a href="{{ url('/en/admin/media') }}" class="waves-effect" target="_blank">
                            <i class="fa-solid fa-image"></i>
                            <span>@lang('backend.media')</span>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->can('siteSetting.menu'))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-cogs"></i>
                            <span>@lang('backend.site_settings')</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (Auth::user()->can('siteInfo.menu'))
                                <li><a href="{{ route('index.company') }}">@lang('backend.site_information')</a></li>
                            @endif
                            @if (Auth::user()->can('guide.menu'))
                                <li><a href="{{ is_null($content) ? route('guide.index'):route('guide.edit') }}">@lang('frontend.guide')</a></li>
                            @endif
                            {{-- @if (Auth::user()->can('bannerSlide.menu'))
                                <li><a href="{{ route('banner.index') }}">@lang('backend.banner_slider')</a></li>
                            @endif --}}
                            @if (Auth::user()->can('socialMedia.menu'))
                                <li><a href="{{ route('index.social') }}">@lang('backend.social_media')</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-user-cog"></i>
                        <span>Permission Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#">All permission</a></li>
                        <li><a href="#">Create permision</a></li>
                    </ul>
                </li>
                 --}}

                @if (Auth::user()->can('userManage.menu'))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-users"></i>
                            <span>@lang('backend.user_management')</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (Auth::user()->can('user.list'))
                                <li><a href="{{ route('all.admin') }}">@lang('backend.all_users')</a></li>
                            @endif
                            @if (Auth::user()->can('user.add'))
                                <li><a href="{{ route('add.admin') }}">@lang('backend.add_user')</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                {{-- @if (Auth::user()->can('permission.menu'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-user-cog"></i>
                        <span>Permission Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if (Auth::user()->can('permission.list'))
                        <li><a href="{{route('all.permission')}}">All permission</a></li>
                        @endif
                        @if (Auth::user()->can('permission.add'))
                        <li><a href="{{route('add.permission')}}">Add permision</a></li>
                        @endif
                    </ul>
                </li>
                @endif --}}

                @if (Auth::user()->can('role.menu'))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-tasks"></i>
                            <span>@lang('backend.role_permission_settings')</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (Auth::user()->can('role.list'))
                                <li><a href="{{ route('all.roles') }}">@lang('backend.all_roles')</a></li>
                            @endif
                            @if (Auth::user()->can('role.add'))
                                <li><a href="{{ route('add.roles') }}">@lang('backend.add_role')</a></li>
                            @endif

                            {{-- @if (Auth::user()->can('role.permission.add'))
                        <li><a href="{{route('add.roles.permission')}}">Add Permission to Role</a></li>
                        @endif --}}
                            @if (Auth::user()->can('role.permission.list'))
                                <li><a href="{{ route('all.roles.permission') }}">@lang('backend.assign_permission_role')</a></li>
                            @endif
                        </ul>
                    </li>
                @endif


            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
