@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="content2">
        <img class="main-image" src="{{ asset('images/Logo.svg') }}" alt="none">

        <form class="main-form" method="POST" action="{{ route('password.email') }}">
            @csrf
            <span class="link-to-req-auto2">
                {{__('passwords/email.reset')}}
                <a data-otherPage="goToOtherPage" class="nav-link" href="{{ route('login') }}">{{__('passwords/email.sign_in')}}</a>
            </span>
            <div class="input-div">
                <label class="main-form-label" for="">{{__('passwords/email.email')}}</label>
                <input name="email" type="email">
            </div>
            <div class="languages-div">
                <div data-lang="ua" class="lang-div {{ session()->get('locale') == 'ua' ? 'lang-div-active' : '' }}">
                    Ua
                </div>
                <div data-lang="en" class="lang-div {{ session()->get('locale') == 'en' ? 'lang-div-active' : '' }}">
                    En
                </div>
                <div data-lang="de" class="lang-div {{ session()->get('locale') == 'de' ? 'lang-div-active' : '' }}">
                    De
                </div>
            </div>
            <button class="submit-btn" type="submit">
                {{__('passwords/email.resetBtn')}}
            </button>
        </form>

    </div>
    <div class="errors-messages-div">
        @error('email')
        <div class="error-div">
            <img class="error-img" src="{{ asset('images/error.png') }}" alt="none">
            <span class="error-text">{{ $message }}</span>
        </div>
        @enderror
    </div>
</div>
<script>

        const otherPages = document.querySelectorAll('[data-otherPage="goToOtherPage"]');
        for(let i = 0; i < otherPages.length; i++){
            otherPages[i].addEventListener('click', (e)=>{
                e.preventDefault();
                const parsedUrl = new URL(window.location.href);
                const lang = parsedUrl.searchParams.get('lang');
                switch(lang) {
                      case 'de':
                        window.location.href = otherPages[i].href + "?lang=de";
                        break;
                      case 'uk':
                        window.location.href = otherPages[i].href + "?lang=ua";
                        break;
                      case 'en':
                        window.location.href = otherPages[i].href + "?lang=en";
                        break;
                      default:
                        window.location.href = otherPages[i].href;
                }
            });
        }

        var url = "{{ route('password.reset') }}";
        let userLang = navigator.language || navigator.userLanguage;
        userLang = userLang.split('-');
        const searchParams = new URLSearchParams(window.location.search);
        const lang = searchParams.get('lang');

        if(!lang){
            switch(userLang[0]) {
                case 'de':
                    window.location.href = url + "?lang=de";
                    break;
                case 'uk':
                    window.location.href = url + "?lang=ua";
                    break;
                default:
                    window.location.href = url + "?lang=en";
            }
        }

        let langsList = document.querySelectorAll('.lang-div');
        for (let i = 0; i < langsList.length; i++) {
            langsList[i].addEventListener('click', (e)=>{
                window.location.href = url + "?lang=" + e.target.dataset.lang;
            });
        }

        const darkThemeMq = window.matchMedia("(prefers-color-scheme: dark)");
        if (darkThemeMq.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
</script>
@endsection
