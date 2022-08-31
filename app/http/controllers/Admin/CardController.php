<?php
namespace App\Http\Controllers\Admin;

use App\Controller;
use App\Models\Card;

use Slendie\Framework\Routing\Request;
use Slendie\Framework\Session\Flash;

class CardController extends Controller
{
    public function index()
    {
        $cards = Card::all();
        return view('admin.cards.index', compact('cards'));
    }

    public function create()
    {
        return view('admin.cards.create');
    }

    public function store()
    {
        $request = request();

        if ( empty($request->title) ) {
            Flash::error('O título não pode estar vazio.');
            Flash::setFieldError('title', 'O título é de preenchimento obrigatório.');
            return view('admin.cards.create');
        }
        if ( empty($request->resume) ) {
            Flash::error('O resumo não pode estar vazio.');
            Flash::setFieldError('resume', 'O resumo é de preenchimento obrigatório.');
            return view('admin.cards.create');
        }
        if ( empty($request->content) ) {
            Flash::error('O conteúdo não pode estar vazio.');
            Flash::setFieldError('content', 'O conteúdo é de preenchimento obrigatório.');
            return view('admin.cards.create');
        }

        $slug = slugify( $request->title );
        // $check = (new Card())->where('slug', $slug)->select()->get();
        $check = (new Card())->fromSlug( $slug );
        $i = 0;
        while( $check ) {
            $i++;
            $slug = slugify( $request->title ) . '-' . $i;
            // $check = (new Card())->where('slug', $slug)->select()->get();
            $check = (new Card())->fromSlug( $slug );
        }

        $card = new Card();
        $card->title  = $request->title;
        $card->slug = $slug;
        $card->resume  = $request->resume;
        $card->content  = $request->content;
        $card->save();

        Flash::success('Cartão criado com sucesso.');

        return redirect('cards.index');
    }

    public function edit($id)
    {
        $card = Card::find($id);
        return view('admin.cards.edit', compact('card'));
    }

    public function update($id)
    {
        $request = Request::getInstance();

        $card = Card::find($id);

        if ( empty($request->title) ) {
            Flash::error('O título não pode estar vazio.');
            Flash::setFieldError('title', 'O título é de preenchimento obrigatório.');
            return view('admin.cards.edit', compact('card'));
        }
        if ( empty($request->resume) ) {
            Flash::error('O resumo não pode estar vazio.');
            Flash::setFieldError('resume', 'O resumo é de preenchimento obrigatório.');
            return view('admin.cards.edit', compact('card'));
        }
        if ( empty($request->content) ) {
            Flash::error('O conteúdo não pode estar vazio.');
            Flash::setFieldError('content', 'O conteúdo é de preenchimento obrigatório.');
            return view('admin.cards.edit', compact('card'));
        }

        $card->title  = $request->title;

        $slug = slugify( $request->title );
        // $check = (new Card())->where('slug', $slug)->whereNot('id', $card->id)->select()->get();
        $check = (new Card())->fromSlug( $slug );
        $i = 0;
        while( $check ) {
            $i++;
            $slug = slugify( $request->title ) . '-' . $i;
            // $check = (new Card())->where('slug', $slug)->select()->get();
            $check = (new Card())->exclusiveSlug( $slug, $id );
        }

        $card->slug = $slug;
        $card->resume  = $request->resume;
        $card->content  = $request->content;
        $card->save();

        Flash::success('Cartão atualizado com sucesso.');

        return redirect('cards.index');
    }

    public function delete($id)
    {
        $request = Request::getInstance();

        $card = Card::find($id);
        $card->delete();
        
        Flash::success('Cartão eliminado com sucesso.');

        return redirect('cards.index');
    }

    public function show($slug)
    {
        // $card = Card::find($id);
        $card = (new Card())->where('slug', $slug)->select()->get();

        return view('admin.cards.show', compact('card'));
    }

}