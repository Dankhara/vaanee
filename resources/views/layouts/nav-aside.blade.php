<!-- SIDE MENU BAR -->
<aside class="app-sidebar">
    <div class="app-sidebar__logo">
        <a class="header-brand" href="{{ url('/') }}">
            <img src="{{ URL::asset('img/brand/logo.png') }}" class="header-brand-img desktop-lgo" alt="Admintro logo">
            <img src="{{ URL::asset('img/brand/favicon.png') }}" class="header-brand-img mobile-logo" alt="Admintro logo">
        </a>
    </div>
    <ul class="side-menu app-sidebar3">
        @role('admin')
            <li class="side-item side-item-category mt-4">{{ __('Admin Panel') }}</li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.dashboard') }}">
                    <span class="side-menu__icon fa-solid fa-chart-tree-map"></span>
                    <span class="side-menu__label">{{ __('Admin Dashboard') }}</span>
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('#') }}">
                    <span class="side-menu__icon fa-solid fa-boxes-packing"></span>
                    <span class="side-menu__label">{{ __('Studio Management') }}</span><i
                        class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li><a href="{{ route('admin.studio.dashboard') }}" class="slide-item">{{ __('Studio Dashboard') }}</a>
                    </li>
                    <li><a href="{{ route('admin.studio.voice-cloning') }}"
                            class="slide-item">{{ __('Voice Cloning') }}</a></li>
                    <li><a href="{{ route('admin.voiceover.results') }}"
                            class="slide-item">{{ __('Voiceover Results') }}</a></li>
                    <li><a href="{{ route('admin.transcribe.results') }}"
                            class="slide-item">{{ __('Transcribe Results') }}</a></li>
                    <li><a href="{{ route('admin.voiceover.voices') }}"
                            class="slide-item">{{ __('Voices Customization') }}</a></li>
                    <li><a href="{{ route('admin.transcribe.languages') }}"
                            class="slide-item">{{ __('Languages Customization') }}</a></li>
                    <li><a href="{{ route('admin.sound.studio') }}"
                            class="slide-item">{{ __('Sound Studio Settings') }}</a></li>
                    <li><a href="{{ route('admin.voiceover.settings') }}"
                            class="slide-item">{{ __('Voiceover Studio Settings') }}</a></li>
                    <li><a href="{{ route('admin.transcribe.settings') }}"
                            class="slide-item">{{ __('Transcribe Studio Settings') }}</a></li>
                </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('#') }}">
                    <span class="side-menu__icon fa-solid fa-user-shield"></span>
                    <span class="side-menu__label">{{ __('User Management') }}</span><i
                        class="angle fa fa-angle-right"></i></a>
                <ul class="slide-menu">
                    <li><a href="{{ route('admin.user.dashboard') }}" class="slide-item">{{ __('User Dashboard') }}</a>
                    </li>
                    <li><a href="{{ route('admin.user.list') }}" class="slide-item">{{ __('User List') }}</a></li>
                    <li><a href="{{ route('admin.user.activity') }}"
                            class="slide-item">{{ __('Activity Monitoring') }}</a></li>
                </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('#') }}">
                    <span class="side-menu__icon fa-solid fa-sack-dollar"></span>
                    <span class="side-menu__label">{{ __('Finance Management') }}</span>
                    @if (auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count())
                        <span
                            class="badge badge-warning">{{ auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count() }}</span>
                    @else
                        <i class="angle fa fa-angle-right"></i>
                    @endif
                </a>
                <ul class="slide-menu">
                    <li><a href="{{ route('admin.finance.dashboard') }}"
                            class="slide-item">{{ __('Finance Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.finance.transactions') }}"
                            class="slide-item">{{ __('Transactions') }}</a></li>
                    <li><a href="{{ route('admin.finance.plans') }}" class="slide-item">{{ __('Subscription Plans') }}</a>
                    </li>
                    <li><a href="{{ route('admin.finance.prepaid') }}" class="slide-item">{{ __('Prepaid Plans') }}</a>
                    </li>
                    <li><a href="{{ route('admin.finance.subscriptions') }}"
                            class="slide-item">{{ __('Subscribers') }}</a></li>
                    <li><a href="{{ route('admin.referral.settings') }}"
                            class="slide-item">{{ __('Referral System') }}</a></li>
                    <li><a href="{{ route('admin.referral.payouts') }}" class="slide-item">{{ __('Referral Payouts') }}
                            @if (auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count())
                                <span
                                    class="badge badge-warning ml-5">{{ auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count() }}</span>
                            @endif
                        </a>
                    </li>
                    <li><a href="{{ route('admin.settings.invoice') }}"
                            class="slide-item">{{ __('Invoice Settings') }}</a></li>
                    <li><a href="{{ route('admin.finance.settings') }}"
                            class="slide-item">{{ __('Payment Settings') }}</a></li>
                </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.support') }}">
                    <span class="side-menu__icon fa-solid fa-message-question"></span>
                    <span class="side-menu__label">{{ __('Support Requests') }}</span>
                    @if (App\Models\Support::where('status', 'Open')->count())
                        <span class="badge badge-warning">{{ App\Models\Support::where('status', 'Open')->count() }}</span>
                    @endif
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('#') }}">
                    <span class="side-menu__icon fa-solid fa-message-exclamation"></span>
                    <span class="side-menu__label">{{ __('Notifications') }}</span>
                    @if (auth()->user()->unreadNotifications->where('type', '<>', 'App\Notifications\GeneralNotification')->count())
                        <span class="badge badge-warning" id="total-notifications-a"></span>
                    @else
                        <i class="angle fa fa-angle-right"></i>
                    @endif
                </a>
                <ul class="slide-menu">
                    <li><a href="{{ route('admin.notifications') }}"
                            class="slide-item">{{ __('Mass Notifications') }}</a></li>
                    <li><a href="{{ route('admin.notifications.system') }}"
                            class="slide-item">{{ __('System Notifications') }}
                            @if (auth()->user()->unreadNotifications->where('type', '<>', 'App\Notifications\GeneralNotification')->count())
                                <span class="badge badge-warning ml-5" id="total-notifications-b"></span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('#') }}">
                    <span class="side-menu__icon fa fa-globe"></span>
                    <span class="side-menu__label">{{ __('Frontend Management') }}</span><i
                        class="angle fa fa-angle-right"></i></a>
                <ul class="slide-menu">
                    <li><a href="{{ route('admin.settings.frontend') }}"
                            class="slide-item">{{ __('Frontend Settings') }}</a></li>
                    <li><a href="{{ route('admin.settings.appearance') }}"
                            class="slide-item">{{ __('SEO & Logos') }}</a></li>
                    <li><a href="{{ route('admin.settings.blog') }}" class="slide-item">{{ __('Blogs Manager') }}</a>
                    </li>
                    <li><a href="{{ route('admin.settings.faq') }}" class="slide-item">{{ __('FAQs Manager') }}</a></li>
                    <li><a href="{{ route('admin.settings.usecase') }}"
                            class="slide-item">{{ __('Use Cases Manager') }}</a></li>
                    <li><a href="{{ route('admin.settings.review') }}"
                            class="slide-item">{{ __('Reviews Manager') }}</a></li>
                    <li><a href="{{ route('admin.settings.terms') }}" class="slide-item">{{ __('Pages Manager') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings.careers.index') }}"
                            class="slide-item">{{ __('Carrers Manager') }}</a>
                    </li>
                </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('#') }}">
                    <span class="side-menu__icon fa fa-sliders"></span>
                    <span class="side-menu__label">{{ __('General Settings') }}</span><i
                        class="angle fa fa-angle-right"></i></a>
                <ul class="slide-menu">
                    <li><a href="{{ route('admin.settings.global') }}"
                            class="slide-item">{{ __('Global Settings') }}</a></li>
                    <li><a href="{{ route('admin.settings.oauth') }}" class="slide-item">{{ __('Auth Settings') }}</a>
                    </li>
                    <li><a href="{{ route('admin.settings.registration') }}"
                            class="slide-item">{{ __('Registration Settings') }}</a></li>
                    <li><a href="{{ route('admin.settings.smtp') }}" class="slide-item">{{ __('SMTP Settings') }}</a>
                    </li>
                    <li><a href="{{ route('admin.settings.backup') }}"
                            class="slide-item">{{ __('Database Backup') }}</a></li>
                    <li><a href="{{ route('admin.settings.activation') }}" class="slide-item">{{ __('Activation') }}</a>
                    </li>
                    <li><a href="{{ route('admin.settings.upgrade') }}"
                            class="slide-item">{{ __('Upgrade Software') }}</a></li>
                </ul>
            </li>
            <li class="side-item side-item-category mt-4">{{ __('Voice Clone') }}</li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('voice.clone.voice.clone.script') }}">
                    <span class="side-menu__icon fa-sharp fa-solid fa-microphone"></span>
                    <span class="side-menu__label">{{ __('Voice Clone Script') }}</span>
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('voice.clone.voice.cloning.profiles') }}">
                    <span class="side-menu__icon fa-sharp fa-solid fa-microphone"></span>
                    <span class="side-menu__label">{{ __('Voice Cloning Profile') }}</span>
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('voice.clone.voice.cloning.results') }}">
                    <span class="side-menu__icon fa-sharp fa-solid fa-microphone"></span>
                    <span class="side-menu__label">{{ __('Voice Cloning Results') }}</span>
                </a>
            </li>
        @endrole
        @role('admin')
            <hr style="height: 4px;">
            <li class="side-item side-item-category">{{ __('My Account') }}</li>
        @endrole
        @role('user|subscriber|voice-artist')
            <li class="side-item side-item-category mt-4">{{ __('My Account') }}</li>
        @endrole
        @unlessrole('voice-artist')
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.dashboard') }}">
                    <span class="side-menu__icon lead-3 fa-solid fa-chart-tree-map"></span>
                    <span class="side-menu__label">{{ __('My Dashboard') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.purchases') }}">
                    <span class="side-menu__icon lead-3 fa-solid fa-money-check-pen"></span>
                    <span class="side-menu__label">{{ __('Purchase History') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.referral') }}">
                    <span class="side-menu__icon lead-3 fa-solid fa-badge-dollar"></span>
                    <span class="side-menu__label">{{ __('Affiliate Program') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.plans') }}">
                    <span class="side-menu__icon lead-3 fa-solid fa-box-circle-check"></span>
                    <span class="side-menu__label">{{ __('Pricing Plans') }}</span></a>
            </li>
            @role('user|subscriber')
                @if (config('settings.user_support') == 'enabled')
                    <li class="slide">
                        <a class="side-menu__item" href="{{ route('user.support') }}">
                            <span class="side-menu__icon fa-solid fa-messages-question"></span>
                            <span class="side-menu__label">{{ __('Support Requests') }}</span>
                        </a>
                    </li>
                @endif
                @if (config('settings.user_notification') == 'enabled')
                    <li class="slide">
                        <a class="side-menu__item" href="{{ route('user.notifications') }}">
                            <span class="side-menu__icon fa-solid fa-message-exclamation"></span>
                            <span class="side-menu__label">{{ __('Notifications') }}</span>
                            @if (auth()->user()->unreadNotifications->where('type', 'App\Notifications\GeneralNotification')->count())
                                <span
                                    class="badge badge-warning">{{ auth()->user()->unreadNotifications->where('type', 'App\Notifications\GeneralNotification')->count() }}</span>
                            @endif
                        </a>
                    </li>
                @endif
            @endrole
            @role('admin')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('user.support') }}">
                        <span class="side-menu__icon fa-solid fa-messages-question"></span>
                        <span class="side-menu__label">{{ __('Support Requests') }}</span>
                    </a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('user.notifications') }}">
                        <span class="side-menu__icon fa-solid fa-message-exclamation"></span>
                        <span class="side-menu__label">{{ __('Notifications') }}</span>
                        @if (auth()->user()->unreadNotifications->where('type', 'App\Notifications\GeneralNotification')->count())
                            <span
                                class="badge badge-warning">{{ auth()->user()->unreadNotifications->where('type', 'App\Notifications\GeneralNotification')->count() }}</span>
                        @endif
                    </a>
                </li>
            @endrole
            <li class="side-item side-item-category">{{ __('Vaanee Studio') }}</li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.voiceover') }}">
                    <span class="side-menu__icon lead-3 fa-sharp fa-solid fa-waveform-lines"></span>
                    <span class="side-menu__label">{{ __('Voiceover Studio') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.video.dub-studio') }}">
                    <span class="side-menu__icon lead-3 fa-sharp fa-solid fa-waveform-lines"></span>
                    <span class="side-menu__label">{{ __('Video Dub Studio') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.audio.dub-studio') }}">
                    <span class="side-menu__icon lead-3 fa-sharp fa-solid fa-waveform-lines"></span>
                    <span class="side-menu__label">{{ __('Audio Dub Studio') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.text.dub-studio') }}">
                    <span class="side-menu__icon lead-3 fa-sharp fa-solid fa-waveform-lines"></span>
                    <span class="side-menu__label">{{ __('TTS') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.sound.audio_enhancer') }}">
                    <span class="side-menu__icon fa-solid fa-photo-film-music"></span>
                    <span class="side-menu__label">{{ __('Audio Enhancer') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.sound.music_gen_studio') }}">
                    <span class="side-menu__icon fa-solid fa-photo-film-music"></span>
                    <span class="side-menu__label">{{ __('Music Gen Studio') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.voiceover.results') }}">
                    <span class="side-menu__icon lead-3 fa-solid fa-folder-music"></span>
                    <span class="side-menu__label">{{ __('Synthesized Results') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.voiceover.projects') }}">
                    <span class="side-menu__icon lead-3 fa-solid fa-boxes-packing"></span>
                    <span class="side-menu__label">{{ __('Projects') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="/account/custom-projects">
                    <span class="side-menu__icon lead-3 fa-solid fa-boxes-packing"></span>
                    <span class="side-menu__label">{{ __('Custom Projects') }}</span></a>
            </li>
            @if (config('tts.enable.sound_studio') == 'on')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('user.sound.studio') }}">
                        <span class="side-menu__icon fa-solid fa-photo-film-music"></span>
                        <span class="side-menu__label">{{ __('Sound Mix Studio') }}</span></a>
                </li>
            @endif
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.voiceover.voices') }}">
                    <span class="side-menu__icon lead-3 fa-solid fa-cloud-music"></span>
                    <span class="side-menu__label">{{ __('All Voices') }}</span></a>
            </li>
            <li class="side-item side-item-category">{{ __('Speech to Text') }}</li>
            @if (config('stt.enable.aws_live') == 'on')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('user.transcribe.live') }}">
                        <span class="side-menu__icon lead-3 fa-solid fa-microphone-lines"></span>
                        <span class="side-menu__label">{{ __('Live Transcribe Studio') }}</span></a>
                </li>
            @endif
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.transcribe.file') }}">
                    <span class="side-menu__icon lead-3 fa-solid fa-file-music"></span>
                    <span class="side-menu__label">{{ __('File Transcribe Studio') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.transcribe.record') }}">
                    <span class="side-menu__icon lead-3 fa-solid fa-headset"></span>
                    <span class="side-menu__label">{{ __('Record Transcribe Studio') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.transcribe.results') }}">
                    <span class="side-menu__icon lead-3 fa-solid fa-folder-music"></span>
                    <span class="side-menu__label">{{ __('Transcribed Results') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.transcribe.projects') }}">
                    <span class="side-menu__icon lead-3 fa-solid fa-boxes-packing"></span>
                    <span class="side-menu__label">{{ __('Projects') }}</span></a>
            </li>
        @endunlessrole
        @role('voice-artist')
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.dashboard') }}">
                    <span class="side-menu__icon lead-3 fa-sharp fa-solid fa-house"></span>
                    <span class="side-menu__label">{{ __('Dashboard') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('voice.artist.show.studio.view') }}">
                    <span class="side-menu__icon lead-3 fa-sharp fa-solid fa-microphone-lines"></span>
                    <span class="side-menu__label">{{ __('Studio') }}</span></a>
            </li>
            {{-- <li class="slide">
                <a class="side-menu__item" href="{{ route('voice.artist.show.settings.page') }}">
                    <span class="side-menu__icon lead-3 fa-sharp fa-solid fa-gear"></span>
                    <span class="side-menu__label">{{ __('Settings') }}</span></a>
            </li> --}}
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('#') }}">
                    <span class="side-menu__icon fa-sharp fa-solid fa-gear"></span>
                    <span class="side-menu__label">{{ __('Settings') }}</span><i
                        class="angle fa fa-angle-right"></i></a>
                <ul class="slide-menu">
                    <li>
                        <a href="{{ route('voice.artist.show.audio.settings.page') }}"
                            class="slide-item">{{ __('Audio Settings') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('voice.artist.show.wallet.settings.page') }}"
                            class="slide-item">{{ __('Wallet Settings') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('voice.artist.show.voice.profile.settings.page') }}"
                            class="slide-item">{{ __('Voice Profile') }}</a>
                    </li>
                </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('voice.artist.show.my.projects.page') }}">
                    <span class="side-menu__icon lead-3 fa-solid fa-box-open"></span>
                    <span class="side-menu__label">{{ __('My Projects') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('voice.artist.show.all.projects.page') }}">
                    <span class="side-menu__icon lead-3 fa-solid fa-boxes-stacked"></span>
                    <span class="side-menu__label">{{ __('Projects') }}</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('voice.artist.show.help.view') }}">
                    <span class="side-menu__icon lead-3 fa-sharp fa-solid fa-circle-question"></span>
                    <span class="side-menu__label">{{ __('Help') }}</span></a>
            </li>
        @endrole
    </ul>
    <div class="aside-progress-position mt-2">
        <h6 class="side-item side-item-category mb-5">{{ __('Available Credits') }}</h6>
        <div class="row no-gutters text-center">
            <div class="col-6">
                <span class="pie-chart mb-2"
                    data-percent="{{ App\Services\HelperService::getCharactersPercentage() }}"
                    data-text="{{ App\Services\HelperService::getCharactersLeft() }}">
                    <span class="percent" style="width: 60px; line-height: 60px;"></span>
                </span>
                <p class="fs-10 mb-0 text-muted font-weight-bold">{{ __('Characters Left') }}</p>
                <p class="fs-8 text-muted">{{ App\Services\HelperService::getRenewalCycle() }}</p>
            </div>
            <div class="col-6">
                <span class="pie-chart mb-2" data-percent="{{ App\Services\HelperService::getMinutesPercentage() }}"
                    data-text="{{ App\Services\HelperService::getMinutesLeft() }}">
                    <span class="percent" style="width: 60px; line-height: 60px;"></span>
                </span>
                <p class="fs-10 mb-0 text-muted font-weight-bold">{{ __('Minutes Left') }}</p>
                <p class="fs-8 text-muted">{{ App\Services\HelperService::getRenewalCycle() }}</p>
            </div>
            <div class="col-12">
                <p class="fs-10 mb-1 text-muted">{{ __('Next renewal date: ') }}
                    {{ App\Services\HelperService::getRenewalDate() }}</p>
            </div>
            <div class="col-12">
                <p class="fs-10 mb-0 text-muted">{{ __('Prepaid characters: ') }}
                    {{ number_format(auth()->user()->available_chars_prepaid) }}</p>
            </div>
            <div class="col-12">
                <p class="fs-10 mb-0 text-muted">{{ __('Prepaid minutes: ') }}
                    {{ number_format(auth()->user()->available_minutes_prepaid) }}</p>
            </div>
        </div>
    </div>
</aside>
<!-- END SIDE MENU BAR -->
