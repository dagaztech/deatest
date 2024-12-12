@php
    use App\Models\Form;
    use App\Models\Booking;
    $user = \Auth::guard('api')->user();
    $currantLang = $user->currentLanguage();
    $languages = Utility::languages();
    //$role_id = $user->roles->first()->id;
    $role_id = $user->rol;
    $user_id = $user->id;
    if (Auth::guard('api')->user()->type == 'Admin') {
        $forms = Form::all();
        $all_forms = Form::all();
        $bookings = Booking::all();
    } else {
        $forms = Form::select(['forms.*'])->where(function ($query) use ($role_id, $user_id) {
            $query
                ->whereIn('forms.id', function ($query1) use ($role_id) {
                    $query1
                        ->select('form_id')
                        ->from('assign_forms_roles')
                        ->where('role_id', $role_id);
                })
                ->OrWhereIn('forms.id', function ($query1) use ($user_id) {
                    $query1
                        ->select('form_id')
                        ->from('assign_forms_users')
                        ->where('user_id', $user_id);
                });
        });
        $bookings = Booking::all();
        $all_forms = Form::select('id', 'title')
            ->where('created_by', $user->id)
            ->get();
    }
    $bookings = $bookings->all();
@endphp
<nav class="dash-sidebar light-sidebar {{ $user->transprent_layout == 1 ? 'transprent-bg' : '' }}">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('home') }}" class="text-center b-brand">
                <!-- ========   change your logo hear   ============ -->
                @if ($user->dark_layout == 1)
                    <!--img src="{{ Utility::getsettings('app_logo') ? Storage::url('app-logo/app-logo.png') : Storage::url('app-logo/78x78.png') }}"
                        class="app-logo" /-->
                     <img src="images/logo.png"
                        class="app-logo" style="text-align:center; max-width:5em" />
                @else
                    <!--img src="{{ Utility::getsettings('app_dark_logo') ? Storage::url('app-logo/app-dark-logo.png') : Storage::url('app-logo/78x78.png') }}"
                        class="app-logo" /-->
                        <img src="images/logo.png"
                        class="app-logo" style="text-align:center; max-width:5em"/>
                @endif
            </a>
        </div>
        <div class="navbar-content">
            <ul class="dash-navbar d-block">
                <li class="dash-item dash-hasmenu {{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-home"></i></span>
                        <span class="dash-mtext custom-weight">{{ __('Panel de Control') }}</span></a>
                </li>
                @can('manage-dashboardwidget')
                    <li class="dash-item dash-hasmenu {{ request()->is('index-dashboard*') ? 'active' : '' }}">
                        <a href="{{ route('index.dashboard') }}" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-square"></i></span>
                            <span class="dash-mtext custom-weight">{{ __('GrÃ¡ficos del Panel') }}</span></a>
                    </li>
                @endcan
                @can('manage-dashboardwidget')
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('users*') || request()->is('roles*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-layout-2"></i></span><span
                                class="dash-mtext">{{ __('GestiÃ³n de Usuarios') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @can('manage-user')
                                <li class="dash-item {{ request()->is('users*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('users.index') }}">{{ __('Usuarios') }}</a>
                                </li>
                            @endcan
                            @can('manage-role')
                                <li class="dash-item {{ request()->is('roles*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('roles.index') }}">{{ __('Roles') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('manage-dashboardwidget')
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('forms*', 'design*') || request()->is('form-values*') || request()->is('form-template*') || request()->is('form-template/design*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-table"></i></span><span
                                class="dash-mtext">{{ __('Formularios') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @can('manage-form-template')
                                <li
                                    class="dash-item {{ request()->is('form-template*') || request()->is('form-template/design*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('form-template.index') }}">{{ __('Plantilla') }}</a>
                                </li>
                            @endcan
                            @can('manage-form')
                                <li class="dash-item {{ request()->is('forms*', 'design*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('forms.index') }}">{{ __('Formularios') }}</a>
                                </li>
                            @endcan
                            @can('manage-submitted-form')
                                <li class="dash-item">
                                    <a href="#!" class="dash-link"><span
                                            class="dash-mtext custom-weight">{{ __('Forms enviados') }}</span><span
                                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul
                                        class="dash-submenu {{ Request::route()->getName() == 'view.form.values' ? 'd-block' : '' }}">
                                        @foreach ($forms as $form)
                                            <li class="dash-item">
                                                <a class="dash-link {{ Request::route()->getName() == 'view.form.values' ? 'show' : '' }}"
                                                    href="{{ route('view.form.values', $form->id) }}">{{ $form->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('manage-dashboardwidget')
                    <!--li
                        class="dash-item dash-hasmenu {{ request()->is('bookings*') || request()->is('booking-values*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a class="dash-link"><span class="dash-micon"><i class="ti ti-box-model-2"></i></span><span
                                class="dash-mtext">{{ __('Booking') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @can('manage-booking')
                                <li class="dash-item {{ request()->is('bookings*', 'bookings/design*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('bookings.index') }}">{{ __('Booking') }}</a>
                                </li>
                            @endcan
                            @can('manage-booking-calendar')
                                <li class="dash-item selection:{{ request()->is('calendar/booking*') ? 'active' : '' }}">
                                    <a href="{{ route('booking.calendar') }}" class="dash-link">
                                        {{ __('Booking Calendar') }}</a>
                                </li>
                            @endcan
                            @can('manage-submitted-booking')
                                <li class="dash-item">
                                    <a class="dash-link"><span
                                            class="dash-mtext custom-weight">{{ __('Submitted Booking') }}</span><span
                                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul
                                        class="dash-submenu {{ Request::route()->getName() == 'view.booking.values' ? 'd-block' : '' }}">
                                        @foreach ($bookings as $book)
                                            <li class="dash-item {{ request()->is('form-values*') ? 'active' : '' }}">
                                                <a class="dash-link {{ Request::route()->getName() == 'view.booking.values' ? 'show' : '' }}"
                                                    href="{{ route('view.booking.values', $book->id) }}">{{ $book->business_name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endcan
                        </ul>
                    </li-->
                @endcan
                @can('manage-dashboardwidget')
                    <!--li class="dash-item dash-hasmenu {{ request()->is('poll*') ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('poll.index') }}"><span class="dash-micon">
                                <i class="ti ti-accessible"></i></span>
                            <span class="dash-mtext">{{ __('Polls') }}</span>
                        </a>
                    </li-->
                @endcan
                @can(['manage-document'])
                    <!--li class="dash-item dash-hasmenu {{ request()->is('document*') ? 'active' : '' }}">
                        <a href="{{ route('document.index') }}" class="dash-link">
                            <span class="dash-micon">
                                <i class="ti ti-file-text"></i>
                            </span>
                            <span class="dash-mtext">{{ __('Documents') }}
                            </span>
                        </a>
                    </li-->
                @endcan
                @can('manage-dashboardwidget')
                    <!--li
                        class="dash-item dash-hasmenu {{ request()->is('blogs*') || request()->is('blog-category*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon">
                                <i class="ti ti-forms"></i>
                            </span>
                            <span class="dash-mtext">{{ 'Blog' }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i>
                            </span>
                        </a>
                        <ul class="dash-submenu">
                            @can('manage-blog')
                                <li class="dash-item {{ request()->is('blogs*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('blogs.index') }}">{{ __('Blogs') }}</a>
                                </li>
                            @endcan
                            @can('manage-category')
                                <li class="dash-item {{ request()->is('blog-category*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('blog-category.index') }}">{{ __('Categories') }}</a>
                                </li>
                            @endcan

                        </ul>
                    </li-->
                @endcan

                @can('manage-dashboardwidget')
                    <!--li class="dash-item dash-hasmenu {{ request()->is('event*') ? 'active' : '' }}">
                        <a class="dash-link" href="{{ route('event.index') }}"><span class="dash-micon">
                                <i class="ti ti-calendar"></i></span>
                            <span class="dash-mtext">{{ __('Event Calender') }}</span>
                        </a>
                    </li-->
                @endcan
                @can('manage-announcement')
                    @if (Auth::guard('api')->user()->type == 'Admin')
                        <li class="dash-item dash-hasmenu {{ request()->is('announcement*') ? 'active' : '' }}">
                            <a href="{{ route('announcement.index') }}" class="dash-link">
                                <span class="dash-micon">
                                    <i class="ti ti-confetti">
                                    </i>
                                </span>
                                <span class="dash-mtext">{{ __('Announcement') }}
                                </span>
                            </a>
                        </li>
                    @else
                        <li
                            class="dash-item {{ request()->is('show-announcement-list*') || request()->is('show-announcement*') ? 'active' : '' }}">
                            <a class="dash-link d-flex align-items-center" href="{{ route('show.announcement.list') }}">
                                <span class="dash-micon">
                                    <i class="ti ti-confetti">
                                    </i>
                                </span>
                                <span>{{ __('Show Announcement List') }}</span></a>
                        </li>
                    @endif
                @endcan
                @can('manage-dashboardwidget')
                    @if (setting('pusher_status') == '1')
                        <!--li
                            class="dash-item dash-hasmenu {{ request()->is('chat*') ? 'active dash-trigger' : 'collapsed' }}">
                            <a href="#!" class="dash-link"><span class="dash-micon"><i
                                        class="ti ti-table"></i></span><span
                                    class="dash-mtext">{{ __('Support') }}</span><span class="dash-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="dash-submenu">
                                @can('manage-chat')
                                    <li class="dash-item">
                                        <a class="dash-link" href="{{ route('chats') }}">{{ __('Chats') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </li-->
                    @endif
                @endcan
                @can('manage-dashboardwidget')
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('mailtemplate*') || request()->is('sms-template*') || request()->is('manage-language*') || request()->is('create-language*') || request()->is('settings*') ? 'active dash-trigger' : 'collapsed' }} || {{ request()->is('create-language*') || request()->is('settings*') ? 'active' : '' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-apps"></i></span><span
                                class="dash-mtext">{{ __('GestiÃ³n de Cuenta') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @can('manage-mailtemplate')
                                <li class="dash-item {{ request()->is('mailtemplate*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('mailtemplate.index') }}">{{ __('Plantillas de correo') }}</a>
                                </li>
                            @endcan
                            @can('manage-sms-template')
                                <!--li class="dash-item {{ request()->is('sms-template*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('sms-template.index') }}">{{ __('Sms Templates') }}</a>
                                </li-->
                            @endcan
                            @can('manage-language')
                                <!--li
                                    class="dash-item {{ request()->is('manage-language*') || request()->is('create-language*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('manage.language', [$currantLang]) }}">{{ __('Manage Languages') }}</a>
                                </li-->
                            @endcan
                            @can('manage-setting')
                                <li class="dash-item {{ request()->is('settings*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('settings') }}">{{ __('ConfiguraciÃ³n') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('manage-dashboardwidget')
                    <!--li
                        class="dash-item dash-hasmenu {{ request()->is('landingpage-setting*') || request()->is('faqs*') || request()->is('page-setting*') || request()->is('testimonials*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-table"></i></span><span
                                class="dash-mtext">{{ __('ConfiguraciÃ³n de Inicio') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @can('manage-landing-page')
                                <li class="dash-item {{ request()->is('landingpage-setting*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('landing-page.setting') }}">{{ __('Landing Page') }}</a>
                                </li>
                            @endcan
                            @can('manage-testimonial')
                                <li class="dash-item {{ request()->is('testimonials*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('testimonial.index') }}">{{ __('Testimonials') }}</a>
                                </li>
                            @endcan
                            @can('manage-faqs')
                                <li class="dash-item {{ request()->is('faqs*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('faqs.index') }}">{{ __('FAQs') }}</a>
                                </li>
                            @endcan
                            @can('manage-page-setting')
                                <li class="dash-item {{ request()->is('page-setting*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('page-setting.index') }}">{{ __('Page Settings') }}</a>
                                </li>
                            @endcan
                        </ul>
                    </li-->
                @endcan
                            
            </ul>
        </div>
    </div>
</nav>
