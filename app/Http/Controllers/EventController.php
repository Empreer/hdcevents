<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;       //Colocado para acessar o model eventos
use App\Models\User;       //Colocado para acessar o model usuários


class EventController extends Controller //BLOCO DE SAIDA DE DADOS PARA A VIEW 
{
   public function index(){      //Funções que serão enviada a pagina principal.
    
    $search = request('search'); // pega a requisicao de busca la da view tá com esse nome lá no input de busca
    
    if($search){

        $events = Event::where([           //where com like do eloquent
            ['title', 'like','%'.$search.'%']
        ])->get();

    }
      else {
    $events = Event::all(); }  // Pega todos os registros do banco que veio pelo model e joga lá na view

    return view('welcome',['events' => $events,'search'=> $search]);  // envia os eventos para a view welcome.
    }
   
  
  
  
    public function create() {              
        return view('events.create'); //retorna a view do events/create
    }
   
    public function store(Request $request)  {    //Funções de gravação POST
            $event = new Event;          //Acessando o Model que foi declarado lá encima
            $event->title = $request->title;     //Jogando pro model a request que vem lá da view por meio da rota
            $event->date = $request->date;
            $event->city = $request->city;
            $event->private = $request->private;
            $event->description = $request->description;
            $event->items = $request->items;
            //Imagem Upload

            if($request->hasFile('image') && $request->file('image')->isValid()){
        
               
                $requestImage = $request->image;   //requisita o arquivo image
                $extension = $requestImage->extension(); // requisita a extensao do arquivo de imagem
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension; //cria o nome do arquivo

                $requestImage->move(public_path('img/events'), $imageName); //grava o arquivo na pasta img

                $event->image = $imageName;   // salva o caminho no banco

            }

            $user = auth()->user();
            $event->user_id = $user->id; // mesma coisa que evevt.user = user.id

            $event->save();      //comando de salvar
            
                                  //with é a mensagem que vai lá pra view quando redirecionar.
            return redirect('/')-> with('msg', 'Evento Criado com sucesso!');  //comando que joga para uma nova tela.
    }

    public function show($id){     //view de exibicao dos eventos 

        $event =  Event::findorFail($id);
                                                            //o first deixa a query mais rapida quando se trata de id pois ele ja para a pesquisa no primeiro resultado que encontra.
        $eventOwner = User::where('id','=',$event->user_id)->first()->toArray(); // retorna o usuário que for igual ao id do evento.
        $user = auth()->user();
        $hasUserJoined = false;

        if($user) {

            $userEvents = $user->eventsAsParticipant->toArray();

            foreach($userEvents as $userEvent) {
                if($userEvent['id'] == $id) {
                    $hasUserJoined = true;
                }
            }

        }
        return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner, 'hasUserJoined' => $hasUserJoined]);   //retorna pra view o id requisitado
    }

    public function dashboard() {

        $user = auth()->user();

        $events = $user->events;

        $eventsAsParticipant = $user->eventsAsParticipant;

        return view('events.dashboard', ['events' => $events, 'eventsasparticipant' => $eventsAsParticipant]);

    }

    public function destroy($id) {

        Event::findOrFail($id)->delete();
        return redirect('/dashboard')-> with('msg', 'Evento Excluído com sucesso!');

    }

    public function edit($id) {

       $event=  Event::findOrFail($id);

       return view('events.edit',['event'=>$event]);

    }

    public function update(Request $request){
         
          $data = $request->all();

        // Image Upload mesmo método do salvar.
        if($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('img/events'), $imageName);

            $data['image'] = $imageName;

        }
            Event::findOrFail($request->id)->update($data);

            return redirect('/dashboard')-> with('msg', 'Evento Editado com sucesso!');
    }


    public function joinEvent($id){

        $user = auth()->user();

        $user-> eventsAsParticipant()->attach($id);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Sua presença está confirmada no evento ' . $event->title);

    }

        public function leaveEvent($id) {

        $user = auth()->user();

        $user->eventsAsParticipant()->detach($id);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Você saiu com sucesso do evento: ' . $event->title);

    }

}
