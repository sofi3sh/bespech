@extends('layouts.app')

@section('content')
<body class="dark-mode">
    <div class="wrapper">
        <div class="content">
            <img class="main-image" src="images/Logo.svg" alt="none">
            <form class="main-form" method="POST" action="{{ route('signin') }}">
                 @csrf
                <span class="link-to-req-auto">{{__('login.no_acaunt')}}
                    <a data-otherPage="goToOtherPage" href="{{ route('register') }}">{{ __('login.sign_up') }}</a>
                </span>
                <div class="input-div">
                    <label class="main-form-label" for="">{{ __('login.email') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>


                </div>

                <div class="input-div">
                    <label class="main-form-label" for="">{{ __('login.password') }}</label>
                    <div class="input-eye-div">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <div data-id-of-input="password" class="show_password"></div>
                    </div>
                    <a data-otherPage="goToOtherPage" class="btn btn-link forgot-pass" href="{{ route('password.reset') }}">
                        {{ __('login.forgot_password') }}
                    </a>
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

                <button type="submit" class="submit-btn">
                    {{ __('login.sign_in') }}
                </button>

            </form>
        </div>

         <div class="errors-messages-div">
               @error('password')
                   <div class="error-div">
                    <img class="error-img" src="images/error.png" alt="none">
                    <span class="error-text">{{ __('login.error') }}</span>
                   </div>
              @enderror

        </div>
    </div>

</body>

<script type="text/javascript">

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


    var url = "{{ route('login') }}";
    let userLang = navigator.language || navigator.userLanguage;
    userLang = userLang.split('-');
    //  console.log(userLang[0]);
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
            // console.log(e.target.dataset.lang);
            window.location.href = url + "?lang=" + e.target.dataset.lang;
        });
    }
</script>
    <script>

        const darkThemeMq = window.matchMedia("(prefers-color-scheme: dark)");
        if (darkThemeMq.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
        // show_pasword
        let show_pass = document.querySelectorAll('.show_password')
        for (let i = 0; i < show_pass.length; i++) {
            show_pass[i].addEventListener('click', (e)=>{

                let input = document.querySelector(`#${e.target.dataset.idOfInput}`);
                let showIco = document.querySelector(`[data-id-of-input='${e.target.dataset.idOfInput}']`);
                const close = getComputedStyle(document.documentElement).getPropertyValue('--eye-close');
                const open = getComputedStyle(document.documentElement).getPropertyValue('--eye-open');
                const close_b = getComputedStyle(document.documentElement).getPropertyValue('--eye-close-b');
                const open_b = getComputedStyle(document.documentElement).getPropertyValue('--eye-open-b');

                if (input.type === "password") {
                    input.type = "text";
                    if (darkThemeMq.matches) {
                        showIco.style.backgroundImage = open_b;
                    } else {
                        showIco.style.backgroundImage = open;
                    }
                } else {
                    input.type = "password";
                    if (darkThemeMq.matches) {
                        showIco.style.backgroundImage = close_b;
                    } else {
                        showIco.style.backgroundImage = close_b;
                    }
                }
            });
        }

    </script>
</body>
@endsection
