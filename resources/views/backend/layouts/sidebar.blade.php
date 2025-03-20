<nav class="navbar-vertical navbar">
    <div class="h-screen" id="myScrollableElement" data-simplebar>
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-logo/>
        </a>

        <ul class="navbar-nav flex-col" id="sideNavbar">
            <x-sidebar-nav-link :href="route('dashboard')" icon="home" :active="request()->is('dashboard')">
                {{ __('Dashboard') }}
            </x-sidebar-nav-link>

            <li class="nav-item">
                <a class="nav-link @if (request()->is('benefits*') || request()->is('ability-supports*') || request()->is('our-processes*') || request()->is('services*')) collapsed @endif"
                   data-bs-toggle="collapse"
                   data-bs-target="#navServices" href="#" aria-expanded="false" aria-controls="navServices">
                    <i class="mr-2 h-4 w-4" data-feather="package"></i>
                    {{ __('Services') }}
                </a>

                <div
                    class="@if (request()->is('benefits*') || request()->is('ability-supports*') || request()->is('our-processes*') || request()->is('services*')) show @endif collapse"
                    id="navServices"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-col">
                        @can('benefit.viewAny')
                            <x-sidebar-nav-link :href="route('benefits.index')" :active="request()->is('benefits*')">
                                {{ __('Benefits') }}
                            </x-sidebar-nav-link>
                        @endcan

                        @can('ability-support.viewAny')
                            <x-sidebar-nav-link :href="route('ability-supports.index')"
                                                :active="request()->is('ability-supports*')">
                                {{ __('Ability Supports') }}
                            </x-sidebar-nav-link>
                        @endcan

                        @can('our-process.viewAny')
                            <x-sidebar-nav-link :href="route('our-processes.index')"
                                                :active="request()->is('our-processes*')">
                                {{ __('Our Processes') }}
                            </x-sidebar-nav-link>
                        @endcan

                        @can('service.viewAny')
                            <x-sidebar-nav-link :href="route('services.index')" :active="request()->is('services*')">
                                {{ __('Services') }}
                            </x-sidebar-nav-link>
                        @endcan
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link @if (request()->is('event-speakers*') || request()->is('event-types*') || request()->is('events*')) collapsed @endif"
                   data-bs-toggle="collapse"
                   data-bs-target="#navEvents" href="#" aria-expanded="false" aria-controls="navEvents">
                    <i class="mr-2 h-4 w-4" data-feather="award"></i>
                    {{ __('Events') }}
                </a>

                <div
                    class="@if (request()->is('event-speakers*') || request()->is('event-types*') || request()->is('events*')) show @endif collapse"
                    id="navEvents"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-col">
                        @can('event-speaker.viewAny')
                            <x-sidebar-nav-link :href="route('event-speakers.index')"
                                                :active="request()->is('event-speakers*')">
                                {{ __('Speakers') }}
                            </x-sidebar-nav-link>
                        @endcan

                        @can('event-type.viewAny')
                            <x-sidebar-nav-link :href="route('event-types.index')"
                                                :active="request()->is('event-types*')">
                                {{ __('Types') }}
                            </x-sidebar-nav-link>
                        @endcan

                        @can('event.viewAny')
                            <x-sidebar-nav-link :href="route('events.index')" :active="request()->is('events*')">
                                {{ __('Events') }}
                            </x-sidebar-nav-link>
                        @endcan
                    </ul>
                </div>
            </li>

            @can('user.viewAny')
                <x-sidebar-nav-link :href="route('users.index')" icon="user" :active="request()->is('users*')">
                    {{ __('Users') }}
                </x-sidebar-nav-link>
            @endcan

            @can('role.viewAny')
                <x-sidebar-nav-link :href="route('roles.index')" icon="shield" :active="request()->is('roles*')">
                    {{ __('Roles') }}
                </x-sidebar-nav-link>
            @endcan

            @can('language.viewAny')
                <x-sidebar-nav-link :href="route('languages.index')" icon="globe" :active="request()->is('languages')">
                    {{ __('Languages') }}
                </x-sidebar-nav-link>
            @endcan

            @can('setting.view')
                <x-sidebar-nav-link :href="route('settings.index')" icon="settings" :active="request()->is('settings*')">
                    {{ __('Settings') }}
                </x-sidebar-nav-link>
            @endcan


            @can('currency.viewAny')
                <x-sidebar-nav-link :href="route('currencies.index')" icon="dollar-sign" :active="request()->is('currencies')">
                    {{ __('Currencies') }}
                </x-sidebar-nav-link>
            @endcan

            @can('mailbox.view')
                <x-sidebar-nav-link :href="route('mailboxes.index')" icon="inbox" :active="request()->is('mailboxes*')">
                    {{ __('Mailbox') }}
                </x-sidebar-nav-link>
            @endcan

            <li class="nav-item">
                <a class="nav-link @if (request()->is('faq-categories*') || request()->is('faqs*')) collapsed @endif"
                   data-bs-toggle="collapse"
                   data-bs-target="#navFaqs" href="#" aria-expanded="false" aria-controls="navFaqs">
                    <i class="mr-2 h-4 w-4" data-feather="help-circle"></i>
                    {{ __('FAQ') }}
                </a>

                <div
                    class="@if (request()->is('faq-categories*') || request()->is('faqs*')) show @endif collapse"
                    id="navFaqs"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-col">
                        @can('faq_category.viewAny')
                            <x-sidebar-nav-link :href="route('faq-categories.index')" :active="request()->is('faq-categories*')">
                                {{ __('Categories') }}
                            </x-sidebar-nav-link>
                        @endcan

                        @can('faq.viewAny')
                            <x-sidebar-nav-link :href="route('faqs.index')" :active="request()->is('faqs*')">
                                {{ __('FAQs') }}
                            </x-sidebar-nav-link>
                        @endcan
                    </ul>
                </div>
            </li>

            @can('parent_review.viewAny')
                <x-sidebar-nav-link :href="route('parent-reviews.index')" icon="star" :active="request()->is('parent-reviews')">
                    {{ __('Parent Reviews') }}
                </x-sidebar-nav-link>
            @endcan

            @can('page.viewAny')
                <x-sidebar-nav-link :href="route('pages.index')" icon="file" :active="request()->is('pages')">
                    {{ __('Pages') }}
                </x-sidebar-nav-link>
            @endcan

            <li class="nav-item">
                <a class="nav-link @if (request()->is('blog-categories*') || request()->is('blogs*')) collapsed @endif"
                   data-bs-toggle="collapse"
                   data-bs-target="#navBlogs" href="#" aria-expanded="false" aria-controls="navBlogs">
                    <i class="mr-2 h-4 w-4" data-feather="file-text"></i>
                    {{ __('Blog') }}
                </a>

                <div
                    class="@if (request()->is('blog-categories*') || request()->is('blogs*')) show @endif collapse"
                    id="navBlogs"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-col">
                        @can('blog_category.viewAny')
                            <x-sidebar-nav-link :href="route('blog-categories.index')" :active="request()->is('blog-categories*')">
                                {{ __('Categories') }}
                            </x-sidebar-nav-link>
                        @endcan

                        @can('blog.viewAny')
                            <x-sidebar-nav-link :href="route('blogs.index')" :active="request()->is('blogs*')">
                                {{ __('Blogs') }}
                            </x-sidebar-nav-link>
                        @endcan
                    </ul>
                </div>
            </li>

            @can('resource.viewAny')
                <x-sidebar-nav-link :href="route('resources.index')" icon="database" :active="request()->is('resources')">
                    {{ __('Resources') }}
                </x-sidebar-nav-link>
            @endcan
        </ul>
    </div>
</nav>
