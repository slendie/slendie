@extends('admin.layouts.admin')
@section('content')
                    <h1 class="mt-4">Cards</h1>
                    <p>Manage your cards</p>
                    @include('partials.alert')
                    <a class="btn btn-primary" href=" @route('cards.create')">Novo cartão</a><br>
                    {% if $cards %}
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% if $cards %}
                            {% foreach ($cards as $card) %}
                            <tr>
                                <td>{{ $card->title }}</td>
                                <td>
                                    <a class="text-primary" href="@route('cards.edit', ['id' => $card->id])">Edit</a>
                                    <form action="@route('cards.delete', ['id' => $card->id])" method="POST" id="form-{{ $card->id }}" style="display: inline;">
                                    <a class="text-danger" href="#" onclick="submitForm('form-{{ $card->id }}')">Delete</a>
                                    </form>
                                </td>
                            </tr>
                            {% endforeach %}
                            {% endif %}
                        </tbody>
                    </table>
                    {% else %}
                    <p class="mt-3">Não há cartões criados. Esqueceu-se de algo?</p>
                    {% endif %}
@endsection
@section('scripts')
<script>
function submitForm( formId )
{
    var form = document.getElementById(formId);
    form.submit();
}
</script>
@endsection