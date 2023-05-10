<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-gray-100{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.border-gray-200{--tw-border-opacity: 1;border-color:rgb(229 231 235 / var(--tw-border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{--tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);--tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.text-center{text-align:center}.text-gray-200{--tw-text-opacity: 1;color:rgb(229 231 235 / var(--tw-text-opacity))}.text-gray-300{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity))}.text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-gray-600{--tw-text-opacity: 1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-700{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity: 1;color:rgb(17 24 39 / var(--tw-text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--tw-bg-opacity: 1;background-color:rgb(31 41 55 / var(--tw-bg-opacity))}.dark\:bg-gray-900{--tw-bg-opacity: 1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:border-gray-700{--tw-border-opacity: 1;border-color:rgb(55 65 81 / var(--tw-border-opacity))}.dark\:text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}}
    </style>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
        .get-zap  {
            padding: 5px 0;
            border-bottom: 2px solid #384bce5e;
            border-top: 2px solid #384bce5e;
            background: #c4e2fdb0;
        }
        .getpost-zap  {
            padding: 5px 0;
            border-bottom: 2px solid #38ce695e;
            border-top: 2px solid #38ce695e;
            background: #c4fdcc96;
        }
    </style>
</head>
<!-- style="background:#eeee95d4" -->
<body class="antialiased">

<h2 class="alert alert-info" role="alert" >Домен тестовий:</h2>

<pre>https://bespechnuy.siteweb.org.ua/</pre>

<h2 class="alert alert-info" role="alert" >api-key для тестової роботи</h2>
<pre>d4d12fb2a814682bbdc0cba801cb5919edf1273a61007d82ca0bf331c59d7986</pre>

<h2 class="alert alert-info" role="alert" >Аутентифікація / Авторизація</h2>
<div class="alert alert-primary" role="alert">
    <h3>силка авторизації</h3>
    <pre>
               https://bespechnuy.siteweb.org.ua/login
               ( language  парамтр мови  / передається код мови  в header

                 "language": "ua",
                 "language": "en",

               )
            </pre>
</div>

<!-- категорії ролі -->
<h2 class="alert alert-success" role="alert">Парамтр ролі категорії користувача:</h2>
<pre class="alert alert-light" role="alert">
              парамтри role=1(n)
        {
                                    "id": 1,
                                    "name": "Викладач"
                                },
                                {
                                    "id": 2,
                                    "name": "Студент"
                                },
                                {
                                    "id": 3,
                                    "name": "Адміністратор"
                                }

        </pre>

<!-- header -->
<h2 class="alert alert-success" role="alert">Обов'язкові дані в header:</h2>
<div class="alert alert-success" role="alert">
    <pre class="alert alert-warning" role="alert"> api-key = d4d12fb2a814682bbdc0cba801cb5919edf1273a61007d82ca0bf331c59d7986 </pre>
    <pre class="alert alert-warning" role="alert">  token = 64783626246...669d76d  // ОТРИМУЄТЬСЯ ПРИ РЕЄСТРАЦІЇ</pre>
</div>

<!-- error -->
<h2 class="alert alert-danger" role="alert" >error code</h2
<pre class="alert alert-danger" role="alert" >

        <table class="alert alert-warning table table-dark table-striped" role="alert">
          <tr>
            <th>HTTP Status Code</th>
            <th>Description</th>
          </tr>
          <tr>
            <td>200</td>
            <td>Success with GET, PATCH, or HEAD request</td>
          </tr>
          <tr>
            <td>201</td>
            <td>Success with POST request</td>
          </tr>
          <tr>
            <td>204</td>
            <td>Success with DELETE</td>
          </tr>
          <tr>
            <td>400</td>
            <td>The request could not be understood, usually because the ID is not valid for the particular resource.</td>
          </tr>
          <tr>
            <td>401</td>
            <td> Incorrect token. The session ID or OAuth token has expired or is invalid. Or, if the request is made by a guest user,<br> the resource isn’t accessible to guest users. The response body contains the message and errorCode.
            </td>
          </tr>
          <tr>
            <td>403</td>
            <td>The request has been refused. Verify that the context user has the appropriate permissions<br> to access the requested data, or that the context user is not an external user.</td>
          </tr>
          <tr>
            <td>409</td>
            <td>A conflict has occurred. For example, an attempt was made to update a request to join a group,<br> but that request had already been approved or rejected.</td>
          </tr>
            <tr>
            <td>410</td>
            <td>The requested resource has been retired or removed. Delete or update any references to the resource.</td>
          </tr>
            <tr>
            <td>412</td>
            <td>A precondition has failed. For example, in a batch request,<br> if <i style="color: red;">haltOnError</i> is <i style="color: red;">true</i> and a subrequest fails, subsequent subrequests return 412.</td>
          </tr>
           <tr>
            <td>415</td>
            <td>Not found api key. Either the specified resource was not found, or the resource has been deleted.</td>
          </tr>
          <tr>
            <td>422</td>
            <td>The HyperText Transfer Protocol (HTTP) 422 Unprocessable Content response status code<br> indicates that the server understands the content type of the request entity, <br>and the syntax of the request entity is correct, but it was unable to process the contained instructions.</td>
          </tr>

            <tr>
            <td>500</td>
            <td>An error has occurred within Lightning Platform, so the request<br> could not be completed. Contact Salesforce Customer Support.</td>
          </tr>
            <tr>
            <td>503</td>
            <td>Too many requests in an hour or the server is down for maintenance.</td>
          </tr>
        </table>

      </pre>

<!-- Запити -->
<h1 class="alert alert-dark" role="alert" >Запити</h1>


<!-- Конфігурація додатку -->
<h2 class="alert alert-info" role="alert" >Конфігурація додатку</h2>
<div class="alert alert-primary" role="alert">
    <p>
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            GET
        </button>
        <span>
           <b>Version   Link:</b><u> api/config</u>
           </span>
    </p>
    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <b>  header</b>
            <pre>
                      api-key = "..."
                      token = "..."
                  </pre>
            <b>Status 200 ok</b>
            <pre>
                           [
                                "id": 1,
                                "minVersion": "1.0.2",
                                "updatingUrl": "https://play.google.com/store/apps?hl=uk&gl=US&pli=1"
                           ]
            </pre>
           
        </div>


    </div>
</div>
<!-- Категорії / Ролі -->
<h2 class="alert alert-info" role="alert" >Категорії / Ролі</h2>
<div class="alert alert-primary" role="alert">
    <p>
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">
            GET
        </button>
        <span><b>Category list Link: </b><u> api/categories</u>
          </span>
    </p>
    <div class="collapse" id="collapseExample2">
        <div class="card card-body">
            <b>  header</b>
            <pre>
                      api-key = "..."
                      token = "..."
                  </pre>
            <b>Status 200 ok</b>
            <pre>
               [
                    {
                        "id": 1,
                        "description": "Викладач"
                    },
                    {
                        "id": 2,
                        "description": "Студент"
                    },
                    {
                        "id": 3,
                        "description": "Адміністратор"
                    }
                ]
            </pre>
           
        </div>
    </div>
</div>
<!-- Мови -->
<h2 class="alert alert-info" role="alert" >Мови</h2>
<div class="alert alert-primary" role="alert">
    <p>
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample">
            GET
        </button>
        <span>
                      <b>Language Link:</b><u> api/language</u>
                      </span>
    </p>
    <div class="collapse" id="collapseExample3">
        <div class="card card-body">
            <b>  header</b>
            <pre>
                      api-key = "..."
                      token = "..."
                  </pre>
            <b>Status 200 ok</b>
            <pre> 
                                    [
                                        {
                                            "id": 1,
                                            "name": "Українська",
                                           
                                        },
                                        {
                                            "id": 3,
                                            "name": "English",
                                           
                                        }
                                    ]
                   
                    </pre>
          
        </div>
    </div>
</div>


<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: Arial, sans-serif;
        line-height: 1.5;
        background-color: #f7f7f7;
    }

    header {
        background-color: #007bff;
        color: white;
        padding: 10px;
        text-align: center;
        font-size: 1.5rem;
        margin-bottom: 20px;
    }

    main {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    h1, h2 {
        margin-top: 20px;
        margin-bottom: 10px;
        font-size: 1.2rem;
        font-weight: bold;
    }

    pre {
        font-family: Consolas, monospace;
        font-size: 0.9rem;
        background-color: #f8f8f8;
        border: 1px solid #ccc;
        padding: 10px;
        overflow-x: auto;
    }

    p {
        margin: 10px 0;
        font-size: 0.9rem;
    }

    footer {
        background-color: #f5f5f5;
        color: #333;
        padding: 10px;
        text-align: center;
        font-size: 0.8rem;
        margin-top: 20px;
    }

    .antialiased{
        margin: 30px 100px;
    }

    div{
        margin: 20px 0;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        font-family: Arial, sans-serif;
    }
    th, td {
        text-align: left;
        padding: 8px;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    button {
        background-color: blue;
        color: white;
        border: none;
    }

    button:hover {
        background-color: lightblue;
        color: black;
    }

    button:active {
        background-color: red;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>
</html>
