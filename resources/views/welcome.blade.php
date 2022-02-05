    @extends('layouts.main')
    @section('title', 'HDC EVENTS')
    
    @section('content')

   <div id="search-container" class="col-md-12">  {{--class vem tudo do bootstrap--}} 
        <h1>Busque um Evento</h1>
        <form action="/" method="GET">          
            <input type="text" id="search" name="search" class='form-control' placeholder="Procurar....."> 
        </form>                {{--id serve pro css, o name pro banco e placeholder é a dica do input--}}
   </div>

   <div id="events-container" class="col-md-12">  {{--class vem tudo do bootstrap, o id serve pro css--}} 
    @if($search) 
        <h2>Buscando por: {{$search}}</h2>   {{-- Se estiver em modo search ele entra--}} 
    @else
    <h2>Próximos Eventos</h2>
    <p class="subtitle">Veja os eventos dos próximos dias</p> 
    @endif              
        <div id="cards-container" class="row"> 
            @foreach ($events as $event)
                <div class="card col-md-3">   {{--nova div pra mostrar 3 caras por coluna--}}                
                   <img src="/img/events/{{$event->image}}" alt="{{$event->title}}">
                    <div class="card-body">
                     <p class="card-date">{{date('d/m/y', strtotime($event->date))}}</p>
                     <h5 class="card-title">{{$event->title}}</h5>
                     <p class="card-participants"> {{count($event->users)}} Participantes</p>
                     <a href='/events/{{$event->id}}' class="btn btn-primary">Saber mais</a> {{--Acessa a rota pelo id--}}
                    </div>
                </div>        
            
            @endforeach
            @if(count($events) == 0 && $search)
             <p>Não foi possível encontrar nenhum evento com {{ $search }}! <a href="/">Ver todos</a></p>
            @elseif(count($events) == 0)
             <p>Não há eventos disponíveis</p>
            @endif
        
        
        </div> 




    </div>

    @endsection
