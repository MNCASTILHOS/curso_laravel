<table>
    <thead>
        <tr>
            <th>Título</th>
            <th>Título</th>
        </tr>
    </thead>
        @foreach ($noticias as $noticia )
            <tr>
                <td>{{ $noticia->titulo }}</td>
                <td>{{ $noticia->noticia }}</td>
            </tr>            
        @endforeach

    <tbody>

    </tbody>
</table>