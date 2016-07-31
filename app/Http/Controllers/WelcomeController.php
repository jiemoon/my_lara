<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Container\Container;
use App\Models\Student;

class WelcomeController extends Controller
{
    public function index()
    {
        $student = Student::first();
        $data = $student->getAttributes();

        $app = Container::getInstance();
        $factory = $app->make('view');
        return $factory->make('welcome')->with('data', $data);
        // return "学生 id = {$data['id']}; name = {$data['name']}; age = {$data['age']}";
    }
}