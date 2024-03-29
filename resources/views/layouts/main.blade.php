<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>   <!--Aonde linka para o título-->
        
        <!-- Fonte do Google -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">

        <!-- CSS do Bootstrap-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        
        <!-- CSS da Aplicação-->
        <link rel="stylesheet" href="/css/styles.css">
        <script src="/js/scripts.js"></script>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="collapse navbar-collapse" id="navbar">
                    <a href="/"  class="navbar-brand">
                        <img src="/img/hdcevents_logo.svg" alt="HDC Events">
                    </a>
                    <ul class="navbar-nav">
                            <li class="nav-item">
                            <a href="/" class="nav-link">Eventos</a>
                            </li> 
                            <li class="nav-item">
                                <a href="/events/create" class="nav-link">Criar Eventos</a>
                            </li> 
                            @auth  {{--Aonde linca se o usuario esta autenticaod ou nao--}}
                            <li class="nav-item">
                              <a href="dashboard" class="nav-link">Meus eventos</a>
                            </li>
                            <li class="nav-item">
                              <form action="/logout" method="POST">
                                @csrf
                                <a href="/logout" 
                                  class="nav-link" 
                                  onclick="event.preventDefault();
                                  this.closest('form').submit();">
                                  Sair
                                </a>
                              </form>
                            </li>
                            @endauth
                            @guest   {{--parte do ususario nao autenticado--}}
                            <li class="nav-item">
                              <a href="/login" class="nav-link">Entrar</a>
                            </li>
                            <li class="nav-item">
                              <a href="/register" class="nav-link">Cadastrar</a>
                            </li>
                            @endguest
                        </ul>              
                     </div>
                 </nav>
            </header>
            <main>
                <div class="containder-fluid">
                    <div class="row">
                        @if(session('msg'))
                            <p class="msg">{{session('msg')}}</p> <!--Se passar na msg do controller entra aqui pra dar a mensagem na hora de salvar   -->
                        @endif
                         @yield('content')    <!--Aonde linka para o conteúdo principal-->
                    </div>   
                </div>           
        <footer>
            <p>HDC EVENTS &COPY; 2020</p>
        </footer>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    </body>
</html>
