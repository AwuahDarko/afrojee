<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    
    public function index(){

        return view('frontend.partials.questions');
    }
}
