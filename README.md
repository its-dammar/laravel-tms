This is a Laravel project. In this project, you will learn CRUD operation, file upload, pagination, authenticating, and notification.

1. Create a new laravel project
    - composer create-project laravel/laravel example-app
    OR
    - composer global require laravel/installer
    - laravel new example-app

2. cd example-app (Go to your project folder)
    - php artisan serve

3. Create a .env file and update the database
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravelcrud1
    DB_USERNAME=root
    DB_PASSWORD=

    - php artisan migrate

    if you face any problem ( Go to app\providers\appServiceProvider)

    - use Illuminate\Support\Facades\Schema;
        public function boot()
        {
            Schema::defaultStringLength(191);
        }

4. Create a tasks folder inside the resource/view/tasks & create following files
    create.php
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <title>Create Task</title>
        @notifyCss
    </head>

    <body>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container w-75 mx-auto m-5 p-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Create Task</h5>
                    <x:notify-messages />
                    <form action="{{route('task.store')}}" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                        @csrf
                        <div class="col-md-12">
                            <label for="validationCustom01" class="form-label">First name</label>
                            <input type="text" class="form-control" id="validationCustom01" value="" name="title" >
                            <span style=
                            "color:red;">@error('title'){{$message}}@enderror</span>

                        </div>
                        <div class="col-md-12">
                            <label for="validationCustom02" class="form-label">Last name</label>
                            <input type="text" class="form-control" id="validationCustom02" value="" name="description">
                            <span style="color:red;">@error('description'){{$message}}@enderror</span>
                        </div>
                        <div class="col-md-12">
                            <label for="validationCustom02" class="form-label">Last name</label>
                            <input type="file" class="form-control" id="validationCustom02" value="" name="img">
                            <span style="color:red;">@error('img'){{$message}}@enderror</span>
                        </div>
                        <div class="col-12 text-end">
                            <button class="btn btn-primary" type="submit" name="submit">Submit form</button>
                        </div>
                    
                    </form>
                </div>
            </div>
        </div>
        @notifyJs
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
        </script>
    </body>

    </html>

    index.php
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <title>Manage Task</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mx-auto">
            <a class="btn btn-primary btn-sm my-4" href="{{route('task.create')}}" role="button"> Cteate Task</a>
            <table class="table table-primary table-striped table-hover table-bordered table-sm table-responsive-sm">
                <thead>
                    <tr>
                        <th scope="col">S.N</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($task as $tasks)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$tasks->title}}</td>
                        <td>{{$tasks->description}}</td>
                        <td><img src="{{asset('uploads/' . $tasks->img)}}" alt="" width="100" height="100"></td>
                        <td>
                        <a class="btn btn-primary btn-sm " href="{{route('task.edit', $tasks->id)}}" role="button"> Edit</a>
                        <a class="btn btn-info btn-sm " href="{{route('task.show', $tasks->id)}}" role="button"> View</a>
                        <!-- Modal trigger button -->
                        <button type="button" class="btn btn-sm btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#modalId">
                        Delete
                        </button>

                        <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTitleId">Do you want to delete data?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancle</button>
                                            <form action="{{route('task.destroy', $tasks->id)}}" method="POST" enctype="multipart/form-data">
                                                @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            @csrf
                                            </form> 
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Optional: Place to the bottom of scripts -->
                        <script>
                            const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)

                        </script>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="w-25 mx-auto">
                {{ $task->links() }}
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    </body>
    </html>

    show.php
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <title>Create Task</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container w-75 mx-auto m-5 p-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">View Task</h5>
                    <a class="btn btn-primary btn-sm " href="{{route('task.index')}}" role="button"> </a>
                    <form action="{{route('task.update', $task->id)}}" method="POST" enctype="multipart/form-data " class="row g-3 needs-validation" novalidate>
                        {{--  @method('PUT')  --}}
                        <div class="col-md-12">
                            <label for="validationCustom01" class="form-label">First name</label>
                            <input type="text" class="form-control" id="validationCustom01" value="{{$task->title}}" name="title" >
                        </div>
                        <div class="col-md-12">
                            <label for="validationCustom02" class="form-label">Last name</label>
                            <input type="text" class="form-control" id="validationCustom02" value="{{$task->description}}" name="description" >
                        </div>
                        <div class="col-md-12">
                            <label for="validationCustom02" class="form-label">Last name</label>
                            <img src="{{asset('uploads/' . $task->img)}}" alt="" width="200" height="200">                   
                        </div>
                        @csrf

                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
        </script>
    </body>

    </html>


    edit.php
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <title>Create Task</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container w-75 mx-auto m-5 p-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Create Task</h5>
                    <form action="{{route('task.update', $task->id)}}" method="POST" enctype="multipart/form-data " class="row g-3 needs-validation" novalidate>
                        @method('PUT')
                        <div class="col-md-12">
                            <label for="validationCustom01" class="form-label">First name</label>
                            <input type="text" class="form-control" id="validationCustom01" value="{{$task->title}}" name="title" >
                        </div>
                        <div class="col-md-12">
                            <label for="validationCustom02" class="form-label">Last name</label>
                            <input type="text" class="form-control" id="validationCustom02" value="{{$task->description}}" name="description" >
                        </div>
                        <div class="col-md-12">
                            <label for="validationCustom02" class="form-label">Last name</label>
                            <input type="file" class="form-control" id="validationCustom02" value="{{$task->img}}" name="img" >
                        </div>
                        @csrf
                            <button class="btn btn-primary" type="submit" name="submit">Submit form</button>

                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
        </script>
    </body>

    </html>


5. Create model, migration, and controller
    - model:- php artisan make model
    - controller:- php artisan make:controller TaskController --resource
    - Migration:- php artisan make:migration create_tasks_table
    OR
    - php artisan make:model Task –migration –controller –resource

    and Update model, migration and controller

    Migration
    - Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('img');
            $table->timestamps();
        });

    - model
     protected $fillable = [
        'title',
        'description',
        'img',
    ];

    - controllers
    <?php

    namespace App\Http\Controllers;

    use App\Models\task;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\File;

    class TaskController extends Controller
    {
        /**
        * Display a listing of the resource.
        *
        * @return \Illuminate\Http\Response
        */
        public function index()
        {
            $task = new task;
            // $task= $task->get();
            $task= $task->paginate(5);
            // return view('tasks/index');
            return view('admin.tasks.index', compact('task'));
        }

        /**
        * Show the form for creating a new resource.
        *
        * @return \Illuminate\Http\Response
        */
        public function create()
        {
            return view('admin.tasks.create');
        }

        /**
        * Store a newly created resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\Response
        */
        public function store(Request $request)
        {
            $task= new task;
            $validate_data = $request->validate([
                'title'=>'required',
                'description'=>'required',
                'img'=>'required',

            ]);
            
            if ($request->hasFile('img') && $request->file('img')->isValid()) {
                // The file is valid and can be uploaded
                $fileName = $request->title . "-" . time() . '.' . $request->img->extension();
                $request->img->move(public_path('uploads'), $fileName);
                }

            $task->title=$request->title;
            $task->description=$request->description;
            $task->img =  $fileName;
            $task->save();
            notify()->success('Laravel Notify is awesome!');
            return redirect()->route('task.index');
        }

        /**
        * Display the specified resource.
        *
        * @param  \App\Models\task  $task
        * @return \Illuminate\Http\Response
        */
        public function show($id)
        {
            $task = new Task;
            $task =$task->where('id', $id)->first();
            return view('admin.tasks.show', compact('task'));
        }

        /**
        * Show the form for editing the specified resource.
        *
        * @param  \App\Models\task  $task
        * @return \Illuminate\Http\Response
        */
        public function edit($id)
        {
            $task = new Task;
            $task =$task->where('id', $id)->first();
            return view('admin.tasks.edit', compact('task'));

        }

        /**
        * Update the specified resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  \App\Models\task  $task
        * @return \Illuminate\Http\Response
        */
        public function update(Request $request, $id)
        {
            $tasks = New Task;
            $tasks = $tasks -> where('id', $id)->First();
            $tasks->title = $request->title;
            $tasks->description = $request->description;

            if ($request->img != NULL) {
                $fileName = $request->title . "-" . time() . '.' . $request->img->extension();
                File::delete(public_path('uploads/' . $tasks->img));
                $request->img->move(public_path('uploads'), $fileName);
                $tasks::where('id', $id)
                    ->update([
                        'img' => $fileName,
                    ]);
            }


            $tasks->update();
            notify()->success('Laravel Notify is awesome!');
            return redirect()->route('task.index');
        }



        

        /**
        * Remove the specified resource from storage.
        *
        * @param  \App\Models\task  $task
        * @return \Illuminate\Http\Response
        */
        public function destroy($id)
        {
            // $task=  $task->where('id', $id)->first();
            // $task->delete();
            // return redirect('task');
            $task = new Task;
            $task = $task->where('id', $id)->first();
            File::delete(public_path('uploads/' . $task->img));
            $task->delete();
            notify()->success('Laravel Notify is awesome!');
            return redirect()->route('task.index');
        }
    }


6. Create route ( route\web.php)
    Route::get('/', 'App\Http\Controllers\FrontendController@index');
    OR

    <!-- Authenticate route -->
        Route::prefix('/admin')->middleware('auth')->group(function () {
        Route::get('/',function()
        {
            return redirect()->route('task.index');
        }); 
        Route::resource('task', 'App\Http\Controllers\TaskController');
    });

    <!--! - create front route and controller -->

    <!-- add front-end controller -->
       public function index()
    {
        $tasks = ModelsTask::all();
        return view('index',compact('tasks'));
    }



<!-- ========================= -->
<!-- ========================= -->

<!-- Other -->

For Authentication

1.	composer require Laravel/ui
2.	php artisan ui bootstrap –auth
    (Download node js LTS version)
3.	npm install
4.	npm run dev
5.	npm run build

<!-- ! For pagination -->
go to Controller and index function
 $contact= $contact->paginate (10);
and use it where you need like 
{{ $task->links() }}   

<!-- go to provider\appServiceProvider -->
 and add
call in top:-
use Illuminate\Pagination\paginator;
and 
 public function register()
    {
        paginator::useBootstrap();
    }


<!-- ! Laravel notification -->
laravel notify
or run the command
composer require mckenziearts/laravel-notify
add this provider to config/app.php
'providers' => [
    Mckenziearts\Notify\LaravelNotifyServiceProvider::class
];

<!-- publish vendor file -->
php artisan vendor:publish --provider="Mckenziearts\Notify\LaravelNotifyServiceProvider"
composer dump-autoload: refresh composer
composer dump-autoload 

<!-- include CSS and js file in the header and footer where you need of it -->
Add styles links with @notifyCss
Add scripts links with @notifyJs

@notifyCss
@notifyJs
notification code
<x:notify-messages /> OR @include('notify::components.notify')

<!-- add a message on the notification -->
public function store()
{
    notify()->success('Laravel Notify is awesome!');  use this 

    return Redirect::home();
}



For security:-  web.php
Front-end route
Route::resource('/portfolios', 'App\Http\Controllers\portfolioFrController');
Backend route
Route::prefix('/')->middleware('auth')->group(function () {
    Route::resource('admin/admin', 'App\Http\Controllers\AdminController');
});

<!-- ! Render data in the front end -->

Make front end controller 
Goto controller and
public function index()
    {
        $blogs = Blogs::all();
        return view('Company.blog', compact('blogs'));
    }

in front end page
<p> {{ $blogs->description }} </p>

To access image
<img src="{{ asset('uploads/' . $blog->img) }}" alt="" class="img-fluid">



