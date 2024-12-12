<header class="site-header header-style-one">
    @if (isset($announcementBars) && $announcementBars->count() > 0)
        <div class="announcebar">
            @foreach ($announcementBars as $announcementBar)
                @if ($announcementBar->cont < 1)
                    <p class="text-center text-capitalize">
                        <b>{{ __('Announcement :') }}</b>
                        <a href="{{ route('show.public.announcement', ['slug' => $announcementBar->slug]) }}"
                            class="announcement-title">
                            {{ $announcementBar->title }}
                        </a>
                    </p>
                @endif
            @endforeach
        </div>
    @endif
    <div class="main-navigationbar">
        <div class="container">
            <div class="navigation-row d-flex align-items-center ">
                <nav class="menu-items-col d-flex align-items-center justify-content-between ">
                    <div class="logo-col">
                        <h1>
                            <a href="{{ route('landingpage') }}" tabindex="0">
                                <img src="{{ Storage::url(setting('logo')) ? Storage::url('app-logo/logo.png') : asset('assets/images/logo.png') }}"
                                    class="" />
                            </a>
                        </h1>
                    </div>
                    <div class="menu-item-right-col d-flex align-items-center justify-content-between">
                        <div class="menu-left-col">
                            <ul class="main-nav d-flex align-items-center">
                                <li><a href="{{ route('landingpage') }}" tabindex="0">{{ __('Home') }}</a></li>
                                @php
                                    $headerMainMenus = App\Models\HeaderSetting::get();
                                @endphp
                                @if (!empty($headerMainMenus))
                                    @foreach ($headerMainMenus as $headerMainMenu)
                                        <li class="menu-has-items">
                                            @php
                                                $page = App\Models\PageSetting::find($headerMainMenu->page_id);
                                            @endphp
                                            <a @if ($page->type == 'link') ?  href="{{ $page->page_url }}"  @else  href="{{ route('description.page', $headerMainMenu->slug) }}" @endif
                                                tabindex="0">
                                                {{ $page->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Mobile menu start here -->
    <div class="container">
        <div class="mobile-menu-wrapper">
            <div class="mobile-menu-bar">
                <ul>
                    <li><a href="{{ route('landingpage') }}" tabindex="0">{{ __('Home') }}</a></li>
                    @php
                        $headerMainMenus = App\Models\HeaderSetting::get();
                    @endphp
                    @if (!empty($headerMainMenus))
                        @foreach ($headerMainMenus as $headerMainMenu)
                            <li class="menu-has-items">
                                @php
                                    $page = App\Models\PageSetting::find($headerMainMenu->page_id);
                                @endphp
                                <a @if ($page->type == 'link') ?  href="{{ $page->page_url }}"  @else  href="{{ route('description.page', $headerMainMenu->slug) }}" @endif
                                    tabindex="0">
                                    {{ $page->title }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                    <li>
                        <div class="mobile-login-btn">
                            <a href="{{ route('login') }}"> {{ __('Login') }}</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Mobile menu end here -->
</header>
