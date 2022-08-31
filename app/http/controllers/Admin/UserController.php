<?php
namespace App\Http\Controllers\Admin;

use App\Controller;
use App\Models\User;

use Slendie\Framework\Routing\Request;
use Slendie\Framework\Session\Flash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store()
    {
        $request = request();

        if ( $request->password != $request->password_confirmation ) {
            Flash::error('As passwords não conferem.');
            Flash::setFieldError('password_confirmation', 'A password não confere');
            return view('admin.users.create');
        }
        $user = new User();

        $found = $user->where('email', $request->email)->select()->get();

        if ( $found ) {
            Flash::error('Utilizador já existente.');
            Flash::setFieldError('email', 'E-mail já existente.');
            return view('admin.users.create');
        }

        $user->email  = $request->email;
        $user->password = password_hash( $request->password, PASSWORD_BCRYPT );
        $user->name = $request->name;
        $user->save();

        Flash::success('Utilizador criado com sucesso.');

        return redirect('users.index');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update($id)
    {
        $request = Request::getInstance();

        $user = User::find($id);

        if ( $request->password != '' && ( $request->password != $request->password_confirmation ) ) {
            Flash::error('As passwords não conferem.');
            Flash::setFieldError('password_confirmation', 'A password não confere');
            return view('admin.users.edit', compact('user'));
        }
        
        $verify_user = new User();

        $check_user = $verify_user->where('email', $request->email)->select()->get();

        // dd('UserController::update', $check_user, $verify_user);

        if ( $check_user ) {
            if ( $check_user->id != $user->id ) {
                Flash::error('E-mail não disponível para atualização.');
                Flash::setFieldError('email', 'E-mail já está em uso.');
                return view('admin.users.edit', compact('user'));
            }
        }

        $user->email  = $request->email;
        $user->name = $request->name;

        if ( $request->password != '' ) {
            $user->password = password_hash( $request->password, PASSWORD_BCRYPT );
        }

        $user->save();

        Flash::success('Utilizador atualizado com sucesso.');

        return redirect('users.index');
    }

    public function delete($id)
    {
        $request = Request::getInstance();

        $user = User::find($id);
        $user->delete();
        
        return redirect('users.index');
    }
}