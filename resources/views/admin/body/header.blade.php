<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            @php
                $aboutCompany = App\Models\Company::first();
            @endphp
            <div class="navbar-brand-box mt-2">
                {{-- <a href="{{ route('dashboard') }}">
                    <img src="{{ asset($aboutCompany->logo) }}" style="height: 55px" alt="">
                </a> --}}

                @if (!is_null($aboutCompany))
                    <a href="{{ route('dashboard') }}"><img src="{{ asset($aboutCompany->logo) }}" alt=""
                            style="height: 55px;"></a>
                @else
                    <img src="{{ asset('upload/no_image.jpg') }}" alt="Realestate" style="height: 55px;">
                @endif
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="ri-search-line"></span>
                </div>
            </form>
        </div>

        <div class="d-flex" style="dispaly:flex; align-items:center;justify-content:left">

            <!-- Select Language-->
            <div class="d-lg-inline-block mb-4 mt-4">
                <li class="dropdown" style="list-style-type:none;">
                    <a href="#" class="nav-link" id="navbarDropdownMenuLink" data-toggle="dropdown"
                        style="color: white">
                        @php
                            $lang = App::getLocale();
                        @endphp

                        <span
                            class="{{ $lang == 'en' ? 'fi fi-us' : ($lang == 'la' ? 'fi fi-la' : 'fi fi-cn') }}"></span>
                        {{ $lang == 'en' ? 'English' : ($lang == 'la' ? 'ລາວ' : '中国人') }}
                        <i class="fas fa-caret-down"></i>
                    </a>
                    <div class="dropdown-menu justify-between" aria-labelledby="dropdownMenuButton"
                        style="width: 190px">
                        @foreach (config('app.available_locales') as $locale)
                            <a class="btn-sm"
                                href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => $locale])) }}">
                                @if ($lang == 'en')
                                    @if ($locale == 'cn')
                                        <span class="fi fi-cn"></span><span> 中国人</span>
                                    @endif
                                    @if ($locale == 'la')
                                        <span class="fi fi-la"></span><span> ລາວ</span>
                                    @endif
                                @endif

                                @if ($lang == 'la')
                                    @if ($locale == 'en')
                                        <span class="fi fi-us"></span><span> English</span>
                                    @endif
                                    @if ($locale == 'cn')
                                        <span class="fi fi-cn"></span><span> 中国人</span>
                                    @endif
                                @endif
                                @if ($lang == 'cn')
                                    @if ($locale == 'en')
                                        <span class="fi fi-us"></span><span> English</span>
                                    @endif
                                    @if ($locale == 'la')
                                        <span class="fi fi-la"></span><span> ລາວ</span>
                                    @endif
                                @endif
                            </a>
                        @endforeach
                    </div>
                </li>
            </div>
            <!-- End select language-->


            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>

            @php
                $id = Auth::user()->id;
                $adminData = App\Models\User::find($id);

            @endphp

            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user"
                        src="{{ !empty($adminData->profile_image) && file_exists('storage/media/' . $adminData->profile_image)
                            ? url('storage/media/' . $adminData->profile_image)
                            : (!empty(file_exists('storage/media/' . $adminData->profile_image))
                                ? url('upload/no_image.jpg')
                                : url('upload/image_deleted.jpg')) }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">{{ $adminData->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('admin.profile') }}"><i
                            class="ri-user-line align-middle me-1"></i> @lang('backend.profile')</a>
                    <a class="dropdown-item" href="{{ route('change.password') }}"><i
                            class="ri-wallet-2-line align-middle me-1"></i> @lang('backend.change_password')</a>
                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}">
                        <i class="ri-shut-down-line align-middle me-1 text-danger">
                        </i> @lang('backend.logout')</a>
                    </form>

                </div>
            </div>

        </div>
    </div>
</header>
