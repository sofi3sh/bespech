@extends('layouts.app')

@section('content')
<body class="dark-mode">
    <div class="wrapper">
        <div class="content2">
            <img class="main-image" src="images/Logo.svg" alt="none">
            <form class="main-form" method="POST" action="{{ route('register') }}">
                @csrf
                <span class="link-to-req-auto2">{{__('register.acaunt')}}
                    <a data-otherPage="goToOtherPage" class="nav-link" href="{{ route('login') }}">{{__('register.sign_in')}}</a>
                </span>

                <div class="input-div">
                    <label class="main-form-label" for="">{{ __('register.category') }}</label>
                    <div class="custom-select">
                         <select name="category_id">
                              <option value="">{{ __('register.category_select') }}</option>
                                @foreach($categoriesDescriptionArr as $categoryDescription)
                                    <option value="{{$categoryDescription->categoryId}}">{{$categoryDescription->description}}</option>
                                @endforeach
                            </select>

                    </div>
                </div>

                <div class="input-div">
                    <label class="main-form-label" for="">{{ __('register.email') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">


                </div>

                <div class="input-div">
                    <label class="main-form-label" for="">{{ __('register.password') }}</label>
                    <div class="input-eye-div">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        <div data-id-of-input="password" class="show_password"></div>
                    </div>

                </div>

                <div class="input-div">
                    <label class="main-form-label" for="">{{ __('register.сonfirm_password') }}</label>
                    <div class="input-eye-div">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        <div data-id-of-input="password-confirm" class="show_password"></div>
                    </div>
                    <span class="main-text">
                      {{__('register.verificate')}}
                    </span>
                </div>

                <style>

                </style>


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
                    {{__('register.sign_up')}}
                </button>

            </form>
        </div>
        <div class="errors-messages-div">
            @error('category_id')
                <div class="error-div">
                <img class="error-img" src="images/error.png" alt="none">
                <span class="error-text">{{ __('register.error_category_id') }}</span>
                </div>
            @enderror
             @error('password')
                <div class="error-div">
                <img class="error-img" src="images/error.png" alt="none">
                <span class="error-text"> {{ __('register.error_password') }}</span>
                </div>
              @enderror
              @error('password-confirm')
                <div class="error-div">
                    <img class="error-img" src="images/error.png" alt="none">
                    <span class="error-text">
                        {{ __('register.error_confirm') }}
                    </span>
                </div>
              @enderror
              @error('email')
                   <div class="error-div">
                    <img class="error-img" src="images/error.png" alt="none">
                    <span class="error-text">{{ __('register.error_email') }}</span>
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

        var url = "{{ route('register') }}";
        let userLang = navigator.language || navigator.userLanguage;
        userLang = userLang.split('-');
        // console.log(userLang[0]);
        const searchParams = new URLSearchParams(window.location.search);
        const lang = searchParams.get('lang');

        // console.log(lang);
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

        var x, i, j, l, ll, selElmnt, a, b, c;
        /*look for any elements with the class "custom-select":*/
        x = document.getElementsByClassName("custom-select");
        l = x.length;
        for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;
        /*for each element, create a new DIV that will act as the selected item:*/
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        /*for each element, create a new DIV that will contain the option list:*/
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 1; j < ll; j++) {
            /*for each option in the original select element,
            create a new DIV that will act as an option item:*/
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function(e) {
                /*when an item is clicked, update the original select box,
                and the selected item:*/
                var y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                for (i = 0; i < sl; i++) {
                if (s.options[i].innerHTML == this.innerHTML) {
                    s.selectedIndex = i;
                    h.innerHTML = this.innerHTML;
                    y = this.parentNode.getElementsByClassName("same-as-selected");
                    yl = y.length;
                    for (k = 0; k < yl; k++) {
                    y[k].removeAttribute("class");
                    }
                    this.setAttribute("class", "same-as-selected");
                    break;
                }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function(e) {
            /*when the select box is clicked, close any other select boxes,
            and open/close the current select box:*/
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
            });
        }
        function closeAllSelect(elmnt) {
        /*a function that will close all select boxes in the document,
        except the current select box:*/
        var x, y, i, xl, yl, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        xl = x.length;
        yl = y.length;
        for (i = 0; i < yl; i++) {
            if (elmnt == y[i]) {
            arrNo.push(i)
            } else {
            y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < xl; i++) {
            if (arrNo.indexOf(i)) {
            x[i].classList.add("select-hide");
            }
        }
        }
        /*if the user clicks anywhere outside the select box,
        then close all select boxes:*/
        document.addEventListener("click", closeAllSelect);
    </script>
</body>
@endsection
