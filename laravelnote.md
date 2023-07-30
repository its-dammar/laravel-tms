Create a Laravel project 

1.Create a database:- project

2.Create a project
composer create-project –prefer-dist laravel/laravel project

3.Generate key :- php artisan serve key:generate

4.Update .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project
DB_USERNAME=root
DB_PASSWORD=

5.Create a model, a controller, and a migration (table)
if you want to create separate 
model:- php artisan make model
controller:- php artisan make:controller TaskController --resource
Migration:- php artisan make:migration create_tasks_table

OR 
create mode, controller, and migration at a time, use this command
php artisan make:model Task –migration –controller –resource

6.Add field name in the table
go to database/migration/ your table
 $table->id();
            $table->string('title');
            $table->string('description');
            $table->timestamps();

7.Add fields in the model also
protected $fillable = [
        'title',
        'description',
   	 ];
Migrate table 
php artisan migrate
if come some error do this
go to App\Providers\AppServiceProvider.php
call in top
use Illuminate\Support\Facades\Schema;
public function boot(){

Schema::defaultStringLength(191);
}

8.Add Resource Route
Go to resource route/web.php
Call in top
use App\Http\Controllers\ProductController;
Route::resource(task, ProductController::class);
OR
Route::resource(‘task’,’App\Http\Controllers\TaskController’);

9.Create files
go to resource\views
create a folder:- tasks
inside the tasks, folder create the following files
a. index.blace.php :- for managing data ( tabular for data: table)

   <tbody>
                @foreach ($task as $tasks)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td> {{$tasks->title}} </td>
                    <td> {{$tasks->description}} </td>
                    <td>
                    <a class="btn btn-primary btn-sm " href="{{route('task.edit', $tasks->id)}}"   role="button"> Edit</a>
                    <a class="btn btn-info btn-sm " href="{{route('task.show', $tasks->id)}}" role="button"> View</a>
                    <!-- Modal trigger button -->
                    <button type="button" class="btn btn-sm btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#modalId">
                      Delete
                    </button>

                    <!-- Modal Body -->
                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                    <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTitleId">Do you want to delete data?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancle</button>
                                    <button type="button" class="btn btn-sm btn-danger">
                                        <form action="{{route('task.destroy', $tasks->id)}}" method="POST" enctype="multipart/form-data">
                                            @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger" type="submit">Delete</button>
                                        @csrf
                                        </form> 
                                    </button>
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

b. create.blade.php:- for adding data

  <form action="{{route('task.store')}}" method="POST" enctype="multipart/form-data " class="row g-3 needs-validation" novalidate>
                    <div class="col-md-12">
                        <label for="validationCustom01" class="form-label">First name</label>
                        <input type="text" class="form-control" id="validationCustom01" value="" name="title" >
                    </div>
                    <div class="col-md-12">
                        <label for="validationCustom02" class="form-label">Last name</label>
                        <input type="text" class="form-control" id="validationCustom02" value="" name="description">
</div>
<div class="col-12 text-end">
<button class="btn btn-primary" type="submit" name="submit">Submit form</button>
</div>
@csrf
 </form>



c. show.blade.php :- view data
<form action="{{route('task.update', $task->id)}}" method="POST" enctype="multipart/form-data " class="row g-3 needs-validation" novalidate>
                    <div class="col-md-12">
                        <label for="validationCustom01" class="form-label">First name</label>
                        <input type="text" class="form-control" id="validationCustom01" value="{{$task->title}}" name="title" >
                    </div>
                    <div class="col-md-12">
                        <label for="validationCustom02" class="form-label">Last name</label>
                        <input type="text" class="form-control" id="validationCustom02" value="{{$task->description}}" name="description" >
                    </div>
                    @csrf

                </form>

d. edit.blade.php :- edit data 
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
                    @csrf
                        <button class="btn btn-primary" type="submit" name="submit">Submit form</button>

                </form>



10.Go to the controller 
app\http\controller\ taskController
call in top:-  
use App\Models\task;

public function index()
    {
        $task = new task;
        $task= $task->get();
        return view('tasks.index', compact('task'));
    }

    public function create()
    {
        return view('tasks.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'description'=>'required',
        ]);
        $task= new task;
        $task->title=$request->title;
        $task->description=$request->description;
        $task->save();
        return redirect('task');
    }


    public function show($id)
    {
        $task = new Task;
        $task =$task->where('id', $id)->first();
        return view('tasks.show', compact('task'));
    }


    public function edit($id)
    {
        $task = new Task;
        $task =$task->where('id', $id)->first();
        return view('tasks.edit', compact('task'));

    }

  
    public function update(Request $request, $id)
    {
        $task = new Task;
        $task=  $task->where('id', $id)->first();
         $task ->title= $request->title;
         $task ->description= $request->description;
         $task->update();

         return redirect('task');

    }

  
    public function destroy($id)
    {
        $task = new Task;
        $task=  $task->where('id', $id)->first();
        $task->delete();
        return redirect('task');
    }

11. Php artisan serve

http://127.0.0.1:8000/task/create
where task is route name and create is create route


To submit file
Create file:- resource\views 
create folder filemanager
and create a file 
create.blace.php
<form action="{{ route('file.index') }}" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="formFile" class="form-label">Choose file</label>
            <input class="form-control" type="file" id="formFile" name="filelink">
        </div>
        <div class="button">
            <button type="submit" name="submit" class="btn btn-sm btn-primary"> submit</button>
        </div>
       </form>
make controller, model, migration 
add field
add the fields in the model
make route



 and got controller
public function index()
    {
        $files = new Files;
        $files = $files->paginate(4);
        return view('Company.admin.Files.index', compact('files'));
    }

    public function create()
    {
        return view('Company.admin.Files.create');
    }
    public function store(Request $request)
    {
        $files = new Files;
        $validate_data = $request->validate(
            [
                'title' => 'required',
                'img' => 'required',
            ]
        );
        $fileName = $request->id . '-' . time() . '.' . $request->img->extension();
        $request->img->move(public_path('uploads'), $fileName);
        $files->title = $request->title;
        $files->img = $fileName;

        $files->save();
        return redirect('admin/file')->with('message', 'Your data is submitted ');
    }
    public function show($id)
    {
        $files = new Files;
        $files = $files->where('id', $id)->First();
        return view('Company.admin.Files.show', compact('files'));
    }

    public function edit($id)
    {
        $files = new Files;
        $files = $files->where('id', $id)->First();
        return view('Company.admin.Files.edit', compact('files'));
    }

    public function update(Request $request, $id)
    {
        $files = new Files;
        $files = $files->where('id', $id)->First();
        $files->title = $request->title;
        if ($request->img != NULL) {
            $fileName = $request->course_code . "-" . time() . '.' . $request->img->extension();
            File::delete(public_path('uploads/' . $files->img));
            $request->img->move(public_path('uploads'), $fileName);
            $files::where('id', $id)
                ->update([
                    'img' => $fileName,
                ]);
        }
        $files->update();
        return redirect('admin/file');
    }
    public function destroy($id)
    {
        $files = new Files;
        $files = $files->where('id', $id);
        File::delete(public_path('uploads/' . $files->img));
        $files->delete();

        return redirect('admin/file')->with('message', 'Your data has been deleted');
    }



For Authentication

1.composer require Laravel/ui
2.php artisan ui bootstrap –auth
(Download node js LTS version)
3.npm install
4.npm run dev
5.npm run build

For pagination
go to Controller and index function
 $contact= $contact->paginate (10);
and use it where you need like 
{{ $task->links() }}   

go to provider\appServiceProvider
 and add
call in top:-
use Illuminate\Pagination\paginator;
and 
 public function register()
    {
        paginator::useBootstrap();
    }


Laravel notification
laravel notify
or run the command
composer require mckenziearts/laravel-notify
add this provider to config/app.php
'providers' => [
    Mckenziearts\Notify\LaravelNotifyServiceProvider::class
];

publish vendor file
php artisan vendor:publish --provider="Mckenziearts\Notify\LaravelNotifyServiceProvider"
composer dump-autoload: refresh composer
composer dump-autoload 

include CSS and js file in the header and footer where you need of it
Add styles links with @notifyCss
Add scripts links with @notifyJs

@notifyCss
@notifyJs
notification code
<x:notify-messages /> OR @include('notify::components.notify')

add a message on the notification
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

Render data in the front end

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